<?php

namespace Expertix\Module\Startup\Project;

use Expertix\Module\Startup\Project\ProjectModel;
use Expertix\Core\Controller\Base\BaseApiController;
use Expertix\Core\Db\SqlFilter;
use Expertix\Core\Util\Log;

class ApiProjectController extends BaseApiController
{
	protected function onCreate()
	{
		parent::onCreate();
		$this->addRoute("project_create", "createProject");
		$this->addRoute("project_update", "updateProject");
		$this->addRoute("project_delete", "deleteProject");

		$this->addRoute("project_update_likes", "updateLike");
		$this->addRoute("project_update_dislikes", "updateDisLike");
		$this->addRoute("project_update_fav", "updateFav");
		$this->addRoute("project_update_canhelp", "updateCanHelp");
		
		$this->addRoute("project_get_list", "getProjectList");
		$this->addRoute("project_get", "getProjectWithItemList");

		$this->addRoute("project_item_create", "createItemForProject");
		$this->addRoute("project_item_delete", "deleteItemForProject");
		$this->addRoute("project_action_get_list", "getItemListForProject");
		
		$this->addRoute("project_checkin", "checkinForEvent");
		$this->addRoute("project_checkin_get_all", "getCheckinList");
		
	}
	private function getModel()
	{
		return new ProjectModel();
	}
	private function getChildModel()
	{
		return new ProjectModel();
	}
	
	public function checkinForEvent($request){
		$model = $this->getModel();
		$model->checkinForEvent($request);
		return $model->getCheckinList($request);
	}
	public function getCheckinList($request)
	{
		$model = $this->getModel();
		return $model->getCheckinList($request);
	}

	public function getProjectList($request)
	{
		$model = $this->getModel();
		$filter = new SqlFilter($request);
		return $model->getCrudCollection($request);
	}
	public function getProject($request)
	{
		$model = $this->getModel();
		$key = $request->getRequired("key");
		$dataObject = $model->getCrudObject($key);
		if(!$dataObject){
			throw new \Exception("Не найдены данные для ключа $key", 1);
		}
		return $dataObject;
	}
	public function getProjectWithItemList($request)
	{
		$dataObject = $this->getProject($request);
		$dataObjectId = $dataObject->getId();
		Log::d("getProjectWithItemList object:", $dataObject->getArray());
				
		$childList = $this->getProjectChildList($dataObjectId, "getActionListForProject");
		$dataObject->set("childs", $childList);
		return $dataObject;
	}
	private function getProjectChildList($dataObjectId, $getChildsFunc)
	{
		$childModel = $this->getChildModel();
		$childList = $childModel->$getChildsFunc($dataObjectId);
		Log::d("getProjectChildList", $childList, 0);
		return $childList;
	}
	
	//
	public function getItemListForProject($request)
	{
		$key = $request->get("key", $request->get("parentKey"));
		if (!$key) {
			throw new \Exception("Не указан параметр key", 1);
		}
		$request->set("key", $key);
		$obj = $this->getProjectWithItemList($request);
		return $obj->get("childs");

//		$model = $this->getModel();
//		$dataObjectId = $model->getIdByKey($key);
//		return $this->getProjectChildList($dataObjectId, "getProjectListForProject");
	}
	

	
	// Create update

	public function createProject($request)
	{
		$userId = $this->getUserId();
		$model = $this->getModel();
		return $model->create($request, $userId);
	}
	public function updateProject($request)
	{
		$model = $this->getModel();
		$key = $request->getRequired("key");

		return $model->update($request, $key);
	}
	public function updateLike($request)
	{
		$model = $this->getModel();
		return $model->updateLike($request, "likes");
	}
	public function updateDislike($request)
	{
		$model = $this->getModel();

		return $model->updateLike($request, "dislikes");
	}
	public function updateFav($request)
	{
		$model = $this->getModel();
		$userId = $this->getUserId();
		$action = $request->getRequired("action");
		return $model->updateAction($request, $action, $userId);
	}
	public function updateCanHelp($request)
	{
		$model = $this->getModel();
		$userId = $this->getUserId();
		$action = $request->getRequired("action");
		return $model->updateAction($request, $action, $userId);
	}
	public function deleteProject($request)
	{
		$model = $this->getModel();
		$key = $request->get("key");
		return $model->hide($key);
	}

	// Create Update For childs

	
	public function createProjectForProject($request)
	{
		$model = $this->getModel();
		$modelChild = $this->getChildModel();

		if (!$request->get("relParentId")) {
			$projectKey = $request->getRequired("parentKey");
			$projectId = $model->getIdByKey($projectKey);
			$request->set("relParentId", $projectId);
		}

		return $modelChild->createUpdateProject($request, "create");
	}
	public function deleteProjectForProject($request)
	{
		$model = $this->getChildModel();
		$key = $request->get("key");
		return $model->deleteProject($key);
	}
}
