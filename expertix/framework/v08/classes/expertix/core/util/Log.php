<?php

namespace Expertix\Core\Util;

class Log
{
	protected static $debugBuffer = [];
	protected static $errorBuffer = [];
	protected static $silentMode = false;

	static function setup($isDebug = true, $handleError = true, $debugBuffer = [], $errorBuffer = [])
	{
		self::setSilent(!$isDebug);

		self::$debugBuffer = $debugBuffer;
		self::$errorBuffer = $errorBuffer;

		if (self::$silentMode && $handleError) {
			set_error_handler("Expertix\Core\Util\Log::errorHandler");
		}
	}

	
	static function errorHandler($errno, $errstr, $errfile, $errline)
	{
		if (!(error_reporting() & $errno)) {
			// This error code is not included in error_reporting, so let it fall
			// through to the standard PHP error handler
			return false;
		}

		self::error($errstr . ". File: " . $errfile . " at line:" . $errline, $errno);
		return true;
	}

	static function log($obj, $strMessage, $data=null){
		$className = get_class($obj);
		self::d("$className: " .$strMessage, $data);		
	}
	
	static function setSilent($silent = true, $handleError = true)
	{
		self::$silentMode = $silent;

	}


	static function getLog()
	{
		return ["debug" => self::$debugBuffer, "error" => self::$errorBuffer];
	}
	static function printLog()
	{
		print_r("<h4>Error log:</h4>");
		self::printArr(self::$errorBuffer);
		print_r("<h4>Debug log:</h4>");
		self::printArr(self::$debugBuffer);
	}
	static function printArr($data)
	{
		foreach ($data as $key => $value) {
			self::myPrint($value);
		}
	}
	static function myPrint($data, $recursive = false)
	{
		
		if (is_string($data)) {
			print_r($data . "<br>");
			return;
		}
		if ($recursive && is_array($data)) {
			foreach ($data as $key => $value) {
				self::myPrint($value);
			}
			return;
		}

		print_r($data);
		echo ("<br>");
	}
	static function logException($exception)
	{
		self::error($exception->getMessage(), $exception->getcode());
	}
	static function error($str, $code = 0, $exit = false)
	{
		if (is_array(self::$errorBuffer)) {
			self::$errorBuffer[] = ["code" => $code, "message" => $str];
		}
		if (self::$silentMode) {
			return;
		}

		self::myPrint($str);
		if ($exit) {
			exit;
		}
		return;
	}
	static function e($str, $code = 0, $exit = false){
		return self::error($str, $code, $exit);
	}

	static function debug($str, $exit = false)
	{
		//echo debug_backtrace()[1]['function'];
		if (is_array(self::$debugBuffer)) {
			
			if(is_object($str)){
				self::$debugBuffer[] = "object";
				
			}else{
				self::$debugBuffer[] = $str;
			}
		}
		if (self::$silentMode) {
			return;
		}
		self::myPrint($str);

		if ($exit) {
			exit;
		}
		return;
	}

	static function debugPrint($param1, $param2 = null, $exit = false)
	{
		if (!$param1) return;

		if (is_array($param1)) {
			print_r($param1);
			echo "<br/>";
		} else if (is_string($param1)) {
			print($param1 . (!empty($param2) ? ": " : "<br>"));
		}

		if (!$param2) return;
		print_r($param2);
		echo "<br/>";

		if ($exit) exit;
	}

	
	static function d($text, $var = "", $exit = false)
	{
		self::debug($text);
		self::debug($var, $exit);
	}
	
	static function test($text, $exit = false)
	{
		self::setSilent(false);
		//error_log(var_export($e->getTraceAsString(), true));
		self::d("<b>TEST</b>", $text);
		$e = new \Exception;
		self::debug($e->getTraceAsString());
		self::d("<b>/TEST</b>", $text);
		if ($exit) {
			exit;
		}
	}
	static function break($text)
	{
		self::test($text, true);
	}
}
