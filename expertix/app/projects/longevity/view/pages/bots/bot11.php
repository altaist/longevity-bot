<?php

use Expertix\Bot\BotConfig;
use Expertix\Bot\Telegram\TelegramTransport;
use Expertix\Bot\Test\TelegramTransportTest;
use Expertix\Core\Util\UUID;
use Project\Bot\BotLongevity1;

$isTest = true;

$configArr = include (__DIR__."/bot1.cfg.php");
$config = new BotConfig($configArr, "en");

//echo UUID::gen_uuid("123", 4);

if($isTest){
	$transport = new TelegramTransportTest($config);
	$bot = new BotLongevity1($config, $transport);

	$transport->processRequest(["message" => ["from" => [], "chat" => ["id" => "2", "username" => "testuser1"], "text" => "stop"]]);
	$bot->run();
	
}else{
		$transport = new TelegramTransport($config);
		$transport->processRequest($testRequest);

		$bot = new BotLongevity1($config, $transport);
		$bot->run();
}