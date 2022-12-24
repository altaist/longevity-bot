<?php
namespace Expertix\Core\Controller\Base;

use Expertix\Core\App\Request;
use Expertix\Core\Exception\AppException;
use Expertix\Core\User\Exception\WrongUserException;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;
use Expertix\Core\Util\Upload\UploadManager;
use Expertix\Core\View\ViewJson;

class BaseApiController extends BaseSiteController{


	public function prepareData(){
//		Log::d("ApiController process", $this->getControllerConfig());
		Log::setSilent(true);

		$jsonData = $this->detectRequest();
		$result = $this->processApi($jsonData);
		//Log::d("Process result: ", $result);
		$out = ["log" => Log::getLog(), "result" => $result["result"], "error" => $result["error"]];
		
		$pageData = $this->getPageData();
		$pageData->setOutput($out);
		
	}

	public function createView()
	{
		$pageData = $this->getPageData();
		$view = new ViewJson($this->getViewConfig(), $pageData);
		return $view;
	}
	

	function processApi($jsonData)
	{
		$action = null;
		$jsonData = $this->detectRequest();
		
		Log::d("Request processApi", $jsonData);
		try {

			$action = $this->detectAction($jsonData);
			$requestData = $this->detectRequestData($jsonData);
			
			// Process request
			$result = $this->callAction($this, $action, $requestData);
			return $this->prepareResult($result);
			
		} catch (\Throwable $th) {
			Log::d($th->getMessage(), $th->getCode());
			return $this->prepareError($th);
		}
	}
	
	protected function detectRequest(){
		$action = isset($_SERVER["HTTP_X_CUSTOM_ACTION"]) ? $_SERVER["HTTP_X_CUSTOM_ACTION"] : null;
		// Is it HTTP_X request?
		if($action){
			return $this->detectUploadRequest($action);
		}
		
		// Json request;
		$jsonData = Request::getJsonRequest();
		if (!$jsonData) {
			$jsonData = $_GET;
		}
		return $jsonData;

	}

	protected function detectUploadRequest($action)
	{

		$user = $this->getUser();
		if (!$user || $user->getId() < 0) {
			throw new WrongUserException("Только зарегистрированные пользователи могут загружать файлы на сервер", 1, "Пустой user во время обработки upload");
		}

		$userId = $user->getId();
		$objectId = isset($_SERVER["HTTP_X_CUSTOM_OBJECT_ID"]) ? $_SERVER["HTTP_X_CUSTOM_OBJECT_ID"] : null;

		if (!$objectId) {
			throw new AppException("Wrong upload objectId", 1);
		}

		$jsonData = ["action" => $action, "data" => ["userId" => $userId, "objectId" => $objectId]];
		return $jsonData;
	}
	
	protected function detectAction($jsonData){
		return (empty($jsonData["action"]) ? "" : $jsonData["action"]);
	}
	protected function detectRequestData($jsonData){
		$requestDataArr = empty($jsonData["data"]) ? [] : $jsonData["data"];
		$requestData = new ArrayWrapper($requestDataArr);
		return $requestData;
	}
	protected function prepareResult($result){
		$resultArray = ($result instanceof ArrayWrapper) ? $result->getArray() : $result;
		//Log::d("processApi result:", $result);

		$resultArr = ["result" => $resultArray, "error" => null];
		return $resultArr;		
	}
	protected function prepareError($e){
		$error = [$e->getCode(), $e->getMessage()];

		if ($e instanceof AppException) {
			$error[] = $e->getLogMessage();
		}
		return ["result" => null, "error" => $error];
	}

	//
	public function removeObjImg($model, $objectId)
	{

		$obj = $model->getRowById($objectId);
		if (!$obj) {
			throw new WrongUserException("Неверный идентификатор побъекта", 1, "Неверный objectId=$objectId при попытке удалить img");
		}

		$oldKey = $obj["img"];
		if ($oldKey) {
			try {
				$uploadManger = new UploadManager();
				$uploadManger->removeResource($oldKey);
			} catch (\Throwable $th) {
				throw $th;
			}
		}

		return $model->updateImgById($objectId, "");
	}
	


}