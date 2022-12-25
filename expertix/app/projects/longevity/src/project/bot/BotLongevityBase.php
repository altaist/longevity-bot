<?php

namespace Project\Bot;

use Expertix\Bot\BotException;
use Expertix\Bot\BotManager;
use Expertix\Bot\ChatInstance;
use Expertix\Bot\Command\BotCommand;
use Expertix\Bot\Log\BotLog;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;
use IBotContext;
use Project\Bot\Model\ChatActionModel;
use Project\Bot\Model\ChatModel;

abstract class BotLongevityBase extends BotManager
{
	private $chatInstance = null;

	protected function onBeforeRun(BotCommand $command)
	{

		$chatId = $this->getChatId();
		//Log::d("Command method: {$command->getMethod()}. Bot chat id=$chatId");

		$this->prepareChatInstance($this, false);
		$this->patchUserName();
		// Update chat activity
		$model = $this->getChatModel();
		$model->updateUserActivity($chatId, $command->getRequestText());

		return true;
	}
	protected function patchUserName()
	{
		$userName = $this->getRequest()->getUserName();
		if (!$userName) {
			return;
		}
		$model = $this->getChatModel();
		$chatId = $this->getChatId();
		$model->updateUserName($chatId, $userName);
	}
	protected function commandStart($context)
	{
		$this->prepareChatInstance($context, true);
	}
	protected function prepareChatInstance($context, $isShowAlreadyExists)
	{
//		print_r("Checking chatInstance<br>");

		$chatInstance = $context->getChatInstance();
		if ($chatInstance) {
			if ($isShowAlreadyExists) {
				$context->sendText($context->getConfig()->getText("chat_created_already"));
			}
			return;
		}

		$chatId = $context->getChatId();
//		print_r("Checking chat from db for chatId=$chatId<br>");
		$chatInstance = $this->getChatFromDb($chatId);

		if ($chatInstance) {
			$this->setChatInstance($chatInstance);
			if ($isShowAlreadyExists) {
				$context->sendText($context->getConfig()->getText("chat_created_already"));
			}
			return;
		}
//		print_r("Creating chatInstance for chatId=$chatId<br>");
		$chatInstance = $this->createChatDb($chatId);
		$this->setChatInstance($chatInstance);
		$this->sendChatCreationResult($chatInstance);
	}

	protected abstract function sendChatCreationResult(ChatInstance $chatInstance);

	private function getChatFromDb($chatId): ? ChatInstance
	{
		$model = $this->getChatModel();
		$res = $model->getChatById($chatId);
		if (!$res) {
			return null;
		}
		return new ChatInstance($res);
	}
	private function createChatDb($chatId): ? ChatInstance
	{

		$model = $this->getChatModel();
		if (!$chatId) {
			throw new BotException("Empty chatId before creating chat in the createChat()", 0);
		}

		$botId = $this->getBotId();
		$request = $this->getRequest();

		$requestArr = [
			"botId" => $botId,
			"chatId" => $chatId,
			"username" => $request->getUserName(),
			"firstName" => $request->getFirstName(),
			"lastName" => $request->getLastName(),
			"lang" => $this->getConfig()->getLang()
		];

		$chat = $model->createChat(new ArrayWrapper($requestArr));
		if (!$chat) {
			return null;
		}
		return new ChatInstance($chat);
	}
	protected function commandStop($context)
	{
		$model = $this->getChatModel();
		$chatId = $context->getChatId();
		$model->deactivateChat($chatId);
		return $context->getConfig()->getText("chat_stopped");
	}

	protected function commandClearTest($context)
	{
		$model = $this->getChatModel();
		BotLog::log("Delete all chats");
		$model->deleteAllChats();
	}

	protected function answer($context)
	{
		$model = new ChatActionModel();
		$model->createAction($context->getChatId(), -1, $context->getCommand()->getRequestText());
		return "Thank you";
	}

	protected function answerNot($context)
	{
		$this->getTransport()->sendCallbackResult("Oops...");
	}


	protected function commandConnectToAnotherChat($context)
	{
		$model = $this->getChatModel();

		$chatId = $context->getChatId();
		$commandText = trim(($context->getRequest()->getText() ?? ""));
		//		Log::d("Requested command text: $commandText");
		$chatLink = $context->getRequest()->getTextWord(1);
		if (!$chatLink) {
			return $context->getConfig()->getText("chat_link_wrong_param");
		}
		//Log::d("CHAT_LINK: chatID='$chatId' Requested chat link: '$chatLink'");

		$this->connectToAnotherChat($context, $chatId, $chatLink);

	}
	protected function processStat($context, $isForChild, $br)
	{
		$chatInstance = $this->getChatInstance();
		$model = $this->getChatModel();
		$chatId = $chatInstance->getChatId();
		$resultText = "";

		$groupsName = ["1" => "Утро", "2" => "Вечер", "10" => "День"];

		$stat = null;
		if ($isForChild) {
			$stat = $model->getStatForLinkedChat($chatId);
		} else {
			$stat = $model->getStatForChat($chatId);
		}

		return self::formatStatistic($stat, $br);
		/*
		if (!$stat || !is_array($stat) || count($stat)<1) {
		$this->sendText("Нет собранных данных для статистики");
		return;
		}
		foreach($stat as $userName => $statForUser){
		if (!$statForUser || !is_array($statForUser) || count($statForUser)<1) {
		$this->sendText("Нет собранных данных для статистики");
		return;
		}
		$user = $userName;
		if($user){
		$resultText .= "Статистика для пользователя: '$user'{$br}";				
		}
		//$this->sendText(json_encode($stat));
		foreach ($statForUser as $key => $row) {
		//print_r($stat);
		$title = $groupsName[$row['contentGroup']] ?? "unknown";
		$avg = $row['avg'] ? $row['avg'] . " мин" : "-";
		$resultText .= "РАССЫЛКА '$title'{$br}Рейтинг: {$row['rating']}. Всего отправлено: {$row['all']}. Отвечено: {$row['answered']}. Не отвечено: {$row['not_answered']}. Среднее время ответа: {$avg}. Последний ответ: {$row['dateLastAnswer']}.{$br}{$br}";
		}
		$resultText .= "{$br}";
		}
		return $resultText;
		*/
	}
	public static function formatStatistic($stat, $br)
	{
		if (!$stat || !is_array($stat) || count($stat) < 1) {
			return "Нет собранных данных для статистики";
		}

		$resultText = "";
		$groupsName = ["1" => "Утро", "2" => "Вечер", "10" => "День"];


		foreach ($stat as $key => $statForUser) {
			if (!$statForUser || !is_array($statForUser) || count($statForUser) < 1) {
				return "Нет собранных данных для статистики";
			}
			//		print_r($statForUser);
			//		exit;

			$user = [];
			$userName = "";
			$affKey = "";
			if (isset($statForUser["user"])) {
				$user = $statForUser["user"];
				$userName = $user["userName"];
				$affKey = $user["affKey"];
				if ($userName) {
					$resultText .= "Статистика для пользователя: '$userName'{$br}";
				}
			}

			$statistic = [];
			if (isset($statForUser["stat"])) {
				$statistic = $statForUser["stat"];
			} else {
				$statistic = $statForUser;
			}

			//$this->sendText(json_encode($stat));
			foreach ($statistic as $key => $row) {
				//print_r($stat);
				$title = $groupsName[$row['contentGroup']] ?? "unknown";
				$avg = $row['avg'] ? $row['avg'] . " мин" : "-";
				$resultText .= "РАССЫЛКА '$title'{$br}Рейтинг: {$row['rating']}. Всего отправлено: {$row['all']}. Отвечено: {$row['answered']}. Не отвечено: {$row['not_answered']}. Среднее время ответа: {$avg}. Последний ответ: {$row['dateLastAnswer']}.{$br}{$br}";
			}
			if ($affKey) {
				$resultText .= "https://longevity-hub.world/bots/stat/?user={$affKey}{$br}";
			}
			$resultText .= "{$br}";
		}
		return $resultText;
	}

	protected function p($context, $isForChild = false)
	{
		$chatInstance = $this->getChatInstance();
		$model = $this->getChatModel();
		$chatId = $chatInstance->getChatId();
		$resultText = "";

		$groupsName = ["1" => "Утро", "2" => "Вечер", "10" => "День"];

		$stat = null;
		if ($isForChild) {
			$stat = $model->getStatForLinkedChat($chatId);
		} else {
			$stat = $model->getStatForChat($chatId);
		}

		if (!$stat) {
			$this->sendText("Нет собранных данных для статистики");
			return;
		}
		//$this->sendText(json_encode($stat));
		foreach ($stat as $key => $row) {
			$title = $groupsName[$row['contentGroup']] ?? "unknown";
			$avg = $row['avg'] ? $row['avg'] . " мин" : "-";
			$resultText .= "РАССЫЛКА '$title'\nРейтинг: {$row['rating']}. Всего отправлено: {$row['all']}. Отвечено: {$row['answered']}. Не отвечено: {$row['not_answered']}. Среднее время ответа: {$avg}. Последний ответ: {$row['dateLastAnswer']}.\n\n";
		}
		$this->sendText($resultText);
	}

	public function getAllDialogsContent($experiment): ArrayWrapper{
		return $this->getConfig()->getContentConfig()->getWrapped($experiment, []);
	}
	public function getDialogContent($experiment, $dialogKey, $lang): ArrayWrapper{
		//Log::d("Content config for $dialogKey: ", $this->getAllDialogsContent($experiment)->getWrapped($dialogKey, []));
		return $this->getAllDialogsContent($experiment)->getWrapped($dialogKey, [])->getWrapped($lang, null);
	}

	protected function getChatModel()
	{
		return $this->createChatModel();
	}
	protected function createChatModel()
	{
		return new ChatModel();
	}

	/**
	 * @return mixed
	 */
	public function getChatInstance()
	{
		return $this->chatInstance;
	}

	/**
	 * @param mixed $chatInstance 
	 * @return self
	 */
	public function setChatInstance($chatInstance): self
	{
		$this->chatInstance = $chatInstance;
		return $this;
	}
}