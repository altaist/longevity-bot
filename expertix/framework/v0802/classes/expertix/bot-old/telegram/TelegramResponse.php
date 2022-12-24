<?php

namespace Expertix\Bot\Telegram;

use Expertix\Core\Util\ArrayWrapper;

class TelegramResponse extends ArrayWrapper{
	
	//private $responseData = [];
	
	public function __construct($array)
	{		
		parent::__construct($array);
	}
	
	public static function createEmptyResponse(){
		return new TelegramResponse(["method" => "", "chat_id" => "", "text" => ""]);
	}
	public static function createFromRequest(TelegramRequest $request, $text = null){
		return self::createTextResponse($request->getMessageChatId(), $text);
	}
	public static function createTextResponse(string $chatId, string $text = null){
		$response = self::createEmptyResponse();
		$response->setChatId($chatId);
		$response->setText($text);
		$response->setMethod("sendMessage");
		return $response;
	}
	
	
	public function getResponseData(){
		return $this->getArray();
	
	}
	public function getResponseDataJson(){
		return json_encode($this->getResponseData());
	}

	public function setChatId($chatId)
	{
		$this->set("chat_id", $chatId);
	}
	function setMethod($text){
		$this->set("method", $text);
	}
	function getMethod(){
		$this->get("method");
	}
	
	function setText($text){
		$this->set("text", $text);
	}
	
	function setPhoto($photo){
		$this->set("photo", $photo);
		
	}
}