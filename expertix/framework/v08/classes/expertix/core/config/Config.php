<?php

namespace Expertix\Core\Config;

use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;
use Expertix\Core\Util\Utils;

class Config
{
	//protected $configArr = [];
	//protected $routerArr = [];
	//protected $appParamsArr = [];

	protected $configSystem = null;
	protected $configRouter = null;
	protected $configApp = null;
	
	function __construct($baseDir, $hostType = null)
	{
		$this->load($baseDir, $hostType);
	}
	function load($baseDir, $hostType)
	{
		$type = "dev";
		if(empty($hostType)){
			$type = self::detectHostType();
		}
		$systemArr = include($baseDir . "system.cfg.php");
		$routerArr = include($baseDir . "controller.cfg.php");
		$appParamsArr = include($baseDir . "app.cfg.php");
		
		$this->configSys = new ArrayWrapper(empty($systemArr[$type])?$systemArr:$systemArr[$type]);
		$this->configRouter = new ArrayWrapper(empty($routerArr[$type]) ? $routerArr : $routerArr[$type]);
		$this->configApp = new ArrayWrapper(empty($appParamsArr[$type]) ? $appParamsArr : $appParamsArr[$type]);
		
//		print_r($this->configSys);
		
	}
	
	function applyModuleRoutes($modules){
		$router = $this->configRouter;
		$routerArr = $router->getArray();
		$routerResult = $routerArr["route"];

		
		foreach ($modules as $key => $params) {
			$route = empty($params["routes"])?"": $params["routes"];
			if($route){
				// For each subroute add "module" param
				foreach ($route as $skey => $svalue) {
					$route = Utils::mergeArrays($route, [$skey => ["defaults" => ["module" => $key]]], true);
					$route = Utils::mergeArrays($route, [$skey => ["module" => $key]], true);
				}
				
				$routerResult = Utils::mergeArrays($routerResult, $route, true);
//				Log::d("--applyModuleRoutes for $key", $route);
			}
		}
		
		$routerArr["route"] = $routerResult;
		$this->configRouter->setArray($routerArr);
//		print_r($router->getArray());
//		Log::d("Final router:", $router->getArray()["route"]);
	}

	function getAppConfig()
	{
		return $this->configApp;
	}
	function getRouterConfig()
	{
		return $this->configRouter;
	}
	function getSysParams()
	{
		return $this->configSys;
	}
	function getSubConfig($key)
	{
		$subConfig = $this->getParam($key, []);
		return new ArrayWrapper($subConfig);
	}	
	function getParam($key, $default=""){
		$config = $this;
		return $config->getSysParam($key, $config->getAppParam($key, $config->getRouterParam($key, $default)));
	}

	function getSysParam($key, $default = null)
	{
		return $this->configSys->get($key, $default);
	}
	function getRouterParam($key, $default = null)
	{
		return $this->configRouter->get($key, $default);
	}
	function getAppParam($key, $default = null)
	{
		return $this->configApp->get($key, $default);
	}
	function getValue($arr, $key, $default = "")
	{
		if (!$arr) return $default;
		return empty($arr[$key]) ? $default : $arr[$key];
	}

	function getAppId()
	{
//		print_r($this->configSys->getArray());
		return $this->configSys->get("APP_ID");
	}
	function getUrl($key)
	{
		return $this->configSys->get("url")[$key];
	}	
	function isDebugMode()
	{
		return $this->configApp->get("debug_mode", true)===true;
	}
	function getDbConfig()
	{
		return $this->configSys->get("db");
	}
	function getSiteUrl()
	{
		return $this->getBaseSiteUrl();
	}
	function getBaseSiteUrl()
	{
		$siteUrl = $this->configSys->get("url")["site"];
		return $siteUrl;
	}
	

	static function detectHostType()
	{
		$hosting = $_SERVER['HTTP_HOST'] == "localhost" ? "dev" : "prod";
		return $hosting;
	}
	
}
