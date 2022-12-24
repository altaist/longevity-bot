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
	const ERR_NOT_FOUND = 404;
	const ERR_DUPLICATED = 100;
	
	
	const SELECT_FIELDS = "u.*, p.*";
	const SQL_SELECT1 = "select u.*, p.* from app_user u left join app_person p on u.personId=p.personId where 1=1 ";
	
	const SQL_SELECT2 = "select u.userId, u.email, u.role, u.level, u.authLink, person.* from app_user u left join app_person p on u.personId=p.personId where 1=1 ";
	const SQL_SELECT2_END = " order by u.userId desc";
	
	protected function setup(){
		$this->tableName = "app_user";
		$this->dataType="user";
		$this->keyField="userKey";		
	}
	
	protected function processResult($arr){
		$resultArr = $arr;
		if(isset($resultArr["password"])){
			$resultArr["password"] = "";
		}

		return $resultArr;
	}

	// Select one user by..
	
	public function getUserById($userId)
	{
		$sql = self::SQL_SELECT1." and userId=?";
		return $this->processResult(DB::getRow($sql, [$userId]));
	}
	public function getUserIdByKey($userKey)
	{
		$sql = " select userId from app_user where userKey=?";
		return $this->processResult(DB::getValue($sql, [$userKey]));
	}
	public function getUserByKey($userKey)
	{
		$sql = self::SQL_SELECT1." and userKey=?";
		return $this->processResult(DB::getRow($sql, [$userKey]));
	}
	public function getUserByLink($link)
	{
		$sql = self::SQL_SELECT1." and authLink=?";
	//	$sql = "select u.*, p.* from app_user u left join app_person p on u.personId=p.personId where authLink='nimbda'";
		$user = $this->processResult(DB::getRow($sql, [$link]));
		return $user;		
	}
	public function getUserByLogin($login)
	{
		$sql = self::SQL_SELECT1." and login=?";
		return $this->processResult(DB::getRow($sql, [$login]));
	}
	public function getUserByEmail($email)
	{
		$sql = self::SQL_SELECT1." and email=?";
		return $this->processResult(DB::getRow($sql, [$email]));
	}
	
	public function getUserByField($field, $value){
		$sql = self::SQL_SELECT1." and $field=?";
		return $this->processResult(DB::getRow($sql, [$value]));		
	}
	
	// External Select collections
	public function getUsersAll()
	{
		$sql = "select u.userId, person.*, u.img, u.email, u.role, u.level, u.authLink from app_person person inner join app_user u on u.personId=person.personId where u.state>0 order by u.userId desc";
		$params = [];
		$result = DB::getAll($sql, $params);
		return $result;
	}

	public function getUsersForCompany($companyId)
	{
		$sql = self::SQL_SELECT2 . " where state>0 and companyId=? {SQL_SELECT2_END}";
		return $this->processResult(DB::getRow($sql, [$companyId]));
	}


	// Check Restrictions
	protected function checkExistsLogin($login){
		return $this->checkExists("login", $login);
	}
	protected function checkExistsEmail($email){
		return $this->checkExists("email", $email);
	}

	protected function checkExists($field, $value, $userId=-1){
		$result = null;
		if ($userId >= 0) {
			$sql = "select userId from app_user where `$field`=? and userId!=?";
			//Log::d($sql);
			$result = DB::getAll($sql, [$value, $userId]);
		}else{
			$sql = "select userId from app_user where `$field`=?";
			//Log::d($sql);
			$result = DB::getAll($sql, [$value]);
			
		}
		if($result==null){
			return false;
		}
		return true;
	}
	protected function checkUnique($field, $value, $userId, $errorText= "Переданы не уникальные значения"){
		if ($this->checkExists($field, $value, $userId)) {
			throw new WrongUserException($errorText, 0, "Duplicated field $field with $value");
		}			
	}


	public function getUsersTest()
	{
		$result = [];
		for ($i = 0; $i < 10000; $i++) {
			$result[] = [
				"firstName" => "$i very long text",
				"lastName" => "$i very long text",


			];
		}
		return $result;
	}
	
	
}
