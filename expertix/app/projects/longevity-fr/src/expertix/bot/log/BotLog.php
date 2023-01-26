<?php
namespace Expertix\Bot\Log;


class BotLog{
	static private $instance = null;
	
	const BASE_PATH_LOG = PATH_PROJECT;
	
	const PATH_REQUEST_LOG = self::BASE_PATH_LOG . '/log-bot-request.txt';
	const PATH_REQUEST_FULL_LOG = self::BASE_PATH_LOG . '/log-bot-request-full.txt';
	const PATH_TRANSPORT_LOG = self::BASE_PATH_LOG . '/log-bot-transport.txt';
	const PATH_TRANSPORT_FULL_LOG = self::BASE_PATH_LOG . '/log-bot-transport-full.txt';
	const PATH_DEBUG_LOG = self::BASE_PATH_LOG . '/log-bot-debug.txt';
	const PATH_DEFAULT_LOG = self::BASE_PATH_LOG . '/log-bot-default.txt';
	const PATH_ERR_LOG = self::BASE_PATH_LOG . '/log-bot-errors.txt';
	
	private function __construct(){
	}
	
	private static function getInstance(): ?BotLog{
		if(self::$instance) return self::$instance;
		return new BotLog();
	}
	static function log($data){
		return self::logTo(is_string($data)?$data:json_encode($data), self::PATH_DEFAULT_LOG);
	}
	static function d($data){
		$log = self::getInstance();
		return $log->writeToFile(self::PATH_DEBUG_LOG, $data);				
	}
	
	static function error(\Throwable $ex){
		$log = self::getInstance();
		$data = $ex->getMessage() . "\n";
		$data .= $ex->getTraceAsString();
		return $log->writeToFile(self::PATH_ERR_LOG, $data);		
	}
	
	static function logRequest(string $data){
		return self::logTo($data, self::PATH_REQUEST_LOG);
	}
	static function logRequestFull(string $data){
		return self::logTo($data, self::PATH_REQUEST_FULL_LOG);
	}
	static function logTransport(string $data){
		return self::logTo($data, self::PATH_TRANSPORT_LOG);
	}
	static function logTransportFull(string $data){
		return self::logTo($data, self::PATH_TRANSPORT_FULL_LOG);
	}
	
	static function logTo(string $data, string $path){
		$log = self::getInstance();
		return $log->writeToFile($path, $data);
	}
	private function writeToFile(string $path, string $dataIn){
		$data = date("Y-m-d H:i:s") . ";$dataIn";
		return file_put_contents($path, print_r($data, 1) . "\n", FILE_APPEND);
	}
	
}