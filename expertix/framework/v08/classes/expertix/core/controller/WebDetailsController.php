<?php

namespace Expertix\Core\Controller;

use Expertix\Core\App\AppContext;
use Expertix\Core\Data\IModelCrudRead;
use Expertix\Core\Util\Log;

class WebDetailsController extends WebPageController 
{
	protected $dbDataObject;
	protected $dbDataCollection;
	private $objectId=-1;
	private $parentId=-1; 
	private $objectType=-1;


	
	function prepareData(){
		$viewConfig = $this->getViewConfig();
		$pageData = $this->getPageData();
		$model = $pageData->getModel();
		if(!$model || !$model instanceof IModelCrudRead){
			Log::log($this, "Model isn't instance of IModelCrudRead");
			return;
		} 
		$object = null;
		$list = null;
		$objectId = $pageData->getObjectId();

		//Log::d("ListDetails loadData for $objectId");
		
		if(!$objectId){
			AppContext::getApp()->redirect404();
		}
			try {
				$object = $model->getCrudObject($objectId);
				if($object){
					$pageData->setDataObject($object);
				}else{
					AppContext::getApp()->redirect404();
				}
			} catch (\Throwable $th) {
				Log::log($this, "<br>Error detecting object: {$th->getMessage()}", $th->getTraceAsString());
			}

		//		Log::d("ListDetailsController $objectId", $object);
		


		// Auto detected page
		if ($pageData->getDataObject()) {
			$object = $pageData->getDataObject();
			$viewKey = $object->get("viewKey", "default");
			$pagePath = "details/$viewKey.php";
			$viewConfig->set("page_auto", $pagePath);
		}

		$page = $viewConfig->get("page");
		$autoPage = $viewConfig->get("page_auto");
		if (!$page && $autoPage) {
			$viewConfig->set("page", $autoPage);
		}
//		Log::d("ViewAsIncludedPage $autoPage", $viewConfig->get("page"));		

	}


}