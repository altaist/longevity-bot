<?php

namespace Expertix\Core\App\Response;

class AppResponse{
	static protected $responseHtml = null;
	static protected $responseJson = null;
	
	private function __construct()
	{
		echo("Construct response"); exit;
	}
		
	static function getResponseHtml(){
		if(!self::$responseHtml){
			self::$responseHtml = new ResponseHtml();	
		}
		return self::$responseHtml;
	}
	static function getResponseJson()
	{
		if(!self::$responseJson){
			self::$responseJson = new ResponseJson();
		}
		return self::$responseJson;
	}

}