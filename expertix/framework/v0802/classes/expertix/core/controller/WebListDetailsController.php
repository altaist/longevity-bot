<?php

namespace Expertix\Core\Controller;

use Expertix\Core\App\AppContext;
use Expertix\Core\Data\BaseModel;
use Expertix\Core\Db\SqlFilter;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;

class WebListDetailsController extends WebPageController 
{
	const CRUD_MODE_DETAILS = "details";
	const CRUD_MODE_LIST = "list";
			
	protected $dbDataObject;
	protected $dbDataCollection;
	private $objectKey=-1;
	private $parentId=-1; 
	private $objectType=-1;

	
	function prepareData(){
		$viewConfig = $this->getViewConfig();
		$pageData = $this->getPageData();
		$model = $pageData->getModel();

		$object = null;
		$list = null;
		$objectKey = $pageData->getObjectId();

		//Log::d("ListDetails loadData for $objectKey");
		
		$isDetails = false;
		
		if($objectKey){
			$viewConfig->setIfEmpty("view_crud_mode", self::CRUD_MODE_DETAILS);
			$isDetails = true;
		}else{
			$viewConfig->setIfEmpty("view_crud_mode", self::CRUD_MODE_LIST);
		}
		
		if(!$model || !$model instanceof BaseModel){
//					Log::log($this, "Model isn't instance of IModelCrudRead");
		}else{
			
			if($objectKey){
				$object = $this->loadDataItem($objectKey, $model);
				if ($object) {
					$pageData->setDataObject($object);
				} else {
					AppContext::getApp()->redirect404();
				}
			}else{
				$list = $model->getCollection(new SqlFilter(["objectKey"=>$objectKey]));
				if ($list) {
					$pageData->setDataCollection($list);
				}
			}
		}
		
		
		
//		Log::d("ListDetailsController $objectKey", $object);
//		Log::d("ListDetailsController is details: $isDetails. Data for $objectKey:", $object);

		//Log::d("ListDetailsController config:", $this->getControllerConfig());

		// Auto detected page
		if ($isDetails) {
			$object = $pageData->getDataObject();

			// Detect viewKey from params and db(prior db)

			$viewKey = "details";
			$viewKey = $object? $object->get("viewKey", $viewKey) : $viewKey;
			$viewKey = $viewConfig->get("page_for_details", $viewKey);
			$viewKey = $pageData->get("viewKey", $viewKey);
			$pagePath = "details/$viewKey.php";
			$viewConfig->set("page_auto_detected", $pagePath);
			$viewConfig->set("page_js_auto_detected", $viewConfig->get("js_details", ""));
		}else{
			$viewKey = $pageData->get("viewKey", "list");
			$viewKey = $viewConfig->get("page_for_list", $viewKey);

			$pagePath = "list/$viewKey.php";
			$viewConfig->set("page_auto_detected", $pagePath);
			$viewConfig->set("page_js_auto_detected", $viewConfig->get("js_list", ""));
			
		}
		
//		Log::d("ViewAsIncludedPage $autoPage", $viewConfig->get("page"));		

	}
	
	private function loadDataItem($objectKey, $model){
		$object = null;	
		if(!strcasecmp($objectKey, "new")){
				$object = new ArrayWrapper();
			}else{
				$object = $model->getObjectByKey($objectKey);
			}
			return $object;
	}


}