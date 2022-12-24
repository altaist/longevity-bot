<?php
namespace Expertix\Core\User\Aff;

use Expertix\Core\Db\DB;
use Expertix\Core\User\UserModel;

class AffHelper{
	const AFF_KEY_PARAM_NAME = "aff";
	public $affKeyParamName = self::AFF_KEY_PARAM_NAME;

	public function getAffPartnerForUser($userId, $action)
	{
		$sql = "select parentUserId from aff where aff.userId=? and $action=? and state=1";
		return DB::getRow($sql, [$userId, $action]);
	}

	public function getAffUsers($parentUserId, $action, $mode = 0)
	{
		$fields = "";
		if ($mode == 0) {
			$fields = "users.userKey";
		} else {
			$fields = "users.userId, users.lastName, users.firstName";
		}

		$sql = "select $fields from app_user inner join aff on aff.userId=users.userId where aff.parentUserId=? and aff.action=? and aff.state=1";
		return DB::getRow($sql, [$parentUserId, $action]);
	}

	public function getUserIdByAffKey($affKey)
	{
		$userModel = new UserModel();
		$userId = $userModel->getUserIdByAffKey($affKey);
		return $userId;
	}
	
	/**
	 * Process request for affiliate program params
	 * 	1. Looking for "aff" param in request with aff key
	 * 	2. Check if user exists in db for this aff key
	 * 	3. For existing user update link:
	 * 	3.1 Check if old aff links exists - setting them to innactive mode
	 * 	3.2 Insert new aff link if this users wasnt connected before
	 * 
	 *  Returns affKey, if request was correct or null if not
	 * 
	 */
	
	public function processAffByKey($user, String $affKey){
		if(!$affKey) return null;
		// Check if affKey is correct
		$parentUserId = $this->getUserIdByAffKey($affKey);
		if(!$parentUserId){
			return null;
		}

		// Update aff key registry
		if ($user) {
			$userId = $user->getId();
			$this->updateAffLink($userId, $parentUserId);
		}
		
		return $affKey;
	}

	public function processAffByRequest($user, $request)
	{
		$affKey = $request::getRequestParam($this->affKeyParamName);
		if (!$affKey) return null;

		return $this->processAffByKey($user, $affKey);
	}
		
	protected function updateAffLink($userId, $parentUserId){

		// check if aff is exists and active
		$sql = "select affId from aff where parentUserId=? and userId=? and action=? and state>?";
		$affId = DB::getValue($sql, [$parentUserId, $userId, 0, 0]);
		
		if($affId){
			return null;
		}
		
		// update active affs - deactivate (state for aff with action 'created' still eq 1)
		$sql = "update aff set state=0 where userId=? and action=?"; 
		DB::set($sql, [$userId, 0]);
	
		// insert new aff
		$sql = "insert into aff(parentUserId, userId, action, state) values(?, ?, ?, ?)";
		$params = [$parentUserId, $userId, 0, 1];
		$affId = DB::add($sql, $params);

		return $affId;
	}
	
	public function createAffLinkForNewUser($userId, $affKey){
		if(!$affKey) return null;
		
		// Check if affKey is correct
		$parentUserId = $this->getUserIdByAffKey($affKey);
		if (!$parentUserId) {
			return null;
		}
		
		// check if aff is exists
		$sql = "select affId from aff where userId=? and action=?";
		$affId = DB::getValue($sql, [$userId, 1]);

		if ($affId) {
			throw new \Exception("New user aff exists for user", 0);
		}

		// insert new aff
		$sql = "insert into aff(parentUserId, userId, action, state) values(?, ?, ?, ?)";
		$params = [$parentUserId, $userId, 1, 1];
		$affId = DB::add($sql, $params);

		return $affId;
	}	
}