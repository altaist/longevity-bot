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
		$this->processAnswer($context, 0, 1);
	}
	protected function commandDislike($context)
	{
		$this->processAnswer($context, 1, -1);
	}

	protected function commandDontKnow($context)
	{
		$this->processAnswer($context, 2, 0);
	}

	private function processAnswer($context, $actionIndex, $rating)
	{
		Log::d("<pre>");
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
		// Send callback result
		$this->getTransport()->sendCallbackResult("");

		if (!$messageDb) {
			return;
		}
		$contentGroup = $messageDb["contentGroup"];
		$dialogIndex = $messageDb["contentIndex"];
		//$contentGroup = 1;
		//$dialogIndex = 2;

		//$contentConfigLang = $this->getConfig()->getContentConfigForGroupLang($contentGroup);
		$contentConfigLang = $this->getDialogContent($experiment, $contentGroup, $lang);
		//Log::d($contentConfigLang->getArray());
		
		$currentDialog = $contentConfigLang->getWrapped("items")->getWrapped($dialogIndex);
		Log::d($currentDialog->getArray());
		$currentDialogDefault = $contentConfigLang->getWrapped("default");

		$replacedText = $this->getActionAnswer($currentDialog, $currentDialogDefault, $actionIndex);
		Log::d($replacedText);

		// Send customised answer 
		$response = TelegramResponse::createTextResponse($chatId, $replacedText);
		//$response->set("reply_markup", $context->getConfig()->getText("kb_content_answer_edited"));
		$response->set("message_id", $messageId);

		if ($contentGroup == 10) {
			$response->setMethod("editMessageCaption");
			$response->set("caption", $replacedText);
		} else {
			$response->setMethod("editMessageText");
			$response->set("text", $replacedText);
		}

		BotLog::log("processAnswer: " . json_encode($response->getArray()));
		$this->getTransport()->sendResponse($response);

		//$this->sendText($answerText);
	}

	function getActionAnswer($dialog, $dialogDefault, $actionIndex)
	{
		$v = $actionIndex + 1;
		//Log::d($dialog);
		$text = $dialogDefault->get("text_after_$v", $dialogDefault->get("text_after_answer", "!!!"));

		if ($dialog->get("answers")) {
			$answersSrc = $dialog->get("answers");
			$answersArr = $answersSrc;
			if (is_string($answersSrc)) {
				$answersArr = explode(";", $answersSrc);
			}

			if (!is_array($answersArr) || count($answersArr) <= 1) {
				$text = $answersSrc;
			} else {

				if ($actionIndex >= 0 && $actionIndex < count($answersArr)) {
					$text = $answersArr[$actionIndex];
				}
			}
		}

		return $text;
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
