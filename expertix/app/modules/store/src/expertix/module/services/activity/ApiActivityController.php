<?php

namespace Expertix\Module\Services\Activity;

use Expertix\Module\Services\Activity\ActivityModel;
use Expertix\Core\Controller\Base\BaseApiController;
use Expertix\Core\Db\SqlFilter;
use Expertix\Core\Util\Log;

class ApiActivityController extends BaseApiController
{
	protected function onCreate()
	{
		$this->addRoute("activity_create", "createActivity");
		$this->addRoute("activity_update", "updateActivity");
		$this->addRoute("activity_delete", "deleteActivity");
		
		$this->addRoute("activity_get_list", "getActivityList");
		$this->addRoute("activity_get", "getActivityWithItemList");

		$this->addRoute("activity_item_create", "createItemForActivity");
		$this->addRoute("activity_item_delete", "deleteItemForActivity");
		$this->addRoute("activity_item_get_list", "getItemListForActivity");
	}
	private function getModel()
	{
		return new ActivityModel();
	}
	private function getChildModel()
	{
		return new ActivityModel();
	}

	public function getActivityList($request)
	{
		$model = $this->getModel();
		$filter = new SqlFilter($request);
		return $model->getCollection($filter);
	}
	public function getActivity($request)
	{
		$model = $this->getModel();
		$key = $request->getRequired("key");
		$dataObject = $model->getCrudObject($key);
		if(!$dataObject){
			throw new \Exception("Не найдены данные для ключа $key", 1);
		}
		return $dataObject;
	}
	public function getActivityWithItemList($request)
	{
		$dataObject = $this->getActivity($request);
		$dataObjectId = $dataObject->getId();
				
		$childList = $this->getActivityChildList($dataObjectId, "getItemListForActivity");
		$dataObject->set("childs", $childList);
		return $dataObject;
	}
	public function getItemListForActivity($request)
	{
		$key = $request->get("key", $request->get("parentKey"));
		if (!$key) {
			throw new \Exception("Не указан параметр key", 1);
		}
		$request->set("key", $key);
		$obj = $this->getActivityWithItemList($request);
		return $obj->get("childs");

//		$model = $this->getModel();
//		$dataObjectId = $model->getIdByKey($key);
//		return $this->getActivityChildList($dataObjectId, "getActivityListForActivity");
	}
	
	private function getActivityChildList($dataObjectId, $getChildsFunc)
	{
		$childModel = $this->getChildModel();
		$childList = $childModel->$getChildsFunc($dataObjectId);
		Log::d("getActivityChildList", $childList, 0);
		return $childList;
	}
	
	// Create update

	public function createActivity($request)
	{
		$model = $this->getModel();
		return $model->create($request);
	}
	public function updateActivity($request)
	{
		$model = $this->getModel();
		$key = $request->getRequired("key");

		return $model->update($request, $key);
	}
	public function deleteActivity($request)
	{
		$model = $this->getModel();
		$key = $request->get("key");
		return $model->hide($key);
	}

	// Create Update For childs

	
	public function createActivityForActivity($request)
	{
		$model = $this->getModel();
		$modelChild = $this->getChildModel();

		if (!$request->get("relParentId")) {
			$activityKey = $request->getRequired("parentKey");
			$activityId = $model->getIdByKey($activityKey);
			$request->set("relParentId", $activityId);
		}

		return $modelChild->createUpdateActivity($request, "create");
	}
	public function deleteActivityForActivity($request)
	{
		$model = $this->getChildModel();
		$key = $request->get("key");
		return $model->deleteActivity($key);
	}
}
