<?php
namespace Project\Bot\Test;

use Expertix\Bot\BotConfig as BotBotConfig;
use Expertix\Bot\Test\TelegramTransportTest;
use Project\Bot\BotConfig;
use Project\Bot\BotLongevity1;
use Project\Bot\TelegramTransport;

class Test1
{
	private $configArr = [
		"token" => "test_token",
		"text_about" => "About bot...",
		"text_help" => "Help...",
		"route"=>[
			"echoRequest"=> "echoRequest",
			"start"=> "start",
			"answer"=> "answer",
		]
	];
	
	public function run($testRequest){
		$config = new BotBotConfig($this->configArr);
		$transport = new TelegramTransportTest($config);
		$transport->processRequest($testRequest);

		$bot = new BotLongevity1($config, $transport);

		$bot->run();
	}
	
}