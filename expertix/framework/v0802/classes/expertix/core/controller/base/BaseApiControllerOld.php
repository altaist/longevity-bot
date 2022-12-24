<?php
namespace Expertix\Core\Controller\Base;

use Expertix\Core\App\Request;
use Expertix\Core\Util\Log;
use Expertix\Core\util\MyLog;

class BaseApiControllerOld extends BaseController{
	public function process(){
		MyLog::setSilent(true);
		$jsonData = Request::getJsonRequest();
		
		if(!$jsonData){
			$jsonData = $_GET;
		}
		
		$result = $this->processApi($jsonData);
		//Log::d("Process result: ", $result);
		$out = ["log" => MyLog::getLog(), "result" => $result["result"], "error" => $result["error"]];
		
		$this->sendAsJson($out);
			
	}

	function processApi($jsonData)
	{
		$error = null;
		$objectType = null;
		$action = null;
		$formData = null;
		
		//Log::d("Request processApi", $jsonData);
		try {

			$objectType = empty($jsonData["objectType"]) ? "" : $jsonData["objectType"];
			$action = empty($jsonData["action"]) ? "" : $jsonData["action"];
			$formData = empty($jsonData["data"]) ? [] : $jsonData["data"];
			
			$result = $this->callAction($this, $action, $formData, $objectType);
//			Log::d("processApi result:", $result);

			//			MyLog::d(get_class(), $request);
			$resultArr = ["result" => $result, "error" => null];
			return $resultArr;
			
		} catch (\Throwable $th) {
			Log::d($th->getMessage(), $th->getCode());
			$error = [$th->getCode(), $th->getMessage()];
			return ["result" => null, "error" => $error];
		}
	}
	
	

	// obj - if empty then func in global scope
	protected function callAction($object, $action, $formData, $objectType)
	{
		$funcName = "";
		if (!empty($this->actionsRouteTable)) {
			$funcName = $this->actionsRouteTable[$action];
		} else {
			$funcName = "exp_" . $action;
		}

//		Log::debug($funcName);

		if (empty($object) || !method_exists($object, $funcName)) {
			throw new \Exception("Wrong action in request parameters", 1);
		}
		$result =  $object->$funcName($formData);
		Log::d("callAction() result:", $result);
		return $result;
	}	
}