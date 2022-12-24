<?php

namespace Expertix\Module\Services\Service;

use Expertix\Module\Services\Meeting\MeetingModel;
use Expertix\Core\Controller\Base\BaseApiController;
use Expertix\Core\Db\SqlFilter;
use Expertix\Core\Util\Log;

class ApiServiceController extends BaseApiController
{
	protected function onCreate()
	{
		$this->addRoute("service_create", "createService");
		$this->addRoute("service_update", "updateService");
		$this->addRoute("service_delete", "deleteService");
		
		$this->addRoute("service_get_list", "getServiceList");
		$this->addRoute("service_get", "getServiceWithMeetingList");

		$this->addRoute("service_meeting_create", "createMeetingForService");
		$this->addRoute("service_meeting_delete", "deleteMeetingForService");
		$this->addRoute("service_meeting_get_list", "getMeetingListForService");
	}
	private function getModel()
	{
		return new ServiceModel();
	}
	private function getChildModel()
	{
		return new MeetingModel();
	}

	public function getServiceList($request)
	{
		$model = $this->getModel();
		$filter = new SqlFilter($request);
		return $model->getServiceList($filter);
	}
	public function getService($request)
	{
		$model = $this->getModel();
		$key = $request->getRequired("key");
		$dataObject = $model->getCrudObject($key);
		if(!$dataObject){
			throw new \Exception("Не найдены данные для ключа $key", 1);
		}
		return $dataObject;
	}
	public function getServiceWithMeetingList($request)
	{
		$dataObject = $this->getService($request);
		$dataObjectId = $dataObject->getId();
				
		$childList = $this->getServiceChildList($dataObjectId, "getMeetingListForService");
		$dataObject->set("childs", $childList);
		return $dataObject;
	}
	public function getMeetingListForService($request)
	{
		$key = $request->get("key", $request->get("parentKey"));
		if (!$key) {
			throw new \Exception("Не указан параметр key", 1);
		}
		$request->set("key", $key);
		$obj = $this->getServiceWithMeetingList($request);
		return $obj->get("childs");

//		$model = $this->getModel();
//		$dataObjectId = $model->getIdByKey($key);
//		return $this->getServiceChildList($dataObjectId, "getMeetingListForService");
	}
	
	private function getServiceChildList($dataObjectId, $getChildsFunc)
	{
		$childModel = $this->getChildModel();
		$childList = $childModel->$getChildsFunc($dataObjectId);
		//Log::d("getserviceWithServices", $product, 0);
		return $childList;
	}
	
	// Create update

	public function createService($request)
	{
		$model = $this->getModel();
		return $model->createUpdateService($request, "create");
	}
	public function updateService($request)
	{
		$model = $this->getModel();
		return $model->createUpdateService($request, "update");
	}
	public function deleteService($request)
	{
		$model = $this->getModel();
		$key = $request->get("key");
		return $model->deleteService($key);
	}

	// Create Update For childs

	
	public function createMeetingForService($request)
	{
		$model = $this->getModel();
		$modelChild = $this->getChildModel();
		$relParentId = $request->get("relParentId", null);
		
		if (!$relParentId) {
			$key = $request->getRequired("parentKey");
			$relParentId = $model->getIdByKey($key);
			//$request->set("serviceId", $serviceId);
		}

		return $modelChild->create($request, $relParentId);
	}
	public function deleteMeetingForService($request)
	{
		$model = $this->getChildModel();
		$key = $request->get("key");
		return $model->hide($key);
	}
}
