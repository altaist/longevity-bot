<?php
namespace Expertix\Core\App;

class SessionHelper{
	const SESSION_PARAM_NAME_USER_KEY = "resuyek";
	
	// User Session
	function saveUserKeyInSession($key)
	{
		$this->startSession();
		$paramName = self::SESSION_PARAM_NAME_USER_KEY;
		$_SESSION[$paramName] = $key;
	}
	function getUserKeyFromSession()
	{
		//		MyLog::d("getUserKeyFromSession", $_SESSION);		
		$paramName = self::SESSION_PARAM_NAME_USER_KEY;
		if (empty($_SESSION[$paramName])) return null;
		return $_SESSION[$paramName];
	}
	function clearUserKeyFromSession()
	{
		$paramName = self::SESSION_PARAM_NAME_USER_KEY;
		unset($_SESSION[$paramName]);
		$this->destroySession();
	}
	
	// Utils
	static function startSession()
	{
		$status = session_status();
		if ($status === PHP_SESSION_NONE) {
			return session_start();
		}
		return false;
	}
	static function destroySession()
	{
		$status = session_status();
		if ($status === PHP_SESSION_ACTIVE) {
			return session_destroy();
		}
		return false;
	}
}