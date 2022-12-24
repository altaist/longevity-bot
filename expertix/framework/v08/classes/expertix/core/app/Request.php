<?php
namespace Expertix\Core\App;

use Expertix\Core\Util\Log;

use Expertix\Core\Exception\ {AppInitException, RedirectException};


class Request{

	static function getGet()
	{
		return $_GET;
	}
	static function getPost()
	{
		return $_POST;
	}
	static function getJson()
	{
		return self::getJsonRequest();
	}

	static function getRequestParam($key, $default=null, $requestType=null){
		
		if($requestType && $requestType=="GET"){
			return self::clearParam(empty($_GET[$key])? $default: $_GET[$key]);
		}
		if ($requestType && $requestType == "POST") {
			return self::clearParam(empty($_POST[$key]) ? $default : $_POST[$key]);
		}
		if ($requestType && $requestType == "JSON") {
			$jsonRequest = self::getJsonRequest();
			if(is_array($jsonRequest)){
				return self::clearParam(empty($jsonRequest[$key]) ? $default : $jsonRequest[$key]);
			}else{
				return $default;
			}
		}
		return self::clearParam(empty($_REQUEST[$key]) ? $default : $_REQUEST[$key]);
	}
	
	static function getJsonRequest(){
		$jsonObject = null;
		$jsonString = file_get_contents("php://input");
		if (empty($jsonString)) {
			return null;
		}
		try {
			$jsonObject = json_decode($jsonString, true);
		} catch (\Throwable $th) {
			Log::e("Wrong Json Request");
		}
		return $jsonObject;
		

	}
	static function clearParam($value)
	{
		return $value;
	}
	static function getPagePathFromRequest()
	{
		//		return self::parseRequest()[0] . ".php";
		$key = self::getRouteFromRequestParam();
		$key = str_replace("\\", "", $key);
		$key = rtrim(str_replace("..", "", $key), "/");
		return $key;
	}

	static function getRouteFromRequestParam()
	{
		return empty($_REQUEST["route"]) ? "" : $_REQUEST["route"];
	}
}