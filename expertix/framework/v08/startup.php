<?php

use Expertix\Core\App\AppContext;

defined("DIR_DELIMETER") or define("DIR_DELIMETER", "/");

defined("APP_TYPE") or define("APP_TYPE", 0); // 0 - ordinary, 1- api

defined("PATH_MYAPP") or define ("PATH_MYAPP", PATH_APP . "app" . DIR_DELIMETER);
defined("PROJECT_KEY") or define("PROJECT_KEY", "default");
defined("PATH_PROJECT") or define("PATH_PROJECT", PATH_MYAPP . "projects" . DIR_DELIMETER . "" . PROJECT_KEY . "" . DIR_DELIMETER . "");
defined("PATH_CONFIG") or define("PATH_CONFIG", PATH_PROJECT . "config" . DIR_DELIMETER . "");

defined("PATH_CORE_CLASSES") or define("PATH_CORE_CLASSES", PATH_APP_LIB . "classes" . DIR_DELIMETER);
defined("PATH_PROJECT_CLASSES") or define("PATH_PROJECT_CLASSES", PATH_PROJECT . "src" . DIR_DELIMETER);

defined("PATH_PROJECT_MODULES") or define("PATH_PROJECT_MODULES", PATH_PROJECT . "modules" . DIR_DELIMETER);
defined("PATH_APP_MODULES") or define("PATH_APP_MODULES", PATH_MYAPP . "modules" . DIR_DELIMETER);
defined("PATH_CORE_MODULES") or define("PATH_CORE_MODULES", PATH_APP_LIB . "modules" . DIR_DELIMETER);

defined("PATH_VIEW") or define("PATH_VIEW", PATH_PROJECT . "view" . DIR_DELIMETER);
defined("PATH_PAGES") or define("PATH_PAGES", PATH_VIEW . "pages" . DIR_DELIMETER);
defined("PATH_JS") or define("PATH_JS", PATH_VIEW . "js" . DIR_DELIMETER);
defined("PATH_VIEW_COMPONENTS") or define("PATH_VIEW_COMPONENTS", PATH_VIEW . "components" . DIR_DELIMETER);
defined("PATH_PROJECT_TEMPLATE_DEFAULT") or define("PATH_PROJECT_TEMPLATE_DEFAULT", PATH_VIEW . "templates/default" . DIR_DELIMETER);
defined("PATH_PROJECT_TEMPLATES") or define("PATH_PROJECT_TEMPLATES", PATH_VIEW . "templates" . DIR_DELIMETER);
defined("PATH_APP_TEMPLATES") or define("PATH_APP_TEMPLATES", PATH_MYAPP . "templates" . DIR_DELIMETER);
defined("PATH_BASE_TEMPLATE") or define("PATH_BASE_TEMPLATE", PATH_APP_LIB . "templates" . DIR_DELIMETER . "base" . DIR_DELIMETER);


defined("PATH_RUNTIME") or define("PATH_RUNTIME", PATH_APP . "" . DIR_DELIMETER . "runtime" . DIR_DELIMETER);
defined("PATH_LOGS") or define("PATH_LOGS", PATH_RUNTIME . "logs" . DIR_DELIMETER);
defined("PATH_DUMP") or define("PATH_DUMP", PATH_RUNTIME . "dump" . DIR_DELIMETER);

defined("PATH_UPLOADS") or define("PATH_UPLOADS", PATH_APP . "" . DIR_DELIMETER . "uploads" . DIR_DELIMETER);


defined("APP_REQUEST_URI") or define("APP_REQUEST_URI", $_SERVER['REQUEST_URI']);

// Autoloader
spl_autoload_register(function ($fullClassName) {

	//echo '<b>autoload: ' . $fullClassName . "</b></br>";
	if (class_exists($fullClassName, false)) {
		//echo '<b>autoload: ' . $fullClassName . "</b></br>";
		return;
	}
	$pos = strrpos($fullClassName, "\\");
	//$strPath = stristr($fullClassName, "\\");
	//$strFileName = stristr($fullClassName, "\\", true);

	$strPath = substr($fullClassName, 0, $pos);
	$strPath = str_replace("\\", "/", $strPath);

	$strFileName = substr($fullClassName, $pos + 1, strlen($fullClassName) - $pos);
	$filePath = strtolower(($strPath)) . "/" . $strFileName . ".php";


	// Check APP CORE
	$fullFilePath = PATH_CORE_CLASSES . "" . $filePath;
	//echo '<b>autoload: ' . $fullClassName . '</b> file: ' . $fullFilePath . '<br>';	
	if (file_exists($fullFilePath)) {
		require_once $fullFilePath;
		return;
	}

	// Check PROJECT CLASSES
	$fullFilePath = PATH_PROJECT_CLASSES . "/" . $filePath;
	//echo '<b>autoload: ' . $fullClassName . '</b> file: ' . $fullFilePath . '<br>';
	if (file_exists($fullFilePath)) {
		require_once $fullFilePath;
		return;
	}

	// Check PROJECT MODULES
	$app = AppContext::getApp();
	if($app){
		$modules = $app->getModules();
//		print_r($modules);
		if (is_array($modules)) {
			$resultPath = null;
			foreach ($modules as $moduleKey => $params) {
				$fullFilePath = $params["path"] . "src/" . $filePath;
				//echo '<b>autoload module check: </b> file: ' . $fullFilePath . '<br>';
				if (file_exists($fullFilePath)) {
					$resultPath = $fullFilePath;
				}
			}
			if($resultPath){
				require_once $resultPath;
				return;
				
			}
		}		
	}

	return;
});
