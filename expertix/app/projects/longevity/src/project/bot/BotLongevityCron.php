<?php
namespace Project\Bot;

use Expertix\Bot\BotAbstract;

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
	public function startMultiSending($contentGroup)
	{
		$model = $this->getChatModel();
		$chatList = $model->getChatsForUpdate();
		if (!$chatList) {
			Log::d("Nothing to send");
			return 0;
			//throw new \Exception("Error multisending. Wrong chats list", 1);			
		}
		$response = TelegramResponse::createEmptyResponse();
		
		$contentConfigLang = $this->getConfig()->getContentConfigForGroupLang($contentGroup);
		$contentConfig = $this->getConfig()->getContentConfigForGroup($contentGroup);
		//$images = $this->getConfig()->getImgResources();
		
		foreach ($chatList as $chatData) {
			Log::d("Sending content to chat:", $chatData);
			$chatId = $chatData["chatId"];
			$response->setChatId($chatId);
			
			
			$contentIndex = $chatData["lastContentIndex"];

			$tags = "";
			$text = $contentConfigLang->get("text", "");
			$response->setText($text);
			if($contentGroup==10){
				$images = $contentConfig->get("img", []);

				$maxContentIndex = count($images) - 1;
				$maxContentIndex = $maxContentIndex < 0 ? 0 : $maxContentIndex;
				if (++$contentIndex > $maxContentIndex) {
					$contentIndex = 0;
				}
				
				$response->setMethod("sendPhoto");
				$response->set("caption", $text);
				$response->setPhoto($images[$contentIndex][0]);
				if(isset($images[$contentIndex][1])){
					$tags = $images[$contentIndex][1];
				}
			}else{
				$response->setMethod("sendMessage");
				$response->setText($text);
			}
			// KB
			$response->set("reply_markup", $contentConfigLang->get("kb"));

			BotLog::log("startMultisending: " . json_encode($response->getArray()));

			$this->sendPreparedResponse($chatId, $contentGroup, $contentIndex, $tags, $response);

			//			$nextContentId = $contentIndex<$maxContentIndex?$contentIndex+1:0;
		}

		return count($chatList);
	}
	

	protected function prepareResponse_(&$response, $chatId, $contentGroup, $contentConfigLang)
	{
		if ($contentGroup == 1) {
			$response->setMethod("sendMessage");
			$response->setText("Доброе утро!");
			//$response->set("reply_markup", $this->getConfig()->getText("kb_content_answer"));
		} elseif ($contentGroup == 2) {
			$response->setMethod("sendMessage");
			$response->setText("Спокойной ночи!");
			//$response->set("reply_markup", $this->getConfig()->getText("kb_content_answer"));

		}
	}


	protected function sendPreparedResponse($chatId, $contentGroup, $contentIndex, $tags, $response)
	{
		$model = $this->getChatModel();

		$sendResult = $this->getTransport()->sendResponse($response);
		if ($sendResult && isset($sendResult["ok"]) && isset($sendResult["result"])) {
			$result = $sendResult["result"];
			$messageId = $result["message_id"];

			$model->saveSendedMessage($chatId, $messageId, $contentGroup, $contentIndex, $tags, $response->getText(), $response->getPhoto());
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