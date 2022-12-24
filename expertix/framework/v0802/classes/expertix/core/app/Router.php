<?php

namespace Expertix\Core\App;

use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;
use Expertix\Core\Util\Utils;

class Router
{
	function route($routerConfig, $routerStr, $auto404 = true)
	{
		$routerArr = $routerConfig->getArray();
		if (empty($routerArr)) {
			return $this->routeByUrlAndPageConfig($routerStr);
		}

		$controllerParamsArr = $this->routeByRouter($routerConfig, $routerStr);
		if (empty($controllerParamsArr) && $auto404) {
			$controllerParamsArr = $this->routeByRouter($routerConfig, "404/");
		}

		if (!empty($controllerParamsArr)) {
			$controllerParamsArr["request_route"] = $routerStr;
		}

		return $controllerParamsArr;
	}

	function routeByRouter($routerConfig, $routerStr)
	{
		$urlArr = $this->parseRouterString($routerStr);
		$controllerParamsArr = $this->processRoute($urlArr, $routerConfig);

		return $controllerParamsArr;
	}

	function processRoute($urlArr, $routerConfig)
	{
//		Log::d("Router -> RouteTable", $routerConfig->getArray());
//		Log::d("Router -> UrlArr", $urlArr);
	
		$currentRouteTable = $routerConfig->get("route", []);
		$currentDefaults = $routerConfig->get("defaults", []);
		$resultData = [];
		$resultLevel = 0;
		$queryParts = [];

		//		Log::d("> Router -> CurrentRouteTable", $currentRouteTable);
		//Log::d("Router-> currentDefaults:", $currentDefaults);

		$isFail = false;
		foreach ($urlArr as $index => $value) {
			$data = [];

			if(!$isFail){
				$data = $this->detectDataOrLink($currentRouteTable, $value ? $value : "/");
				//Log::d("> Router -> founded data", $data);
			}
			if (empty($data)) {
				$queryParts[] = $value;
				$isFail = true;
			} else {
				$resultData = $data;
				$resultLevel = $index;

				$defaults =  empty($resultData["defaults"]) ? [] : $resultData["defaults"];
				$currentDefaults = Utils::mergeArrays( $currentDefaults, $defaults, true);
				//Log::d("Router-> node Defaults:", $defaults);
				//Log::d("Router-> currentDefaults:", $currentDefaults);

				$currentRouteTable = empty($resultData["route"]) ? null : $resultData["route"];
				$currentRouteTable = empty($resultData["router"]) ? $currentRouteTable : $resultData["router"];
				
//				Log::d("> Router -> CurrentRouteTable", $currentRouteTable);

			}
		};

		// Check if founded result is correct
		if (empty($resultData["page"]) && empty($resultData["controller"])) {
			//throw new \Exception("", 2);
			return null;
		}
		$resultData = Utils::mergeArrays($currentDefaults, $resultData, true);
		$resultData["level"] = $resultLevel;
		$resultData["routerParts"] = $urlArr;
		$resultData["queryParts"] = $queryParts;

		//Log::d("Router->Result", $resultData, 0);
		
		return $resultData;
	}


	function processRouteOld($routeTable, $urlArr, $parentKey, $level, $parentControllerData = [])
	{
		///MyLog::d("-----");
		if (!is_array($urlArr) || count($urlArr) <= $level || $level > 10) {
			return null;
		}

		$controllerKey = "";

		if (!empty($urlArr[$level])) {
			$controllerKey = $urlArr[$level];
		} else {
			///MyLog::d("Empty urlArr for level=$level ");
			if ($level > 0) {
				//////return null;
			} else {
				$controllerKey = $parentKey;
			}
			$controllerKey = "/"; //$parentKey; ////!!!!
		}
		///MyLog::d("Route level '$level' with controllerKey: '$controllerKey'");
		///MyLog::d("Route url:", $urlArr);

		// Get controller info from route table
		$controllerData = $this->detectDataOrLink($routeTable, $controllerKey);
		if (empty($controllerData)) {
			///MyLog::d("Empty controllerData for key='$controllerKey' ");
			return null;
		}

		// Save last defaults or auth (used for childs nodes)
		$this->saveParentProperties($controllerData);

		// subTree
		if (!empty($controllerData["route"])) {
			$rt = $controllerData["route"];
			$rt["parentKey"] = $controllerKey;
			///MyLog::d("SUBTREE");
			return $this->processRoute($rt, $urlArr, $controllerKey, $level + 1, $controllerData);

			//return $this->findController($controllerKey, $rt);
		} else {
		}
		$controllerData["routeParts"] = $urlArr;
		$controllerData["level"] = $level;
		$controllerData["parentControllerData"] = $parentControllerData;




		return $controllerData;
	}
	private function detectDataOrLink($routeTable, $controllerKey)
	{
		if (!$routeTable) return null;
		//MyLog::d("findController table :", $routeTable[$controllerKey]);
		$controllerData = isset($routeTable[$controllerKey]) ? $routeTable[$controllerKey] : null;
		if (empty($controllerData)) {
			return null;
		}

		// If string - search synonims
		if (is_string($controllerData)) {
			$newKey = $controllerData;
			return $this->detectDataOrLink($routeTable, $newKey);
		}

		return $controllerData;
	}

	function saveParentProperties($controllerData)
	{
		// Save last defaults or auth
		if (!empty($controllerData["defaults"])) {
			$this->setDefaultsBlock($controllerData["defaults"]);
		}
		if (!empty($controllerData["auth"])) {
			$this->setAuthBlock($controllerData["auth"]);
		}
	}

	function getDefaultsBlock()
	{
		return $this->currentDefaultsBlock;
	}
	function setDefaultsBlock($defaults)
	{
		$this->currentDefaultsBlock = $defaults;
	}
	function getAuthBlock()
	{
		return $this->currentAuthBlock;
	}
	function setAuthBlock($auth)
	{
		$this->currentAuthBlock = $auth;
	}


	//
	function routeByUrlAndPageConfig($key)
	{
		//$key = self::getValue($_REQUEST, "route", [""]);

		$meta = $key . ".meta.php";
		$pageConfigArr = include PATH_PAGES . $meta;
		$pageConfig = new ArrayWrapper($pageConfigArr);
		$title =  $pageConfig->get("title");
		$template = $pageConfig->get("template", "default/template.php");
		$page = $pageConfig->get("page", $key . ".php");
		$js = $pageConfig->get("js", $key . ".js.php");
		$controllerDataArr = [
			"title" => $title,
			"template" => $template,
			"page" => $page,
			"js" => $js,

		];
		return $controllerDataArr;
	}

	static function parseRouterString($str)
	{
		$arr = explode("/", $str);
		return $arr;
	}

	function route404()
	{
		return $this->createPageParams("app/404.php");
	}
	function routeAccessDenied()
	{
		return $this->createPageParams("app/access.php");
	}
	function routeError()
	{
		return $this->createPageParams("app/error.php");
	}

	function createPageParams($page, $template = null, $js = null, $controller = null)
	{
		$controllerConfig = [
			"page" => $page
		];

		if ($template) {
			$controllerConfig["template"] = $template;
		}
		if ($js) {
			$controllerConfig["js"] = $js;
		}
		if ($controller) {
			$controllerConfig["controller"] = $controller;
		}

		return $controllerConfig;
	}
}
