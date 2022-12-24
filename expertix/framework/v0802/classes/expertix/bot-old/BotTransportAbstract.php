<?php

namespace Expertix\Bot;

use Expertix\Core\Util\Log;

abstract class BotTransportAbstract
{
	protected $DEFAULT_API_URL = '';

	private $config = null;
	private $apiUrl = null;
	private $token = null;
	private $request = null;
	
	abstract function createRequest($requestData);
	abstract function createResponse();

	public function __construct($config)
	{
		$this->token = $config->getToken();
		$this->apiUrl = $config->getApiUrl($this->DEFAULT_API_URL);
		$this->config = $config;
	}

	public function processRequest($dataArr = null)
	{
		
		$requestData = $dataArr;
		if(!$requestData){
			
			$json = (file_get_contents("php://input"));
			//Log::d("Json request:", $json);
			$requestData = json_decode($json?$json:"{}", true, 512, JSON_THROW_ON_ERROR);
		}
		return $this->parseJsonRequest($requestData);
	}

	protected function parseJsonRequest($requestData)
	{
		if(!isset($requestData) || !is_array($requestData) ){
			//Log::d("Test request data:", $requestData);
			throw new BotException("Wrong input data while parsing Json request");
		}
		
		$this->request = $this->createRequest($requestData);
		
		return $this->request;
	}

	public function getRequest()
	{
		//Log::d($this->request);
		return $this->request;
	}
	public function getMessageChatId()
	{
		return $this->getRequest()->getMessageChatId();
	}

	public function sendText($text)
	{
		$response = $this->createResponse();
		$response->setText($text);
		//$response->setIfEmpty("reply_markup", $this->config->getText("kb_default", null));
		
		return $this->send("sendMessage", $response);
	}
	public function sendCallbackResult($text)
	{
		$response = $this->createResponse();
		$response->setMethod("answerCallbackQuery");
		$response->setText($text);
		$response->set("callback_query_id", $this->request->getCallbackId());
		
		return $this->send("answerCallbackQuery", $response);
	}
	
	public function sendResponse($response)
	{
		return $this->send($response->getMethod(), $response);
	}
	
	public function send($methodParam, $response){
		$method = $methodParam;
		if($this->config->get("auto_callback") && $this->request->getCallbackId()){
			$method = "answerCallbackQuery";
			$response->set("callback_query_id", $this->request->getCallbackId());			
		}
		
		
		$url = $this->apiUrl . $this->token . '/' . $method;
		//$response->setIfEmpty("reply_markup", $this->config->getText("kb_default", null));
		$data = $response->getResponseDataJson();
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_POST => 1,
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url,
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_HTTPHEADER => array_merge(array("Content-Type: application/json"))
		]);
		$result = curl_exec($curl);
		//file_put_contents(__DIR__ . '/file.txt', 'URL ' . print_r($url, 1) . "\n", FILE_APPEND);
		//file_put_contents(__DIR__ . '/file.txt', '$dataOut: ' . print_r($data, 1) . "\n", FILE_APPEND);
		$this->log($data);
		
		curl_close($curl);
		return (json_decode($result, 1) ? json_decode($result, 1) : $result);
	}

	public function log($data)
	{
		file_put_contents(__DIR__ . '/transport.txt', '$dataOut: ' . print_r($data, 1) . "\n", FILE_APPEND);
	}


	
}
