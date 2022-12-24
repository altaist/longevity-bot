<?php

namespace Expertix\Core\App;

use Expertix\Core\Util\ArrayWrapper;

class AppContext{
	private static $app;
	private static $config;
	private static $emailManager;
	
	public static function setApp($app){
		self::$app = $app;
	}
	public static function getApp()
	{
		return self::$app;
	}
	public static function getAppId()
	{
		return self::getConfig()->getAppId();
	}
	public static function setConfig($config)
	{
		self::$config = $config;
	}
	public static function getConfig()
	{
		return self::$config;
	}
	public static function setEmailManager($emailManager)
	{
		self::$emailManager = $emailManager;
	}
	public static function getEmailManager()
	{
		return self::$emailManager;
	}
		
	
	public static function getEmailConfig($tag){
		$config = AppContext::getConfig();
		$emailConfig = $config->getAppParam("email");
		if(!isset($emailConfig[$tag])){
			return null;
		}
		
		return new ArrayWrapper($emailConfig[$tag]);
		
	}
	
}