<?php

namespace Expertix\Bot\Test;

use Expertix\Bot\Telegram\TelegramTransport as TelegramTelegramTransport;
use Project\Bot\TelegramTransport;

class TelegramTransportTest extends TelegramTelegramTransport
{
	public function __construct($config)
	{
		parent::__construct($config);
	}

	public function send($method, $response)
	{
		print_r ("Method: $method. Data:");
		print_r ($response->getResponseDataJson()."<br>");
	}
}
