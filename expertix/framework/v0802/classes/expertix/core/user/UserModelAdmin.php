<?php
namespace Expertix\Core\User;

use Expertix\Core\Db\DB;
use Expertix\Core\User\Exception\WrongUserException;
use Expertix\Core\Util\Log;

class UserModelAdmin extends UserModel{
	
	public function createUser($request){
		$userKey = null;
		try {
			Log::d("UserModelAdmin createUser", $request->getArray());

			DB::beginTransaction();
			$personId = $this->createPerson($request);
			if (empty($personId)) {
				throw new WrongUserException("Внутренняя ошибка при создании пользователя", 1, "Ошибка при создании Person");
			}

			// Create User
			$userKey = $this->createAuthUser($request, $personId);
			if (empty($userKey)) {
				throw new WrongUserException("Внутренняя ошибка при создании пользователя", 1, "Ошибка при создании User");
			}
			DB::commit();
		} catch (\Exception $th) {
			DB::rollback();
			throw $th;
		}
		return $userKey;
	}
	public function createAuthUser($request, $personId){
//		Log::d("createAuthUser", $request->getArray());

		$login = $request->get("login");
		$password = $request->get("password");
		$email = $request->get("email");
		
		$login = $login ? $login : AuthHelper::createAutoLogin($personId);
		$password = $password ? $password : AuthHelper::createAutoPassword($login);
		

		$encoded = AuthHelper::encrypt($password, ["login", "name"]);
		$password = $encoded[0];
		$salt = $encoded[1];

		$this->checkUnique("login", $login, -1, "В базе уже есть пользователь с таким логином");
		$this->checkUnique("email", $email, -1, "В базе уже есть пользователь с такой электронной почтой");
		
		$userKey = AuthHelper::createKey($email);
		$this->checkUnique("userKey", $userKey, -1, "Ошибка создания уникального идентификатора для userKey");

		$authLink = AuthHelper::createAuthLink($login, $password);
		$this->checkUnique("authLink", $authLink, -1, "Ошибка создания уникального идентификатора для authLink");
		
		$affKey = AuthHelper::createKey($password);
		$this->checkUnique("authLink", $authLink, -1, "Ошибка создания уникального идентификатора для affKey");
		
		$state = $request->get("state", 1);
//		$date = date("Y-m-d H:i:s");
		
		$name = $request->get("name", '');
		$companyId = $request->get("companyId", '');
		$state = $request->get("state", 1);
		$level = 1;
		$role = 1;
		$src = $request->get("src", '');

		$sql = "insert into app_user (userKey, personId, name, email, login, password, salt, authLink, affKey, companyId, state, level, role) values ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
		$params = [$userKey, $personId, $name, $email, $login, $password, $salt, $authLink, $affKey, $companyId,  $state, $level, $role];
		DB::add($sql, $params, __FUNCTION__);
		return $userKey;
	}
	
	public function createPerson($request){
		$email = $request->get("email");

		$firstName = $request->get("firstName", '');
		$middleName = $request->get("middleName", '');
		$lastName = $request->get("lastName", '');
		$age = $request->get("age", '');
		$gender = $request->get("gender", '');

		$tel = $request->get("tel", '');
		$social = $request->get("social", '');
		$address = $request->get("address", '');
		$region = $request->get("region", '');
		$jsonData = $request->get("jsonData", '');
		$state = $request->get("state", 0);
		$src = $request->get("src", '');

		$personId = AuthHelper::createKey($firstName);

		$sql = "insert into app_person(personId, lastName, firstName, middleName, age, gender, tel, social, address, region, jsonData, state, src) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$params = [$personId,$lastName, $firstName, $middleName, $age, $gender, $tel, $social, $address, $region, $jsonData, $state, $src];
		DB::add($sql, $params, __FUNCTION__);
		return $personId;		
	}
	
	public function updatePerson($request){
		// Person
		$userId = $request->required("userId");
		$personId = $request->required("personId");
		$firstName = $request->get("firstName", '');
		$middleName = $request->get("middleName", '');
		$lastName = $request->get("lastName", '');
		$age = $request->get("age", '');
		$birthday = $request->get("birthday", '');
		$gender = $request->get("gender", '');

		$tel = $request->get("tel", '');
		$address = $request->get("address", '');
		$vk = $request->get("vk");
		$fb = $request->get("fb");
		$insta = $request->get("insta");

		$parentsLastName = $request->get("parentsLastName", '');
		$parentsFirstName = $request->get("parentsFirstName", '');
		$parentsMiddleName = $request->get("parentsMiddleName", '');
		$parentsTel = $request->get("parentsTel", '');
		$parentsEmail = $request->get("parentsEmail", '');
		
		$org = $request->get("org");
		$department = $request->get("department");
		
		$comments = $request->get("comments");

		$sql = "update app_person set lastName=?, firstName=?, middleName=?, age=?, birthday=?, gender=?, tel=?, address=?, vk=?, fb=?, insta=?, parentsFirstName=?, parentsMiddleName=?, parentsLastName=?, parentsTel=?, parentsEmail=?, org=?, department=?, comments=? where personId=?";		
		$params = [$lastName, $firstName, $middleName, $age, $birthday, $gender, $tel, $address, $vk, $fb, $insta, $parentsFirstName, $parentsMiddleName, $parentsLastName, $parentsTel, $parentsEmail, $org, $department, $comments, $personId];
		DB::set($sql, $params);

		// Main user
		//$img = $request->get("img", '');
		//$sql = "update app_user set img=? where userId=?";
		//$params = [$img, $userId];
		//return DB::set($sql, $params);
		
		$email = $request->get("email");
		$this->updateEmail($email, $userId);
	}
	
	public function updatePwd($userId, $password){
		if(!$userId || !$password){
			throw new WrongUserException("Wrong userId", 1);
		}
		if (!$password) {
			throw new WrongUserException("Wrong password", 1);
		}

		$encoded = AuthHelper::encrypt($password, ["login", "name"]);
		$password = $encoded[0];
		$salt = $encoded[1];
		
		$sql = "update app_user set password=?, salt=? where userId=?";
		return DB::set($sql, [$password, $salt, $userId]);
	}
	
	public function updatePersonExtra($request){
		// Person
		$userId = $request->required("userId");
		$personId = $request->required("personId");
		$jsonData = $request->get("jsonData");
		$jsonDataStr = json_encode($jsonData);
		
		$sql = "update app_person set jsonData=? where personId=?";
		$params = [$jsonDataStr, $personId];
		return DB::set($sql, $params);
	}
	
	public function updatePrivelegies($request, $userId){
		$level = $request->get("level");
		$role = $request->get("role");
		$sql = "update app_user set level=?, role=? where userId=?";
		Log::d("updating priv: $level, $userId");
		return DB::set($sql, [$level, $role, $userId]);
	}
	public function updateState($request, $userId){
		$state = $request->get("state");
		$sql = "update app_user set state=? where userId=?";
		return DB::set($sql, [$state, $userId]);
	}
	
	public function updateEmail($email, $userId)
	{
		$this->checkUnique("email", $email, $userId, "В базе уже есть пользователь с такой электронной почтой");
		
		
		return DB::set("update app_user set email=? where userId=?", [$email, $userId]);
	}

	public function hide($id)
	{
		return DB::set("update app_user set state=0 where userId=?", [$id]);
	}

	public function delete($key)
	{
		return DB::set("delete from app_user where userKey=?", [$key]);
	}
	
}