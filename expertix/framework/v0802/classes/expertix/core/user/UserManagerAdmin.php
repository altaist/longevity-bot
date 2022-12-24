<?php
namespace Expertix\Core\User;

use Expertix\Core\Controller\Api\ApiEmailController;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;

class UserManagerAdmin extends UserManager{

	public function getUserModelAdmin()
	{
		return new UserModelAdmin();
	}

	// Create Update
	public function createUser($param)
	{
		$request = null;
		if (is_string($param)) {
			$request = new ArrayWrapper(["name" => $param]);
		} else if(is_array($param)) {
			$request = new ArrayWrapper($param);
		}else {
			$request = $param;
		}

		$request = $this->createDefaultParams($request);

		$userCreator = new UserModelAdmin();
		$userKey = $userCreator->createUser($request);

		return $userKey;
	}
	
	
	public function createUserAndAuth($request){
		$userKey = $this->createUser($request);
		return $this->authByKey($userKey);
	}
	
	
	
	//
	function createAffLink($userId, $request)
	{
		$affHelper = new AffHelper();
		$affKey = $request->get("aff");
		if ($affKey) {
			$affHelper->createAffLinkForNewUser($userId, $affKey);
		}
	}
	
	
	/**
	 * 
	 */
	
	private function createDefaultParams($request)
	{
		return $request;
	}
}
