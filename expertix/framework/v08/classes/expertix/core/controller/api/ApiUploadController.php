<?php

namespace Expertix\Core\Controller\Api;

use Expertix\Core\Controller\Base\BaseApiController;
use Expertix\Core\Exception\AppException;
use Expertix\Core\User\Exception\WrongUserException;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Upload\UploadManager;

class ApiUploadController extends BaseApiController
{
	public function onCreate()
	{
		$this->addRoute("upload_profile_img", "uploadProfileImg");
		$this->addRoute("upload_product_img", "uploadProductImg");
		$this->addRoute("upload_meeting_img", "uploadMeetingImg");
	}

	
	public function uploadProfileImg($request){
		$userId = $request->get("userId");
		$objectId = $request->get("objectId");
		
		return $this->uploadObjectImg($userId, "app_user", $objectId, "userId");		
	}

	public function uploadProductImg($request)
	{
		$userId = $request->get("userId");
		$objectId = $request->get("objectId");

		return $this->uploadObjectImg($userId, "store_product", $objectId, "productId");
	}
	public function uploadMeetingImg($request)
	{
		$userId = $request->get("userId");
		$objectId = $request->get("objectId");

		return $this->uploadObjectImg($userId, "srv_meeting", $objectId, "meetingId");
	}
	protected function uploadObjectImg($userId, $table, $objectId, $objectIdField)
	{
		$uploadModel = new UploadManager();
		return $uploadModel->uploadFiles($userId, $table, $objectId, $objectIdField);
	}

	
}