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
			Log::d("Sending content to chat:<pre>", $chatData);
			$chat = new ChatInstance($chatData);
			$chatId = $chat->getChatId();
			$lang = $chat->get("lang", $this->getConfig()->getLang());
			$experiment = 0;
			$chatContentConfig = $this->getChatContentConfigForGroup($chat, $contentGroupKey);
			Log::d("Chat config: ", $chatContentConfig->getArray());

			$dialogContent = $this->getDialogContent($experiment, $contentGroupKey, $lang);
			
			$contentIndex = $chatContentConfig->getWrapped($contentGroupKey)->get("index");
			$maxContentIndex = $dialogContent->getWrapped("items")->getArraySize();
			if (++$contentIndex > $maxContentIndex) {
				$contentIndex = 0;
			}
			Log::d("ContentIndex: $contentIndex. MaxContentIndex: $maxContentIndex");
			$chatContentConfigArr = $chatContentConfig->getArray();
			$chatContentConfigArr[$contentGroupKey]["index"] = $contentIndex;
			
			$dialogItem = $dialogContent->getWrapped("items")->getWrapped($contentIndex);
			//Log::d("Dialog data: ", $dialogItem->getArray());
			$text = $dialogItem->get("test", "");
			$img = $dialogItem->get("img", null);
			$tags = $dialogItem->get("tags", "");
			
			$response->setChatId($chatId);
			$response->setMethod("sendMessage");
			$response->setText($text);
			
			if($img){
				$response->setMethod("sendPhoto");
				$response->set("caption", $text);
				$response->setPhoto($img);
			}
			
			// KB
			$response->set("reply_markup", $dialogItem->get("kb"));
			BotLog::log("startMultisending: " . json_encode($response->getArray()));
			
			$sendResult = $this->getTransport()->sendResponse($response);
			if ($sendResult && isset($sendResult["ok"]) && isset($sendResult["result"])) {
				$result = $sendResult["result"];
				$messageId = $result["message_id"];
				
				$model->saveSendedMessage($chatId, $messageId, $contentGroupKey, $chatContentConfig, $tags, $response->getText(), $response->getPhoto());
			}
			
			Log::d("Before saving:",  $chatContentConfigArr);
			Log::d("Content index: $contentIndex");
			$model->saveSendedMessage($chatId, 1, $contentGroupKey, $chatContentConfigArr, $tags, $response->getText(), $response->getPhoto());
			
			//			$this->sendPreparedResponse($chatId, $contentGroupKey, $contentIndex, $tags, $response);
			
		}

		return count($chatList);
	}

	protected function getChatContentConfigForGroup(ChatInstance $chat, $groupKey, $experiment = 0)
	{
		$config = $this->_getChatContentConfigForGroup($chat, $groupKey, $experiment);
		if(!$config){
			$config = $this->createChatContentConfig($experiment);
		}
		return $config;
	}
	protected function _getChatContentConfigForGroup(ChatInstance $chat, $groupKey, $experiment=0){
		$configStr = $chat->get("contentConfig");
		if(!$configStr){
			return null;
		}
		$configArr = null;
		$configArr = json_decode($configStr);
		if(!is_array($configArr)){
			//return null;
		}

		//$contentConfig = isset($configArr[$groupKey])?$configArr[$groupKey]:[];
		return new ArrayWrapper($configArr);
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
	function createChatContentConfigForGroup()
	{
		return [
			"index" => 0
		];
	}

	function getAllDialogsContent($experiment): ArrayWrapper{
		return $this->getConfig()->getContentConfig()->getWrapped($experiment, []);
	}
	function getDialogContent($experiment, $dialogKey, $lang): ArrayWrapper{
		//Log::d("Content config for $dialogKey: ", $this->getAllDialogsContent($experiment)->getWrapped($dialogKey, []));
		return $this->getAllDialogsContent($experiment)->getWrapped($dialogKey, [])->getWrapped($lang, null);
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