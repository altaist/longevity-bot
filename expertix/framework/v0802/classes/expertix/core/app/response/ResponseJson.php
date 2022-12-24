<?php
namespace Expertix\Core\App\Response;

class ResponseJson implements IResponse{
	function print($content){
		print_r($content);
	}
	function includeFile($path){
		
	}
	
	function sendBuffered($content){}
}