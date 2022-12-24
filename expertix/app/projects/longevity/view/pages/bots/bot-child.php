<?php

use Expertix\Bot\BotConfig;
use Expertix\Bot\Telegram\TelegramTransport;
use Expertix\Bot\Test\TelegramTransportTest;
use Expertix\Core\Util\Log;
use Expertix\Core\Util\UUID;
use Project\Bot\BotLongevity2;
use Project\Bot\BotLongevityChild;

$isTest = true;
Log::setSilent(!$isTest);
$configArr = include (__DIR__."/config/bot2.cfg.php");
$config = new BotConfig($configArr, "ru");

//echo UUID::gen_uuid("123", 4);

if($isTest){
	$transport = new TelegramTransportTest($config);
	$bot = new BotLongevityChild($config, $transport);
	
	$bot->runFromArrayData(["message" => ["from" => [], "chat" => ["id" => "1", "username" => "testuser1"], "text" => "start"]]);
	$bot->runFromArrayData(["message" => ["from" => [], "chat" => ["id" => "1", "username" => "testuser1"], "text" => "LDG2"]]);
	$bot->runFromArrayData(["message" => ["from" => [], "chat" => ["id" => "1", "username" => "testuser1"], "text" => "1_1"]]);
	exit;

	$bot->runFromArrayData(["message" => ["from" => [], "chat" => ["id" => "5", "username" => "testuser1"], "text" => "dfdfdf"]]);
	$bot->runFromArrayData(["message" => ["from" => [], "chat" => ["id" => "1", "username" => "testuser1"], "text" => " "]]);
	$bot->runFromArrayData(["message" => ["from" => [], "chat" => ["id" => "5", "username" => "testuser1"], "text" => "stArt"]]);
	$bot->runFromArrayData(["message" => ["from" => [], "chat" => ["id" => 1, "username" => "testuser2"], "text" => "/sta rt"]]);
	$bot->runFromArrayData(["message" => ["from"=>[], "chat" => ["id" => 1, "username" => "testuser1"], "text" => "stop"]]);
	$bot->runFromArrayData(["message" => ["from"=>[], "chat" => ["id" => 1, "username" => "testuser1"], "text" => "start"]]);
	$bot->runFromArrayData(["message" => ["from"=>[], "chat" => ["id" => 2, "username" => "testuser3"], "text" => "start"]]);
	$bot->runFromArrayData(["message" => ["from"=>[], "chat" => ["id" => 3, "username" => "testuser3"], "text" => "start"]]);
	$bot->runFromArrayData(["message" => ["from"=>[], "chat" => ["id" => 1, "username" => "testuser"], "text" => "help"]]);
	$bot->runFromArrayData(["message" => ["from"=>[], "chat" => ["id" => 1, "username" => "testuser"], "text" => "key"]]);
	$bot->runFromArrayData(["message" => ["from"=>[], "chat" => ["id" => 2, "username" => "testuser"], "text" => "link 1_1"]]);
	$bot->runFromArrayData(["message" => ["from"=>[], "chat" => ["id" => 2, "username" => "testuser"], "text" => "unlink"]]);
	$bot->runFromArrayData(["message" => ["from" => [], "chat" => ["id" => 2, "username" => "testuser"], "text" => "link 1_1"]]);
	//$bot->runFromArrayData(["message" => ["from"=>[], "chat" => ["id" => 2, "username" => "testuser"], "text" => "unlink"]]);
	
	$bot->runFromArrayData(["message" => ["from"=>[], "chat" => ["id" => 3, "username" => "testuser"], "text" => "link  1_1"]]);
	
}else{
		$transport = new TelegramTransport($config);
		$bot = new BotLongevityChild($config, $transport);
		$bot->runFromRequest();

}