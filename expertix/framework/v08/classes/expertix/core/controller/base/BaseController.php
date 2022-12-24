<?php

namespace Expertix\Core\Controller\Base;

use Expertix\Core\App\Request;
use Expertix\Core\Data\PageData;
use Expertix\Core\Exception\AppException;
use Expertix\Core\User\Exception\WrongUserException;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;
use Expertix\Core\View\Config\ViewConfig;

abstract class BaseController
{	
	private $controllerConfig = null;
	private $viewConfig = null;
	private $pageData = null;
	
	private $user = null;
	private $actionsRouteTable = [];
	private $actionsAccessRules = [];
	
	abstract public function process();

	function __construct($controllerConfig)
	{
		//Log::d("CreateController", $controllerConfig);
		$this->controllerConfig = $controllerConfig;
		$this->pageData = new PageData();
		$this->viewConfig = new ViewConfig($controllerConfig->getArray());
		
		$modelClass = $controllerConfig->get("model");
		if($modelClass){
			$this->pageData->setModel(new $modelClass());
		}
		
		$this->autoDetectQueryParams();
		$this->onCreate();
	}
	
	protected function onCreate(){
	}

	public function getViewConfig()
	{
		return $this->viewConfig;
	}
	public function getPageData()
	{
		return $this->pageData;
	}

	public function setUser($user)
	{
		$this->user = $user;
		$this->pageData->setUser($this->getUser());
	}
	public function getUser()
	{
		return $this->user;
	}
	public function requireUser(){
		$user = $this->getUser();
		if(!$user){
			throw new WrongUserException("Ошибка доступа к контроллеру. Пользователь не найден", 1);
		}
		return $user;
	}
	protected function getUserId(){
		$user = $this->getUser();
		if(!$user){
			return;
		}
		return $user->getId();
	}

	public function getControllerConfig()
	{
		return $this->controllerConfig;
	}
	public function getAuthConfig()
	{
		if(!$this->controllerConfig) return new ArrayWrapper([]);
		return $this->controllerConfig->getWrapper("auth");
	}
	
	public function setParam($param, $value){
		$config = $this->getControllerConfig();
		$config->set($param, $value);
	}
	
	public function sendHeader(){
		$this->startSession();
	}
	function startSession()
	{
		//Log::d("Controller startSession", $this->getControllerConfig());
		$noSession = $this->getControllerConfig()->get("session_no");
		$status = session_status();

		if (!empty($noSession) || $status != PHP_SESSION_NONE) {
			return false;
		}

		return session_start();
	}

	


	// Crud
	protected function autoDetectQueryParams()
	{
		$objectId = $this->detectQueryParam("objectId", 0);
		$parentId = $this->detectQueryParam("parentId", 1);
		$objectType = $this->detectQueryParam("objectType", 2);
		
		// For details only
		$pageKey = $this->detectQueryParam("pageKey", 1);
		//Log::d("objectId:", $objectId, 0);


		$pageData = $this->getPageData();

		$pageData->setObjectId($objectId);
		$pageData->set("parentId", $parentId);
		$pageData->set("objectType", $objectType);
		$pageData->set("viewKey", $pageKey);

		$pageData->setAffKey($this->getControllerConfig()->get("affKey"));
	}

	protected function detectQueryParam($fieldName, $paramNumber = 0)
	{
		$controllerData = $this->getControllerConfig()->getArray();

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
		$urlParts = empty($controllerData["queryParts"])?[]: $controllerData["queryParts"]; // Params from url, first was a controller name
		//		Log::d("queryParts: $level", $urlParts, 0);

		if (empty($urlParts[$paramNumber])) {
			return null;
		} else {
			$key = $urlParts[$paramNumber];
			return $key;
		}
	}		
	

	// API

	// obj - if empty then func in global scope
	protected function callAction($object, $action, $formData)
	{
		$funcName = $this->getFunctionFromAction($action);
		Log::d($funcName, $formData);

		if (empty($object) || !method_exists($object, $funcName)) {
			throw new AppException("Ошибка в запросе - неизвестный метод", 1, "Wrong action param in request");
		}
		
		// Check access
		$this->checkActionAccess($action);
		
		// Process
		$result =  $object->$funcName($formData);
		//Log::d("callAction() result:", $result);
		return $result;
	}

	protected function addRoute($endpoint, $funcName, $accessRule= null)
	{
		$this->actionsRouteTable[$endpoint] = $funcName;
		$this->actionsAccessRules[$endpoint] = $accessRule;		
	}
	
	protected function getFunctionFromAction($action){
		if (!empty($this->actionsRouteTable) && !empty($this->actionsRouteTable[$action])) {
			$funcName = $this->actionsRouteTable[$action];
		}

		if (empty($funcName)) {
			$funcName = "exp_" . $action;
		}
		return $funcName;		
	}
	
	protected function checkActionAccess($action){
		//Log::d("checkActionAccess for $action", $this->actionsAccessRules);
		if(empty($this->actionsAccessRules[$action])){
			return;
		}
		$rule = $this->actionsAccessRules[$action];
		
		$user = $this->getUser();
		if(!$user){
			throw new WrongUserException("У вас нет прав на выполнение этой операции", 1, "Access denied for action '$action'. Empty user.");
		}
		//Log::d("checkActionAccess for user", $user->getArray());

		
		$userLevel = $user->get("level");
		$userRole = $user->get("role");
		$ruleLevel = -1;
		$ruleMinLevel = -1;
		$ruleRoles = null;
		
		if(is_int($rule)){
			$ruleMinLevel = $rule;
		}else if(is_array($rule)){
			$params = new ArrayWrapper($rule);
			
			if($params->get("level_min")){
				$ruleMinLevel = $params->get("level_min");
			}
			if($params->get("level")){
				$ruleLevel = $params->get("level");
			}
			if ($params->get("roles")) {
				$ruleRoles = $params->get("roles");
			}			
		}
		
		if($ruleMinLevel>=0 && $userLevel<$ruleMinLevel){
			throw new WrongUserException("У вас нет прав на выполнение этой операции", 1, "Access denied for action '$action'. Users level lower than rule ones.");			
		}
		if($ruleLevel>=0 && $userLevel!=$ruleLevel){
			throw new WrongUserException("У вас нет прав на выполнение этой операции", 1, "Access denied for action '$action'. Users level not equals than rule ones.");			
		}
		if ($ruleRoles) {
			// TODO: check roles
		}		
	}


}
