<?php

namespace Expertix\Core\App;

use Expertix\Core\App\Response\AppResponse;

use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Exception\{AppInitException, RedirectException};

use Expertix\Core\User\Aff\AffHelper;
use Expertix\Core\User\Exception\WrongUserException;

use Expertix\Core\User\UserManager;
use Expertix\Core\Util\Log;


class App
{
	public const APP_HTML = 0;
	public const APP_JSON = 1;
	
	private $config;
	private $router;
	private $userManager;
	private $modules = [];
	
	private $appType = self::APP_HTML;

	function __construct()
	{
		$this->onCreate();
	}
	protected function onCreate()
	{
	}

	public function process()
	{
		$response = null;
		try {
			$response = $this->getResponse();
			$controller = $this->routeController();
			if (!$controller) {
				throw new AppInitException("Ошибка определения контроллера", 1);
			}
			$this->initAppWithController($controller);			
			
			$controller->sendHeader();
			$this->processAuthBySession($controller);
			$this->processAffiliate($controller);
						
			$view = $controller->process();
			if($view){
				$view->render($response);
			}
			
				
		} catch (RedirectException $e) {
			$url = $e->getRedirectUrl();
			if (!empty($url)) {
				$this->redirectUrl($url);
			}
			$path = $e->getRedirectPath();
			$this->redirectPath($path);
		}catch (AppInitException $e) {
			$response->print("<h2>App init error</h2>");
			$response->print("<h3>Error:" . $e->getMessage() . "</h3>");
			$response->print("<h3>Code:" . $e->getCode() . "</h4>");
		}catch (\Throwable $e) {
			$response->print("<h2>App Error</h2>");
			$response->print("<h3>Error:" . $e->getMessage() . "</h3>");
			$response->print("<h3>Code:" . $e->getCode() . "</h4>");
			if($this->isDebug()){
				$response->print($e->getTraceAsString());
			}
		}
		
//		MyLog::printLog();
	}

	protected function initAppWithController($controller){
		$userManager = new UserManager($controller->getAuthConfig());
		// TODO init app user favtory from app config
		$this->setuserManager($userManager);
		return;

	}

	/**
	 * Автоматическая аутентификация по сессии. В случае ошибки выбрасывается исключение на переадресацию
	 * В случае успеха контроллеру передается созданный пользователь
	 * Поведение настраивается параметрами из конфигруационного файла контроллера
	 */
	protected function processAuthBySession($controller){
		$userManager = $this->getUserManager();
		try {
			$user = $userManager->authBySession();
			//Log::d("processAuthBySession result:", $user);

			$controller->setUser($user);
		} catch (WrongUserException $e) {
			if(APP_TYPE==0){
				$userManager->processError($e);				
			}else{
				//TODO: return AUTH_NEEDED!
			}
		}
		
//		print_r ($controller->getAuthConfig());
//		Log::d("App auth():", $controller->getControllerConfig()->getArray(), 1);
//		Log::d("App auth() result:", $user, 1);
	}
	
	protected function processAffiliate($controller){
		$user = $controller->getUser();
		$affManager = new AffHelper();
		$affKey = $affManager->processAffByRequest($user, Request::class);
		if ($affKey) {
			$controller->setParam("affKey", $affKey);
			$user->set("affKey", $affKey);
		}
	} 
	
	protected function getResponse(){
		AppResponse::getResponseHtml();
		return $this->appType==self::APP_HTML?AppResponse::getResponseHtml(): AppResponse::getResponseJson();
	}
	
	protected function isDebug(){
		return $this->config->isDebugMode();
	}

	protected function routeController()
	{
		$routerStr = Request::getRouteFromRequestParam();

		$controllerParamsArr = $this->router->route($this->config->getRouterConfig(), $routerStr);

		if (empty($controllerParamsArr)) {
			$controllerParamsArr = $this->router->route404();
		}

		$controllerParams = new ArrayWrapper($controllerParamsArr);

		$controller = $this->createController($controllerParams);
		return $controller;
	}


	protected function createController($controllerParams)
	{
//		Log::d("Before create controller", $controllerParamsArr);
		$controllerClass = $controllerParams->get("controller", "Expertix\Core\Controller\WebPageController");
		$controller = new $controllerClass($controllerParams);
//		Log::d("After create controller", $controller);
		
		return $controller;
	}
	public function setupModules(){
		//$this->setupModulesFromDir(PATH_PROJECT_MODULES);
		$this->setupModulesFromDir(PATH_APP_MODULES);
		$this->setupModulesFromDir(PATH_CORE_MODULES);
		
		$config = $this->getConfig();
		$config->applyModuleRoutes($this->getModules());
	}
	public function setupModulesFromDir($path){
		$appConfig = $this->getConfig()->getAppConfig();
		$modulesConfig = $appConfig->get("modules");
		$pathArray = scandir($path);
		
		foreach ($pathArray as $index => $dirItem) {
			$modulePath = $path . $dirItem. DIR_DELIMETER;
			if($dirItem!="." && $dirItem!=".." && is_dir($modulePath)){
				$moduleKey = $dirItem;
				//Log::d("Module key: $moduleKey");
				
				if($appConfig->get("modules_autoload") || isset($modulesConfig[$moduleKey])){
					$this->registerModule($moduleKey, $modulePath);
				}
			}
		}


		//Log::d("Modules for $path", $this->modules);
		//$test = new \Module\Edu\Test();

	}
	public function registerModule($moduleKey, $modulePath)
	{
		if (isset($this->modules[$moduleKey])) {
			//return; ?
		}

		$routesForModule = null;
		if (file_exists($modulePath . "controller.cfg.php")) {
			$routesForModule = include($modulePath . "controller.cfg.php");
		}
		if (file_exists($modulePath . "autoload.php")) {
			include($modulePath . "autoload.php");
		}

		$this->modules[$moduleKey] = [
			"path" => $modulePath,
			"routes" => $routesForModule
		];
	}
	
	protected function checkModuleInConfig($config, $moduleKey){
		return isset($config[$moduleKey]);		
	}

	public function setupModulesFromAppConfig()
	{
		$appConfig = $this->getConfig()->getAppConfig();
		$routerConfig = $this->getConfig()->getRouterConfig();

		$modules = $appConfig->get("modules"); 
		// "modules" subarray in app config
		// "app"=>"app" (module key - router endpoint)
		if ($modules) {
			foreach ($modules as $moduleKey => $moduleRouterEndpoint) {
				$this->registerModule($moduleKey, "");
				$modulePath = $this->getModule($moduleKey);
				// Check if specified endpoint for router and dont exists same path
				if($moduleRouterEndpoint && !$routerConfig->check($moduleRouterEndpoint)){
					$routesForModule = include ($modulePath . "controller.cfg.php");
					if($routesForModule){
						$routerConfig->set($moduleRouterEndpoint, $routesForModule);
					}
				}
			}
		}

		$d = dir(PATH_PROJECT_MODULES);
		while (false !== ($entry = $d->read())) {
			if ($entry[0] != '.') {
				$this->registerModule($entry, PATH_PROJECT_MODULES . $entry);
			}
		}	
	}


	public function getModules()
	{
		return $this->modules;
	}
	public function getModule($key){
		return empty($this->modules[$key])?null: $this->modules[$key];
	}

	public function setUserManager($userManager)
	{
		$this->userManager = $userManager;
	}
	public  function getUserManager()
	{
		return $this->userManager;
	}
	public function setConfig($config)
	{
		$this->config = $config;
	}
	public function getConfig()
	{
		return $this->config;
	}
	public function setRouter($router)
	{
		$this->router = $router;
	}

	public static function redirect404()
	{
		self::redirectPath("404");
	}
	public static function redirectError()
	{
		self::redirectPath("error");
	}
	public static function redirectAccess()
	{
		self::redirectPath("access");
	}

	public static function redirectUrl($url)
	{
		//Log::d("Location: " . $url . "", "", 1);

		header("Location: " . $url . "");
		die();
	}
	public static function redirectPath($path)
	{
		self::redirectUrl(AppContext::getConfig()->getBaseSiteUrl() . ($path=="/"?"":$path));
	}
}
