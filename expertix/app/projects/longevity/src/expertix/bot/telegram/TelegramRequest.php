<?php

namespace Expertix\Bot\Telegram;

use Expertix\Bot\BotConfig;
use Expertix\Core\Util\Log;

class TelegramRequest
{

	private $callbackId;
	private $messageId;
	private $chatId;

	private $requestData;
	private $requestFrom;
	private $requestMessage;
	
	private $requestCallback;
	private $chat;
	private $from;

	private $userName;
	private $firstName;
	private $lastName;
	private $text;
	private $textOrigin;

	function __construct($requestData)
	{
		$this->parse($requestData);
	}

	function parse($requestData)
	{
		$this->log(json_encode($requestData));
		$this->requestData = $requestData;


		if (isset($requestData["message"])) {
			$this->parseMessage($requestData);
		} elseif (isset($requestData["callback_query"])) {
			$this->parseCallback($requestData);
		}
	}

	function parseMessage($requestData)
	{
		$this->requestMessage = $requestData["message"];
		$this->messageId = isset($this->requestMessage["message_id"])?$this->requestMessage["message_id"]:"";
		
		$this->requestFrom = $this->requestMessage["from"];
		$this->chat = $this->requestMessage["chat"];
		$this->chatId = $this->chat["id"];
		$this->firstName = isset($this->chat["first_name"])?$this->chat["first_name"]:"";
		$this->lastName = isset($this->chat["last_name"]) ? $this->chat["last_name"] : "";
		
		$this->userName = isset($this->chat["username"])?$this->chat["username"]:($this->firstName);

		$this->textOrigin = $this->requestMessage["text"];
		$this->text = trim($this->textOrigin);

		$this->text = str_replace("    ", " ", $this->text);
		$this->text = str_replace("  ", " ", $this->text);
		$this->text = str_replace("   ", " ", $this->text);
		$this->text = str_replace("  ", " ", $this->text);
	}

	function parseCallback($requestData)
	{
		$this->requestCallback = $requestData["callback_query"];
		
		$this->callbackId = $this->requestCallback['id'];
		$this->requestMessage = $this->requestCallback["message"];
		$this->messageId = $this->requestMessage["message_id"];
		$this->chatId = $this->requestMessage["chat"]["id"];
		$this->userName = $this->requestMessage["chat"]["username"];

		$this->textOrigin = $this->requestCallback["data"];
		$this->text = $this->textOrigin;
	}

	function getRequestData()
	{
		return $this->requestData;
	}
	function setRequestData($requestData)
	{
		$this->requestData = $requestData;
	}

	function getRequestMessage()
	{
		return $this->requestMessage;
	}
	function getRequestCallback()
	{
		return $this->requestCallback;
	}

	function getText()
	{
		return $this->text;
	}
	function getTextOrigin()
	{
		return $this->textOrigin;
	}
	function getTextWord(int $index)
	{
		$text = $this->getText();
		$arr = explode(" ", trim($text));
		//Log::d("Array:", $arr);
		if (count($arr) < $index + 1)
			return null;
		return $arr[$index];
	}


	function getChat()
	{
		return $this->chat;
	}
	function getCallbackId()
	{
		return $this->callbackId;
	}
	function getMessageId()
	{
		return $this->messageId;
	}
	function getMessageChatId()
	{
		//Log::d("ChatId: " . $this->chatId);

		return $this->chatId;
	}
	function getUserName()
	{
		return $this->userName;
	}

	public function log($data)
	{
		$data = date("Y-m-d H:i:s") . ";$data";
		file_put_contents(PATH_PROJECT . '/bot-request.txt', print_r($data, 1) . "\n", FILE_APPEND);
	}

	/**
	 * @return mixed
	 */
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	 * @return mixed
	 */
	public function getLastName() {
		return $this->lastName;
	}
}