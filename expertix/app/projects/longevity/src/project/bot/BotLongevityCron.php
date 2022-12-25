<?php
namespace Project\Bot;

use Expertix\Bot\BotAbstract;
use Expertix\Bot\ChatInstance;
use Expertix\Bot\Log\BotLog;
use Expertix\Bot\Model\ChatActionModel;
use Expertix\Bot\Telegram\TelegramResponse;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;
use Project\Bot\Model\ChatModel;

class BotLongevityCron extends BotLongevityBase
{
	protected function sendChatCreationResult($chatInstance)
	{
	}
	public function startMultiSending($contentGroupKey)
	{
		$model = $this->getChatModel();
		$chatList = $model->getChatsForUpdate();
		if (!$chatList) {
			Log::d("Nothing to send");
			return 0;
			//throw new \Exception("Error multisending. Wrong chats list", 1);			
		}
		$response = TelegramResponse::createEmptyResponse();
		
		//$contentConfigLang = $this->getConfig()->getContentConfigForGroupLang($contentGroupKey);
		//$images = $this->getConfig()->getImgResources();
		$model = $this->getChatModel();
		Log::d("<pre>");
		foreach ($chatList as $chatData) {
			$chat = new ChatInstance($chatData);
			$chatId = $chat->getChatId();
			Log::d("Sending content to chat '$chatId':");
			$lang = $chat->get("lang", $this->getConfig()->getLang());
			$experiment = 0;
			
			// Load resources
			$dialogContent = $this->getDialogContent($experiment, $contentGroupKey, $lang);
			if(!$dialogContent){
				continue;
			}
			$dialogDefaults = $dialogContent->getWrapped("default");
			
			// Saved context
			$chatContentContextArr = $chat->getDialogContextForGroup($contentGroupKey, $experiment); //$this->getChatContentContext($chat, $contentGroupKey, $experiment);
			//Log::d("Chat config: ", $chatContentContextArr);
			$contentIndex = $chatContentContextArr[$experiment][$contentGroupKey]["index"];
			$maxContentSize = $dialogContent->getWrapped("items")->getArraySize();
			if (++$contentIndex >= $maxContentSize) {
				$contentIndex = 0;
			}
			Log::d("ContentIndex: $contentIndex. MaxContent: $maxContentSize");
			$chatContentContextArr[$experiment][$contentGroupKey]["index"] = $contentIndex;
			
			$dialogItem = $dialogContent->getWrapped("items")->getWrapped($contentIndex);

			// Prepare content for sending
			//Log::d("Dialog data: ", $dialogItem->getArray());
			$text = $dialogItem->get("text", $dialogDefaults->get("text", ""));
			$img = $dialogItem->get("img", $dialogDefaults->get("img", null));
			$tags = $dialogItem->get("tags", $dialogDefaults->get("tags", ""));

			$needSend = false;
			if($img){
				$response->setMethod("sendPhoto");
				$response->set("caption", $text);
				$response->setPhoto($img);
				$needSend = true;
			}elseif($text){
				$response->setChatId($chatId);
				$response->setMethod("sendMessage");
				$response->setText($text);				
				$needSend = true;
			}

			if(!$needSend){
				continue;
			}

			// KB
			$kb = $dialogItem->get("kb", $dialogDefaults->get("kb", null));
			$response->set("reply_markup", $kb);
			Log::d("Content to send: text='$text'   img='$img' ", $kb);
			
			BotLog::log("Autsend: " . json_encode($response->getArray()));
			$sendResult = $this->getTransport()->sendResponse($response);
			if ($sendResult && isset($sendResult["ok"]) && isset($sendResult["result"])) {
				$result = $sendResult["result"];
				$messageId = $result["message_id"];
				
				$model->saveSendedMessage($chatId, $messageId, $contentGroupKey, $chatContentContextArr, $tags, $response->getText(), $response->getPhoto());
			}
			
			Log::d("Before saving:",  $chatContentContextArr);
			Log::d("Content index: $contentIndex");
			$model->saveSendedMessage($chatId, 1, $contentGroupKey, $chatContentContextArr, $tags, $response->getText(), $response->getPhoto());
			
			//			$this->sendPreparedResponse($chatId, $contentGroupKey, $contentIndex, $tags, $response);
		}

		return count($chatList);
	}



	function createChatContentConfig($experiment){
		$dialogs = $this->getAllDialogsContent($experiment);
		$dialogsArr = $dialogs->getArray();
		$dialogConfig = [];
		foreach ($dialogsArr as $key => $dialog) {
			$dialogConfig[$key] = $this->createChatContentConfigForGroup();
		}

		return new ArrayWrapper($dialogConfig);
	}
	protected function createChatContentConfigForGroup()
	{
		return [
			"index" => 0
		];
	}


	

	protected function prepareResponse_(&$response, $chatId, $contentGroupKey, $contentConfigLang)
	{
		if ($contentGroupKey == 1) {
			$response->setMethod("sendMessage");
			$response->setText("Доброе утро!");
			//$response->set("reply_markup", $this->getConfig()->getText("kb_content_answer"));
		} elseif ($contentGroupKey == 2) {
			$response->setMethod("sendMessage");
			$response->setText("Спокойной ночи!");
			//$response->set("reply_markup", $this->getConfig()->getText("kb_content_answer"));

		}
	}


	protected function sendPreparedResponse($chatId, $contentGroupKey, $contentIndex, $tags, $response)
	{
		$model = $this->getChatModel();

		$sendResult = $this->getTransport()->sendResponse($response);
		if ($sendResult && isset($sendResult["ok"]) && isset($sendResult["result"])) {
			$result = $sendResult["result"];
			$messageId = $result["message_id"];

			$model->saveSendedMessage($chatId, $messageId, $contentGroupKey, $contentIndex, $tags, $response->getText(), $response->getPhoto());
		}
	}

	public function startCheckingAlarm()
	{
		$model = new ChatModel();
		$chatList = $model->getChatsForAlarm();
		if (!$chatList) {
			Log::d("Nothing to send");
			return 0;
			//throw new \Exception("Error multisending. Wrong chats list", 1);			
		}


		$response = TelegramResponse::createEmptyResponse();

		foreach ($chatList as $chatData) {
			$chatId = $chatData["toChatId"];
			$userName = $chatData["fromUserName"];
			$alarmLevel = $chatData["alarmLevel"];
			$text = $text = $this->getConfig()->getText("alarm_message" . $alarmLevel);
			$text = str_replace("#USER_NAME", $userName, $text);

			$response->setChatId($chatId);
			$response->setText($text);
			$response->setMethod("sendMessage");


			$this->getTransport()->sendResponse($response);
			$model->onAlarmSended($chatId);
		}
		return count($chatList);
	}
}