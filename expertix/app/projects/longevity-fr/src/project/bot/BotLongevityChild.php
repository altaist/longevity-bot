<?php
namespace Project\Bot;

use Expertix\Bot\BotAbstract;
use Expertix\Bot\Model\ChatModel;
use Expertix\Bot\Model\ChatActionModel;
use Expertix\Bot\Telegram\TelegramResponse;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;

class BotLongevityChild extends BotLongevityBase
{
	protected function sendChatCreationResult($chatInstance)
	{
		//Log::d("Chat after creating", $chat);
		$this->sendText($this->getConfig()->getText("chat_created_child"));
		$this->sendText($chatInstance->getAuthKey());
	}


	protected function defaultCommand($context)
	{
		$command = $context->getCommand();
		$commandText = $command->getRequestTextOrigin();
		if (!$commandText) {
			parent::defaultCommand($context);
			return;
		}

		// Check if input text is a correct password
		$chatId = $context->getChatId();
		$model = $this->getChatModel();
		$chatLink = trim($commandText);
		if ($model->getChatByAffKey($chatLink)) {
			// Yes, this is a password
			return $this->connectToAnotherChat($context, $chatId, $chatLink);
		}

		parent::defaultCommand($context);
	}
	protected function connectToAnotherChat($context, $chatId, $chatLink)
	{
		$model = $this->getChatModel();

		//Log::d("CHAT_LINK: chatID='$chatId' Requested chat link: '$chatLink'");

		$newLink = $model->createChatLink($chatId, $chatLink);
		if ($newLink) {
			return $context->getConfig()->getText("chat_link_established");
		} else {
			return $context->getConfig()->getText("chat_link_established_error");
		}
	}
	protected function unlinkFromAnotherChat($context)
	{
		$model = $this->getChatModel();
		$chatId = $context->getChatId();
		$result = $model->deleteChatLink($chatId);
		if ($result) {
			return $context->getConfig()->getText("chat_unlink_result");
		} else {
			return $context->getConfig()->getText("chat_unlink_error");
		}
	}

	protected function commandStat($context)
	{
		$resultText = $this->processStat($context, true, "\n");
		$this->sendText($resultText);
	}


}