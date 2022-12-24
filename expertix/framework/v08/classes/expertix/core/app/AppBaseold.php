<?php
namespace Expertix\Core\App;

class AppBase{
	protected static $config = null;
//	protected static $configArr = [];
//	protected static $routerArr = [];
//	protected static $appParamsArr = [];
	
	function __construct($config)
	{
		$this->init($config);
//		self::d("AppParams", self::$config::getAppParams());
		
	}
	
	function init($config){
		self::$config = $config;
	}
	
	function process(){
		$simpleMode = self::$config->getAppParam("route_simple", false);

		if ($simpleMode) {
			return $this->processSimple();
		} else {
			return $this->processWithController();
		}

	}
	function processSimple()
	{
		$pageKey = $this->getPagePathFromRequest();
		require_once PATH_PAGES . $pageKey . ".php";
		/*
		$globalTemplate = self::$config::getAppParams("template", null);
		if($globalTemplate){
			require_once PATH_TEMPLATES . "default/template.php";
		}else{
			require_once PATH_PAGES . $pageKey;
		}
		*/
	}

	function processWithController()
	{
		$controller = null;
		$routerArr = self::$config->getRouterConfig();
		if ($routerArr) {
			$controller = $this->getControllerByRouter();
		} else {
			$controller = $this->getControllerByPageConfig();
		}
		
		if(!$controller){
			throw new Exception("Ошибка определения контроллера", 1);
		}
		
		return $controller->process();
	}
	
	
	
	function getControllerByRouter(){
		$controllerData = $this->route();
		return new PageController($controllerData);
	}
	function getControllerByPageConfig(){
		//$key = self::getValue($_REQUEST, "route", [""]);
		$key = $this->getPagePathFromRequest();
		
		$meta = $key . ".config.php";
		$pageConfigArr = include PATH_PAGES . $meta;
		$title = self::getValue($pageConfigArr, "title", "");
		$template = self::getValue($pageConfigArr, "template", "default/template.php");
		$page = self::getValue($pageConfigArr, "page", $key . ".php");
		$js = self::getValue($pageConfigArr, "js", $key . ".js.php");
		$controllerData = [
			"title" => $title,
			"template" => $template,
			"page" => $page,
			"js" => $js,
			
		];
		$controller = new PageController($controllerData);
		return $controller;
	}
	
	function route(){
		$key = $this->parseRequest()[0];		
		$controllerData = $this->getRouterParam($key);
		//Log::d($controllerData);
		if(empty($controllerData)){
			$controllerData = self::getController404();
		}
		return $controllerData;
	}
	
	function getRouterParam($key){
		return self::getValue(self::$config->getRouterConfig()["router"], $key); 
	}

	function getPagePathFromRequest()
	{
		//		return $this->parseRequest()[0] . ".php";
		$key = self::getValue($_REQUEST, "route", [""]);
		$key = str_replace("\\", "", $key);
		$key = rtrim(str_replace("..", "", $key), "/");
		
		return $key;

	}
	
	function parseRequest(){
		$arr = explode("/", self::getValue($_REQUEST, "route", ""));
		return $arr;
	}
	
	function getController404(){
		return [
			"template" => "simple/template.php",
			"page" => "app/404.php"
		];
	}
	function getControllerAccess()
	{
		return [
			"template" => "simple/template.php",
			"page" => "app/access.php"
		];
	}
	
	static function getValue($arr, $key, $default=""){
		if(!$arr) return $default;
		return empty($arr[$key])?$default:$arr[$key];
	}
	
	static function d($param1, $param2=null, $exit = false){
		Log::d($param1, $param2, $exit);
	}
	
}