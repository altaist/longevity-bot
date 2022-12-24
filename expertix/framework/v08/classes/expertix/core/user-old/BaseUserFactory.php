<?php
namespace Expertix\Core\User;

use Expertix\Core\User\Exception\WrongUserException;

class BaseUserFactory extends UserHelper implements IUserFactory{
	
	function createUser($authData){
		$model = $this->getUserModel();
		
		$key = $authData->get("userKey");
		
		// Load user
		$userArray = $model->getUserByKey($key);
		
		if(!$userArray){
			throw new WrongUserException("UserFactory - невозможно создать пользователя $key", 1);			
		}
		$user = new User($userArray);
		$userId = $user->getId();
		
		
		$user->set("authId", $authData->get("authId"));
		$user->set("login", $authData->get("login"));
		$user->set("role", $authData->get("role"));
		$user->set("level", $authData->get("level"));

		// Apply user with companyId and agencyId
		//$agencyId = $model->getUserAgencyId($userId);
		//$user->set("agencyId", $agencyId);
		
		return $user;
	}
	
}