<?php
//https://api.telegram.org/bot5488879546:AAEc-1Jrf9nk0GhJt0zVbX-TVXk0PmmTfnk/setwebhook?url=https://longevity-hub.world/bots/bot-child/
$res = include(__DIR__ . "/res.cfg.php");
return [
	"bot_id"=>2,
	"api_url" => "https://api.telegram.org/bot",
	"token" => "5488879546:AAEc-1Jrf9nk0GhJt0zVbX-TVXk0PmmTfnk",
	"complex_chat_id" => true,
	"res" => $res,
	"route" => [
		"echo" => "echoRequest",
		"start" => "commandStart",
		"stop" => "commandStop",
		"answer" => [
			"method" => "answer"
		],

//		"link" => ["method" => "connectToAnotherChat"],
		"unlink" => ["method" => "unlinkFromAnotherChat"],
		"stat" => ["method" => "commandStat"],



	]
];
