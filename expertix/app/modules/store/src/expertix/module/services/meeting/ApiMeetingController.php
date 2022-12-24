<?php

namespace Expertix\Module\Services\Meeting;

use Expertix\Module\Services\Activity\ActivityModel;
use Expertix\Core\Controller\Base\BaseApiController;
use Expertix\Core\Db\SqlFilter;
use Expertix\Core\Util\Log;

class ApiMeetingController extends BaseApiController
{
	protected function onCreate()
	{
		$this->addRoute("meeting_create", "createMeeting");
		$this->addRoute("meeting_update", "updateMeeting");
		$this->addRoute("meeting_delete", "deleteMeeting");
		
		$this->addRoute("meeting_get_list", "getMeetingList");
		$this->addRoute("meeting_get", "getMeetingWithActivityList");

		$this->addRoute("meeting_activity_create", "createActivityForMeeting");
		$this->addRoute("meeting_activity_delete", "deleteActivityForMeeting");
		$this->addRoute("meeting_activity_get_list", "getActivityListForMeeting");
	}
	private function getModel()
	{
		return new MeetingModel();
	}
	private function getChildModel()
	{
		return new ActivityModel();
	}

	public function getMeetingList($request)
	{
		$model = $this->getModel();
		$filter = new SqlFilter($request);
		return $model->getCollection($filter);
	}
	public function getMeeting($request)
	{
		$model = $this->getModel();
		$key = $request->getRequired("key");
		$dataObject = $model->getCrudObject($key);
		if(!$dataObject){
			throw new \Exception("Не найдены данные для ключа $key", 1);
		}
		return $dataObject;
	}
	public function getMeetingWithActivityList($request)
	{
		$dataObject = $this->getMeeting($request);
		$dataObjectId = $dataObject->getId();
				
		$childList = $this->getMeetingChildList($dataObjectId, "getActivityListForMeeting");
		$dataObject->set("childs", $childList);
		return $dataObject;
	}
	public function getActivityListForMeeting($request)
	{
		$key = $request->get("key", $request->get("parentKey"));
		if (!$key) {
			throw new \Exception("Не указан параметр key", 1);
		}
		$request->set("key", $key);
		$obj = $this->getMeetingWithActivityList($request);
		return $obj->get("childs");

//		$model = $this->getModel();
//		$dataObjectId = $model->getIdByKey($key);
//		return $this->getMeetingChildList($dataObjectId, "getActivityListForMeeting");
	}
	
	private function getMeetingChildList($dataObjectId, $getChildsFunc)
	{
		$childModel = $this->getChildModel();
		$childList = $childModel->$getChildsFunc($dataObjectId);
		Log::d("getMeetingChildList", $childList, 0);
		return $childList;
	}
	
	// Create update

	public function createMeeting($request)
	{
		$model = $this->getModel();
		return $model->create($request);
	}
	public function updateMeeting($request)
	{
		$model = $this->getModel();
		$key = $request->getRequired("key");

		return $model->update($request, $key);
	}
	public function deleteMeeting($request)
	{
		$model = $this->getModel();
		$key = $request->get("key");
		return $model->hide($key);
	}

	// Create Update For childs

	
	public function createActivityForMeeting($request)
	{
		$model = $this->getModel();
		$modelChild = $this->getChildModel();

		if (!$request->get("relParentId")) {
			$meetingKey = $request->getRequired("parentKey");
			$meetingId = $model->getIdByKey($meetingKey);
			$request->set("relParentId", $meetingId);
		}

		return $modelChild->createUpdateActivity($request, "create");
	}
	public function deleteActivityForMeeting($request)
	{
		$model = $this->getChildModel();
		$key = $request->get("key");
		return $model->deleteActivity($key);
	}
}
