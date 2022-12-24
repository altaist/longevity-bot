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
	private $text;
	private $textOrigin;

	function __construct($requestData)
	{
		$this->parse($requestData);
	}

	function parse($requestData)
	{
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
		$this->requestFrom = $this->requestMessage["from"];
		$this->chat = $this->requestMessage["chat"];
		$this->chatId = $this->chat["id"];
		$this->userName = $this->chat["username"];
		
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
		$this->log("Callback: " . json_encode($this->requestCallback));
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
		if (count($arr) < $index + 1) return null;
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
		file_put_contents(__DIR__ . '/request.log.txt', '$dataOut: ' . print_r($data, 1) . "\n", FILE_APPEND);
	}
}
