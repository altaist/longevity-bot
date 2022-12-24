<?php
namespace Expertix\Core\User;

use Expertix\Core\Db\DB;
use Expertix\Core\User\Exception\WrongUserException;
use Expertix\Core\Util\Log;

class UserModelAuth extends UserModel
{
	static $confirmCodeExpiresDays = 3;

	/**
	 *  Auth by login and password 
	 */
	public function authByPassword($login, $password)
	{
		$resultArr = $this->getUserByLogin($login);
		if(!$resultArr){
			throw new WrongUserException("Не найден пользователь с переданным логином и паролем", 1, "Не найден логин $login", $login);
		}
		
		if(!$this->checkPassword($resultArr, $password)){
			throw new WrongUserException("Не найден пользователь с переданным логином и паролем", 1, "Не найден пароль $password", $password);
		};
		
		return $this->prepareUser($resultArr);
	}
	
	protected function checkPassword($userArr, $password)
	{
		if(!isset($userArr["password"])) return false;
		return AuthHelper::comparePassword($password, $userArr);
	}


	/**
	 *  Auth by link
	 */
	public function authByLink($link)
	{
		return $this->prepareUser($this->getUserByLink($link));
	}
	public function authByKey($key)
	{
		return $this->prepareUser($this->getUserByKey($key));		
	}
	
	

	//
	protected function prepareUser($userArr)
	{
//		Log::d("Model: prepare user:", $userArr);
		if($userArr==null){
			return null;
		}
		$user = new User($userArr);
		$user->removeField("authLink");
		$user->removeField("password");
		$user->removeField("salt");
		$user->removeField("personId");

		return $user;
	}

	
	// User low code


	// Person low code
	public function getPersonByUser($user)
	{
		return $this->getPersonById($user->getId());
	}
	public function getPersonById($personId){
		
	}
	
	protected function preparePerson($_person){
		$person = $_person;
		return $person;
	}

	
}
