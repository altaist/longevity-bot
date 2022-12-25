<?php
namespace Project\Bot;

use Expertix\Bot\BotAbstract;
use Expertix\Bot\Log\BotLog;
use Expertix\Bot\Model\ChatModel;
use Expertix\Bot\Model\ChatActionModel;
use Expertix\Bot\Telegram\TelegramResponse;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;

class BotLongevityParent extends BotLongevityBase
{
	protected function sendChatCreationResult($chatInstance)
	{
		//Log::d("Chat after creating", $chat);
		$this->sendText($this->getConfig()->getText("chat_created"));
		$this->sendText($chatInstance->getAuthKey());
	}

	//
	protected function commandGetPassword($context)
	{
		$chatInstance = $this->getChatInstance();
		if (!$chatInstance) {
			return $context->getConfig()->getText("error_not_registered");
		}
		$linkKey = $chatInstance->getLinkKey();
		return $context->getConfig()->getText("chat_link_created") . "" . $linkKey;

	}
	protected function commandQuestion($context)
	{
		$chatInstance = $this->getChatInstance();
		BotLog::log(json_encode($chatInstance->getArray()));
		//		$questionArr = ["chat_id"=>$chatInstance->getChatId(), "text"=>"Тестовый вопрос"];
		$questionResponse = TelegramResponse::createTextResponse($chatInstance->getChatId(), "Тестовый вопрос");
		$questionResponse->set("reply_markup", $context->getConfig()->getText("kb_content_answer"));
		BotLog::log(json_encode($context->getConfig()->getText("kb_content_answer")));
		$this->getTransport()->sendResponse($questionResponse);
	}
	protected function commandLike($context)
	{

		$answerText = "Спасибо за ответ!";
		$this->processAnswer($context, 1);
	}
	protected function commandDislike($context)
	{
		$answerText = "Спасибо за ответ! Мы постараемся реже присылать вам такие сообщения";
		$this->processAnswer($context, -1);
	}
	
	private function processAnswer($context, $rating){
		$chatInstance = $this->getChatInstance();
		$model = $this->getChatModel();
		$chatId = $chatInstance->getChatId();
		//$lang = $chatInstance->getLang($this->getConfig()->getLang());
		$lang = $this->getConfig()->getLang();
		$experiment = 0;
		$messageId = $context->getTransport()->getRequest()->getMessageId();
		
		$replacedText = "Thank you!";
		$contentGroup = 1;
		
		$messageDb = $model->onAnswerRecieved($chatId, $messageId, $rating, $context->getCommand()->getRequestTextOrigin());
		if($messageDb){
			$contentGroup = $messageDb["contentGroup"];
		}
		
		//$contentConfigLang = $this->getConfig()->getContentConfigForGroupLang($contentGroup);
		$contentConfigLang = $this->getDialogContent($experiment, $contentGroup, $lang);
		$contentConfigDefaults = $contentConfigLang->getWrapped("default"); 
		$currentDialog = $contentConfigLang->getWrapped("default"); 

		$replacedText = $contentConfigDefaults->get("text_after_like");

		// Send callback result
		$this->getTransport()->sendCallbackResult("");

		// Send customised answer 
		$response = TelegramResponse::createTextResponse($chatId, $replacedText);
		//$response->set("reply_markup", $context->getConfig()->getText("kb_content_answer_edited"));
		$response->set("message_id", $messageId);
		
		if($contentGroup==10){
			$response->setMethod("editMessageCaption");
			$response->set("caption", $replacedText);			
		}else{
			$response->setMethod("editMessageText");
			$response->set("text", $replacedText);						
		}
		
		BotLog::log("processAnswer: " . json_encode($response->getArray()));
		$this->getTransport()->sendResponse($response);
		
		//$this->sendText($answerText);
	}

	protected function createLink($context)
	{

		$model = $this->getChatModel();

		$link = $model->createLinkKey($context->getChatId());
		if (!$link) {
			return $context->getConfig()->getText("chat_link_error") . "" . $link;
		}
		return $context->getConfig()->getText("chat_link_created") . "" . $link;
	}

	protected function commandStat($context)
	{
		$resultText = $this->processStat($context, false, "\n");
		$this->sendText($resultText);
	}


}