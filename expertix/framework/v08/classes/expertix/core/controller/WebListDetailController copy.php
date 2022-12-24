<?php

namespace Expertix\Core\Controller;

use Expertix\Core\App\Request;
use Expertix\Core\Controller\Base\BaseController;
use Expertix\Core\Data\PageData;

class WebListDetailControllerCopy extends WebPageController 
{
	protected $dbDataObject;
	protected $dbDataCollection;
	private $objectId=-1;
	private $parentId=-1; 
	private $objectType=-1;

	public function process()
	{
		parent::processData();
		$this->loadData();
		
		if($this->pageData->getObject()){
			$this->getViewConfig()->set("page_auto", "details");
		}
		if($this->pageData->getCollection()){
			$this->getViewConfig()->set("page_auto", "list");
		}
		
		return parent::processView();
	}
	
	function loadData(){
		$pageData = $this->getPageData();
		$model = $pageData->getModel();
		if($model) return;
		
		$object = null;
		$list = null;
		$objectId = $pageData->getObjectId();
		if($objectId){
			try {
				$object = $model->getObject($objectId);
				if($object){
					$this->pageData->setDataObject($object);
				}
			} catch (\Throwable $th) {
				//throw $th;
			}
		}else{
			try {
				$list = $model->getCollection($objectId);
				if ($list) {
					$this->pageData->setDataCollection($list);
				}
				
			} catch (\Throwable $th) {
				//throw $th;
			}			
		}
		
	}

	function processOld()
	{
		$request = Request::getGet();
		
		$this->objectId = $this->detectQueryParam("objectId", 1);
		$this->parentId = $this->detectQueryParam("parentId", 2);
		$this->objectType = $this->detectQueryParam("objectType", 3);

//		MyLog::d("ObjectId:", $this->objectId, 1);
		$this->getPageData()->setObjectId($this->objectId);
		$this->getPageData()->set("parentId", $this->parentId);
		$this->getPageData()->set("objectType", $this->objectType);
				
		$this->processListDetail($request);
		return parent::process();
	}

	protected function detectQueryParam($fieldName, $paramNumber=0)
	{
		$controllerData = $this->getControllerConfig();

		// From controllerData
		if (!empty($controllerData[$fieldName])) {
			return $controllerData[$fieldName];
		}

		// From request
		if (!empty(Request::getRequestParam($fieldName))) {
			return Request::getRequestParam($fieldName);
		}

		// From url
		$level = empty($controllerData["level"]) ? 0 : $controllerData["level"];
		$urlParts = $controllerData["routeParts"]; // Params from url, first was a controller name

		if (empty($urlParts[$level + $paramNumber])) {
			return null;
		} else {
			$key = $urlParts[$level + $paramNumber];
			return $key;
		}
	}
	
	
	public function processListDetail($request)
	{
		$model = $this->getModel();
		if (!$model) return;

		// Detect params
		$modelConfig = $this->getConfigParam("model");
		$fieldNameObjectId =  Utils::getArrValue($modelConfig, "fieldNameObjectId", "objectId");
		$fieldNameObjectType = Utils::getArrValue($modelConfig, "fieldNameObjectType", "objectType");

		$this->objectId = $this->detectObjectId($request, $fieldNameObjectId);
		$this->objectType = $this->detectObjectType($request, $fieldNameObjectType);
		$request2 = [];



		if ($this->objectId) {
			$request2[$fieldNameObjectId] = $this->objectId;
		}
		if ($this->objectType) {
			$request2[$fieldNameObjectType] = $this->objectType;
		}

		// Process Data
		if ($this->objectId) {
			$data = $model->getObject(array_merge($request, $request2));
			$this->setDataObject($data);
			$this->getPageData()->setDataObject($data);
//			MyLog::d("ListDetail Object ID=".$this->objectId);
		} else {
			$data = $model->getCollection(array_merge($request, $request2));
			$this->setDataCollection($data);
			$this->getPageData()->setDataCollection($data);
		}

	}


	function detectObjectType($request, $fieldName)
	{

		$controllerData = $this->controllerData;

		// From controllerData
		if (!empty($controllerData["objectType"])) {
			return $controllerData["objectType"];
		}

		// From request
		if (!empty($request[$fieldName])) {
			return $request[$fieldName];
		}

		// From url
		$level = empty($controllerData["level"]) ? 0 : $controllerData["level"];
		$urlParts = $controllerData["routeParts"]; // Params from url, first was a controller name

		if (empty($urlParts[$level])) {
			return null;
		} else {
			$type = $urlParts[$level];
			return $type;
		}
	}
	function detectParentId($request)
	{
		$controllerData = $this->controllerData;
		$parentId = Utils::getParam($controllerData, "parentId", null);
		$parentId = Utils::getParam($request, "parentId", $parentId);
		return $parentId;
	}
	function queryCollection($request)
	{
		$model = $this->getModel();
		if (!$model) {
			return null;
		}

		return $model->getCollection($request);
	}

	function queryObject($request)
	{
		$model = $this->getModel();
		if (!$model) {
			return null;
		}

		return $model->getObject($request);
	}


	function setDataObject($data)
	{
		$this->dbDataObject = $data;
	}
	function getDataObject()
	{
		return $this->dbDataObject;
	}
	function setDataCollection($data)
	{
		$this->dbDataCollection = $data;
	}
	function getDataCollection()
	{
		return $this->dbDataCollection;
	}		
}