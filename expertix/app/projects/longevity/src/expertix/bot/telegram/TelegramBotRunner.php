<?php
namespace Expertix\Bot\Telegram;

use Expertix\Bot\BotRunner;

class TelegramBotRunner extends BotRunner{
	function __construct($configArr, $botClass, $transportClass){
		parent::__construct($configArr, $botClass, TelegramTransport::class);
	}
}