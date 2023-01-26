<?php

use Expertix\Bot\BotConfig;
use Expertix\Bot\Telegram\TelegramTransport;
use Expertix\Bot\Test\TelegramTransportTest;
use Expertix\Core\Util\Log;
use Expertix\Core\Util\UUID;
use Project\Bot\BotLongevity1;
use Project\Bot\BotLongevityCron;

$isTest = false;

$configArr = include(__DIR__ . "/config/bot2.cfg.php");
$config = new BotConfig($configArr, "ru");

//echo UUID::gen_uuid("123", 4);

if ($isTest) {
	$transport = new TelegramTransportTest($config);
	$transport->processRequest(["message" => ["from" => [], "chat" => ["id" => "1", "username" => "testuser1"], "text" => "dfdfdf"]]);
	$bot = new BotLongevityCron($config, $transport);

	Log::d("Sending...");
	$bot->startMultiSending();
	Log::d("Checking...");
	$bot->startCheckingAlarm();
} else {
	$transport = new TelegramTransport($config);
	$transport->processRequest([]);
	//$transport->process(["message" => ["from" => [], "chat" => ["id" => "1", "username" => "testuser1"], "text" => "dfdfdf"]]);

	$bot = new BotLongevityCron($config, $transport);

	Log::d("Sending...");
	//$bot->startMultiSending();
	Log::d("Checking...");
	$bot->startCheckingAlarm();
}
