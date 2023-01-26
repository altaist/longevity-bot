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
			if (!$dialogContent) {
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
			if ($img) {
				$response->setMethod("sendPhoto");
				$response->set("caption", $text);
				$response->setPhoto($img);
				$needSend = true;
			} elseif ($text) {
				$response->setChatId($chatId);
				$response->setMethod("sendMessage");
				$response->setText($text);
				$needSend = true;
			}

			if (!$needSend) {
				continue;
			}

			// KB
//			$kb = $dialogItem->get("kb", $dialogDefaults->get("kb", null));
			$kb = $this->createKb($dialogItem, $dialogDefaults, $chat);
			$questionType = 0;
			if($kb){
				$questionType = 1;
			}
			$response->set("reply_markup", $kb);
			Log::d("Content to send: text='$text'   img='$img' ", $kb);

			BotLog::log("Autsend: " . json_encode($response->getArray()));
			$sendResult = $this->getTransport()->sendResponse($response);
			if ($sendResult && isset($sendResult["ok"]) && isset($sendResult["result"])) {
				$result = $sendResult["result"];
				$messageId = $result["message_id"];

				$model->saveSendedMessage($chatId, $messageId, $contentGroupKey, $contentIndex, $questionType, $chatContentContextArr, $tags, $response->getText(), $response->getPhoto());
			}

			Log::d("Before saving:",  $chatContentContextArr);
			Log::d("Content index: $contentIndex");

			//			$this->sendPreparedResponse($chatId, $contentGroupKey, $contentIndex, $tags, $response);
		}

		return count($chatList);
	}



	function createChatContentConfig($experiment)
	{
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

	function createKb($dialog, $dialogDefault, $chat)
	{

		if ($dialog->get("kb")) {
			return $dialog->get("kb");
		}
		if (!$dialog->get("actions")) {
			return $dialogDefault->get("kb");
		}

		$kb = $dialogDefault->get("kb", null);
		$buttons = null;

		$actionSrc = $dialog->get("actions");
		if (is_array($actionSrc)) {
			$arr = $actionSrc;
			$buttons = $this->parseActionsFromArr($arr);
		} elseif (is_string($actionSrc)) {
			$arr = explode(";", $actionSrc);
			if (is_array($arr)) {
				$buttons = $this->parseActionsFromArr($arr);
			}
		}
		if (!$buttons) {
			return null;
		}

		$kb = [];
		$kb['inline_keyboard'] = $buttons;
		return $kb;
	}

	function parseActionsFromArr($actionsArr, $type = "like")
	{
		if (!is_array($actionsArr)) {
			return null;
		}
		$buttons = [];
		$count = count($actionsArr);
		$commands = ["like", "dislike"];
		if ($count > 2) {
			$commands = [];
			for ($i = 0; $i < $count; $i++) {
				$commands[] = "action_$i";
			}
		}

		for ($i = 0; $i < $count; $i++) {
			$item = $actionsArr[$i];
			if (is_string($item)) {
				$text = trim($item);
				if(strlen($text)<2){
					$buttons[] = [["text" => $text, "callback_data" => $commands[$i]]];
				}else{
					$buttons[] = [["text" => $text, "callback_data" => $commands[$i]]];
				}
			} elseif (is_array($item) && count($item) > 1) {
				$buttons[] = ["text" => $item[0], "callback_data" => $item[1]];
			}
		}

		return $buttons;
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
