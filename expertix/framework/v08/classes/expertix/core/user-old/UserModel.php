<?php
namespace Expertix\Core\User;

use Expertix\Core\Auth\AuthHelper;
use Expertix\Core\Auth\AuthModel;
use Expertix\Core\Db\DB;
use Expertix\Core\Data\BaseModel;
use Expertix\Core\User\Exception\WrongUserException;
use Expertix\Core\User\Exception\DuplicateUserException;
use Expertix\Core\Util\Log;
use Expertix\Core\util\MyLog;
use Expertix\Core\Util\Utils;

class UserModel extends BaseModel
{
	function checkDublicates($objectKey, $email, $tel, $socials)
	{
		if ($email) {
			$resultKey = DB::getValue("select userKey from app_user where email=? and email is not null", [$email], null);
			if ($resultKey && (!$objectKey || $resultKey!=$objectKey)) {
				throw new DuplicateUserException("Дублирующийся адрес электронной почты", 1, $resultKey);
			}
		}
		if ($socials) {
			$resultKey = DB::getValue("select userKey from app_user where social=? and social is not null", [$socials], 0);
			if ($resultKey && (!$objectKey || $resultKey != $objectKey)) {
				throw new DuplicateUserException("Дублирующийся адрес соцсетей", 1, $resultKey);
			}
		}
		if ($tel) {
			$resultKey = DB::getValue("select userKey from app_user where tel=? and tel is not null", [$tel], 0);
			if ($resultKey && (!$objectKey || $resultKey != $objectKey)) {
				throw new DuplicateUserException("Дублирующийся телефон", 1, $resultKey);
			}
		}

		return null;
	}
	
	public function getUserIdByKey($key)
	{
		$sql = "select userId from app_user where userKey=?";
		$params = [$key];
		return DB::getValue($sql, $params);
	}
	function getUserSelectFields()
	{
		return "userId, userKey, firstName, middleName, lastName, age, gender, companyId, email, tel, social, address, region, jsonData, state, src, created ";
	}

	// USER CRUD
	public function getObject($key){
		return $this->getUserByKey($key);
	}
	public function getCollection($query, $orderBy){
		return $this->getUsers($query);
	}

	public function getUserById($userId)
	{
		$selectFields = $this->getUserSelectFields();
		$sql = "select $selectFields from app_user u user where u.userId=?";
		$params = [$userId];
		return DB::getRow($sql, $params);
	}
	public function getUserByKey($key)
	{
		$selectFields = $this->getUserSelectFields();
		$sql = "select $selectFields from app_user where userKey=?";
		$params = [$key];
		return DB::getRow($sql, $params);
	}
	public function getUserIdByAffKey($affKey)
	{
		$sql = "select userId from app_user where affKey=?";
		$affUserId = DB::getValue($sql, [$affKey]);
		return $affUserId;
	}
	
	public function getUsers($request)
	{
		$selectFields = $this->getUserSelectFields();
		$sql = "select $selectFields from app_user order by created desc";
		$params = [];
		return DB::getAll($sql, $params);
	}
	
	public function getUsersForAgency($agencyId){
		$selectFields = $this->getUserSelectFields();
		$sql = "select $selectFields from app_user inner join app_user_agency as a_u_a on a_u_a.userId=app_user.userId where a_u_a.agencyId=? order by userId desc";
		return DB::getAll($sql, [$agencyId]);
		
	}

	public function getUsersForCompany($companyId, $withDeleted = false)
	{
		$selectFields = $this->getUserSelectFields();
		$filterDeleted = " and isDeleted=0 ";
		$sql = "select $selectFields from app_user where companyId=? order by userId desc";
		return DB::getAll($sql, [$companyId]);
	}

	public function getUsersForRole($roleId)
	{
		$selectFields = $this->getUserSelectFields();
	}

	// CREATE UPDATE

	public function createUserWithAuth($request, $authMode)
	{
		
		try {
			Log::d("createUserWithAuth", $request);
			
			DB::beginTransaction();
			$userKey = $this->createUpdateUserData($request, self::MODE_CREATE);
			$userArray =  $this->getUserByKey($userKey);
			if (empty($userArray)) {
				throw new WrongUserException("Внутренняя ошибка при создании пользователя", 1);
			}

			// Create Auth
			$authArray = (new AuthHelper())->createAuth($userKey, $request, $authMode);
			
			$userArray["level"] = $authArray["level"];
			$userArray["role"] = $authArray["role"];

			// Process affiliate
			$affHelper = new AffHelper();
			$affKey = $request->get("aff");
			MyLog::d("AffKey in creating user", $userArray);
			if($affKey){
				$userId = $userArray["userId"];
				$affHelper->createAffLinkForNewUser($userId, $affKey);
			}
			
			DB::commit();
		} catch (\Exception $th) {
			DB::rollback();
			throw $th;
		}
		return $userArray;
	}	

	public function createUpdateUserData($request, $mode)
	{
		$email = $request->get("email");

		$firstName = $request->get("firstName", '');
		$middleName = $request->get("middleName", '');
		$lastName = $request->get("lastName", '');
		$age = $request->get("age", '');
		$gender = $request->get("gender", '');
		$companyId = $request->get("companyId", '');
		$tel = $request->get("tel", '');
		$social = $request->get("social", '');
		$address = $request->get("address", '');
		$region = $request->get("region", '');
		$jsonData = $request->get("jsonData", '');
		$activity = $request->get("activity", '');
		$state = $request->get("state", 0);
		$src = $request->get("src", '');

		if ($mode=="create") {
			$key = AuthHelper::createKey($firstName);
			$affKey = AuthHelper::createKey($firstName);

			$sql = "insert into app_user (firstName, middleName, lastName, age, gender, companyId, affKey, email, tel, social, address, region, jsonData, state, src, userKey) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$params = [$firstName, $middleName, $lastName, $age, $gender, $companyId, $affKey, $email, $tel, $social, $address, $region, $jsonData, $state, $src, $key];
			$userId = DB::add($sql, $params, __FUNCTION__);
			return $key;
		} else {
			$key = $this->getParamStrong($request, "key");
			$affKey = $request->get("affKey", "");

			$sql = "update app_user set firstName=?, middleName=?, lastName=?, age=?, gender=?, companyId=?, affKey=?, email=?, tel=?, social=?, address=?, region=?, jsonData=?, state=?, src=? where userKey=?";
			$params = [$firstName, $middleName, $lastName, $age, $gender, $companyId, $affKey, $email, $tel, $social, $address, $region, $jsonData, $state, $src, $key];
			DB::set($sql, $params, __FUNCTION__);
			return $key;
		}
	}

	public function changeEmail($key, $email)
	{
		return DB::set("update app_user set email=? where userKey=?", [$email, $key]);
	}


	public function delete($key)
	{
		return DB::set("delete from app_user where userKey=?", [$key]);
	}
	//
	//
	static function updateTestUserKey($user, $newKey)
	{
		$currentKey = Utils::getArrValue2($user, "authKey", "key", null);
		if (!$currentKey) {
			throw new WrongUserException("Empty auth key", 1);
		}
		$sql = "update app_auth set authKey=?, authLink=? where authKey=?";
		$params = [$newKey, $newKey, $currentKey];
		DB::set($sql, $params);

		$sql = "update app_user set userKey=? where userId=?";
		$params = [$newKey, $user["userId"]];
		DB::set($sql, $params);
	}

}
