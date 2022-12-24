<?php

namespace Expertix\Core\Config;

class Config
{
	protected static $configArr = [];
	protected static $routerArr = [];
	protected static $appParamsArr = [];
	function __construct($baseDir)
	{
		$this->load($baseDir);
	}
	function load($baseDir)
	{
		self::$configArr = include($baseDir . "system.php");
		self::$routerArr = include($baseDir . "router.php");
		self::$appParamsArr = include($baseDir . "app.php");
//		print_r(self::$configArr);
		
	}

	static function getAppConfig()
	{
		return self::$configArr;
	}
	static function getRouterConfig()
	{
		return self::$routerArr;
	}
	static function getAppParams()
	{
		return self::$appParamsArr;
	}

	static function getConfigParam($key, $default = null)
	{
		return self::getValue(self::$configArr, $key, $default);
	}
	static function getRouterParam($key, $default = null)
	{
		return self::getValue(self::$routerArr, $key, $default);
	}
	static function getAppParam($key, $default = null)
	{
		return self::getValue(self::$appParamsArr, $key, $default);
	}
	static function getValue($arr, $key, $default = "")
	{
		if (!$arr) return $default;
		return empty($arr[$key]) ? $default : $arr[$key];
	}
	
	
}
