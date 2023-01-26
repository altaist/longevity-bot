<?php
//https://api.telegram.org/bot5781044699:AAExq1aQ__u9wJpNLXXyQXfDc9J_6lZY9sQ/setwebhook?url=https://longevity-hub.world/bots/bot-parent/
$res = include(__DIR__."/res.cfg.php");
return [
	"bot_id"=>1,
	"token" => "5781044699:AAExq1aQ__u9wJpNLXXyQXfDc9J_6lZY9sQ",
	"api_url" => "https://api.telegram.org/bot",
	"complex_chat_id" => true,

	"res" => $res,
	"route" => [
		"echo" => "echoRequest",
        "start" => "commandStart",
		"stop" => "commandStop",
		"key" => ["method" => "commandGetPassword"],
		"password" => ["method" => "commandGetPassword"],

		"question" => ["method" => "commandQuestion"],
		"like" => ["method" => "commandLike"],
		"dislike" => ["method" => "commandDislike"],
		"dontknow" => ["method" => "commandDontKnow"],
		"action_0" => ["method" => "commandAction0"],
		"action_1" => ["method" => "commandAction1"],
		"action_2" => ["method" => "commandAction2"],
		"action_3" => ["method" => "commandAction3"],
		"action_4" => ["method" => "commandAction4"],
		"stat" => ["method" => "commandStat"],
		
		"set" => ["method" => "commandSettings"],
		"lang" => ["method" => "commandSetLang"],
		"en" => ["method" => "commandSetLangEng"],
		"ru" => ["method" => "commandSetLangRu"],
		"local" => ["method" => "commandSetLocal"]
	]
];
