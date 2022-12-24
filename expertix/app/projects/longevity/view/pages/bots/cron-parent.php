<?php

use Expertix\Bot\BotConfig;
use Expertix\Bot\Telegram\TelegramTransport;
use Expertix\Bot\Test\TelegramTransportTest;
use Expertix\Core\Util\Log;
use Expertix\Core\Util\UUID;
use Project\Bot\BotLongevity1;
use Project\Bot\BotLongevityCron;

$isTest = false;

$configArr = include(__DIR__ . "/config/bot1.cfg.php");
$config = new BotConfig($configArr, "ru");

//echo UUID::gen_uuid("123", 4);

$contentGroup = 0;
if(isset($_GET["contentGroup"])){
	$contentGroup = $_GET["contentGroup"];
}
echo ($contentGroup);
if ($isTest) {
	$transport = new TelegramTransportTest($config);
	$transport->processRequest(["message" => ["from" => [], "chat" => ["id" => "1", "username" => "testuser1"], "text" => "dfdfdf"]]);
	$bot = new BotLongevityCron($config, $transport);

	Log::d("Sending...");
	$bot->startMultiSending(1);
	Log::d("Checking...");
	$bot->startCheckingAlarm();
} else {
	$transport = new TelegramTransport($config);
	$transport->processRequest([]);
	//$transport->process(["message" => ["from" => [], "chat" => ["id" => "1", "username" => "testuser1"], "text" => "dfdfdf"]]);

	$bot = new BotLongevityCron($config, $transport);

	Log::d("Sending...");
	$bot->startMultiSending($contentGroup);
	Log::d("Checking...");
	//$bot->startCheckingAlarm();
}
