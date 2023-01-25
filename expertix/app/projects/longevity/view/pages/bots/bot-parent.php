<?php

use Expertix\Bot\BotConfig;
use Expertix\Bot\Telegram\TelegramTransport;
use Expertix\Bot\Test\TelegramTransportTest;
use Expertix\Core\Util\Log;
use Expertix\Core\Util\UUID;
use Project\Bot\BotLongevity1;
use Project\Bot\BotLongevityParent;

$isTest = true;
//Log::setSilent(!$isTest);
$configArr = include (__DIR__."/config/bot1.cfg.php");
$config = new BotConfig($configArr, "en");

//echo UUID::gen_uuid("123", 4);

if($isTest){
	$transport = new TelegramTransportTest($config);
	$bot = new BotLongevityParent($config, $transport);

	$bot->runFromArrayData(["message" => ["from" => [], "chat" => ["id" => "1", "username" => "testuser1"], "text" => "like"]]);
	
	$bot->runFromArrayData(["message" => ["from" => [], "chat" => ["id" => "1", "username" => "testuser1"], "text" => "start"]]);
	$bot->runFromArrayData(["message" => ["from" => [], "chat" => ["id" => "1", "username" => "testuser1"], "text" => "password"]]);
	$bot->runFromArrayData(["message" => ["from" => [], "chat" => ["id" => "2", "username" => "testuser1"], "text" => "start"]]);
	$bot->runFromArrayData(["message" => ["from" => [], "chat" => ["id" => "2", "username" => "testuser1"], "text" => "LDG2"]]);
	exit;
	$bot->runFromArrayData(["message" => ["from" => [], "chat" => ["id" => "1", "username" => "testuser1"], "text" => " "]]);
	$bot->runFromArrayData(["message" => ["from" => [], "chat" => ["id" => "1", "username" => "testuser1"], "text" => "stArt"]]);
	$bot->runFromArrayData(["message" => ["from" => [], "chat" => ["id" => 1, "username" => "testuser2"], "text" => "/sta rt"]]);
	$bot->runFromArrayData(["message" => ["from"=>[], "chat" => ["id" => 1, "username" => "testuser1"], "text" => "stop"]]);
	$bot->runFromArrayData(["message" => ["from"=>[], "chat" => ["id" => 1, "username" => "testuser1"], "text" => "start"]]);
	$bot->runFromArrayData(["message" => ["from"=>[], "chat" => ["id" => 2, "username" => "testuser3"], "text" => "start"]]);
	$bot->runFromArrayData(["message" => ["from"=>[], "chat" => ["id" => 3, "username" => "testuser3"], "text" => "start"]]);
	$bot->runFromArrayData(["message" => ["from"=>[], "chat" => ["id" => 1, "username" => "testuser"], "text" => "help"]]);
	$bot->runFromArrayData(["message" => ["from"=>[], "chat" => ["id" => 1, "username" => "testuser"], "text" => "key"]]);
	$bot->runFromArrayData(["message" => ["from"=>[], "chat" => ["id" => 2, "username" => "testuser"], "text" => "link 1"]]);
	$bot->runFromArrayData(["message" => ["from"=>[], "chat" => ["id" => 2, "username" => "testuser"], "text" => "unlink"]]);
	$bot->runFromArrayData(["message" => ["from" => [], "chat" => ["id" => 2, "username" => "testuser"], "text" => "link 1"]]);
	//$bot->runFromArrayData(["message" => ["from"=>[], "chat" => ["id" => 2, "username" => "testuser"], "text" => "unlink"]]);
	
	$bot->runFromArrayData(["message" => ["from"=>[], "chat" => ["id" => 3, "username" => "testuser"], "text" => "link  1"]]);
	
}else{
		$transport = new TelegramTransport($config);
		//$transport->processRequest();

		$bot = new BotLongevityParent($config, $transport);
		$bot->runFromRequest();

}