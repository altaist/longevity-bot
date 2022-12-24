<?php
namespace Expertix\Core\App\Response;

class ResponseHtml implements IResponse{
	function print($content){
		print_r($content);
	}
	function includeFile($path){
		
	}
	
	function sendBuffered($content){}
}