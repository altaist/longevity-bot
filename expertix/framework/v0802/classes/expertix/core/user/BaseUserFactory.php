<?php
namespace Expertix\Core\User;

use Expertix\Core\User\Exception\WrongUserException;

class BaseUserFactory implements IUserFactory{
	
	function createUser($user){
		try {
			$jsonDataStr = $user->get("jsonData");
			$user->set("jsonDataStr", $jsonDataStr);
			$user->set("jsonData", json_decode($jsonDataStr));
			$user->set("password", "");
			$user->setAuthLink($user->get("authLink", ""));
			$user->set("authLink", "");
		} catch (\Throwable $th) {
			//throw $th;
		}
		return $user;
	}
	
}