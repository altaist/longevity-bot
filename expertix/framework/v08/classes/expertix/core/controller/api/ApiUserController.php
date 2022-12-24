<?php

namespace Expertix\Core\Controller\Api;

use Expertix\Core\Controller\Base\BaseApiController;
use Expertix\Core\User\Exception\WrongUserException;
use Expertix\Core\User\UserManagerAdmin;
use Expertix\Core\User\UserModel;
use Expertix\Core\User\UserModelAdmin;
use Expertix\Core\Util\Log;
use Expertix\Core\Util\Upload\UploadManager;

class ApiUserController extends BaseApiController
{
	protected function onCreate()
	{
		$this->addRoute("user_get_all", "getUserList");

		$this->addRoute("user_create", "createUser");
		$this->addRoute("user_update", "updateProfile", 1);
		$this->addRoute("user_update_client", "updateProfile", 1);
		$this->addRoute("user_update_extra", "updateProfileExtra", 1);
		$this->addRoute("user_hide", "hideUser", 5);
		$this->addRoute("user_update_priv", "updatePrivelegies", 10);
		
		$this->addRoute("user_remove_img", "removeUserImg");
	}
	
	public function getUserModel(){
		return new UserModelAdmin();
	}
	public function getUserManagerAdmin()
	{
		$userManager = new UserManagerAdmin($this->getAuthConfig());
		return $userManager;
	}
	
	public function getUserList($request){
		$userModel = $this->getUserModel();
		return $userModel->getUsersAll($request);
	}
	public function createUser($request)
	{
		$userManager = $this->getUserManagerAdmin();
		$user = $userManager->createUser($request);
		return $user;
	}
	public function updateProfile($request)
	{
		$userModel = $this->getUserModel();
		return $userModel->updatePerson($request);
	}
	public function updateProfileExtra($request)
	{
		$userModel = $this->getUserModel();
		return $userModel->updatePersonExtra($request);
	}
	public function hideUser($request)
	{
		$userModel = $this->getUserModel();
		return $userModel->hide($request->get("userId"));
	}
	public function updatePrivelegies($request)
	{
		$userModel = $this->getUserModel();
		$userId = $request->get("userId");
		return $userModel->updatePrivelegies($request, $userId);
	}
	public function removeUserImg($request)
	{
		$userModel = $this->getUserModel();
		$uploadManger = new UploadManager();
		$userId = $request->get("userId");
		$user = $userModel->getRowById($userId);
		if(!$user){
			throw new WrongUserException("Неверный идентификатор пользователя", 1, "Неверный userId=$userId при попытке удалить img");
		}
		
		$oldKey = $user["img"];
		if($oldKey){
			try {
				$uploadManger->removeResource($oldKey);
			} catch (\Throwable $th) {
				throw $th;
			}
		}
		
		return $userModel->updateImgById($userId, "");
	}
	
	
}