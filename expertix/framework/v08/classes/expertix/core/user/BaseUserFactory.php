<?php
namespace Expertix\Core\User;

use Expertix\Core\User\Exception\WrongUserException;

class BaseUserFactory implements IUserFactory{
	
	function createUser($user){
		try {
			$jsonDataStr = $user->get("jsonData");
			$user->set("jsonDataStr", $jsonDataStr);
			$user->set("jsonData", json_decode($jsonDataStr));
		} catch (\Throwable $th) {
			//throw $th;
		}
		return $user;
	}
	
}