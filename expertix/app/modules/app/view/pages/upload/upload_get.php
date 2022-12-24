<?php

use Expertix\Core\App\Request;
use Expertix\Core\Db\DB;

getFile(Request::getRequestParam("key"));

function getFile($key){


	if(!$key){
		throw new \Exception("Wrong file key", 1);
	} 
	
	$row = DB::getRow("select * from app_file where fileKey=?", [$key]);
	
	if(!$row){
		throw new \Exception("File not founded for key $key", 1);
	}

	$fileName = $row["fileName"];
	$mime = $row["mime"];
	$includePath = PATH_UPLOADS . $fileName;
//	echo ($includePath);
	if(!file_exists($includePath)){
//		http_response_code(404);
//		exit;
		throw new \Exception("File not founded", 1);
		
	}
	
	header('Content-Type: '.$mime.'; charset=utf-8');
	include $includePath;
}