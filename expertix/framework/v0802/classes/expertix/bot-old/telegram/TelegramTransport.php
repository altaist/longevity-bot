<?php

namespace Expertix\Bot\Telegram;

use Expertix\Bot\BotTransportAbstract;

class TelegramTransport extends BotTransportAbstract
{
	protected $DEFAULT_API_URL = 'https://api.telegram.org/bot';
	
	public function createRequest($requestData){
		return new TelegramRequest($requestData);
	}
	public function createResponse()
	{
		return TelegramResponse::createFromRequest($this->getRequest());
	}
}
