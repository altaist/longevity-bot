<?php



$tester = new \Project\Bot\Test\Test1();
$tester->run(["message" => ["from"=>[], "chat" => ["id" => 1, "username" => "testuser"], "text" => "start"]]);
$tester->run(["message" => ["from"=>[], "chat" => ["id" => 1, "username" => "testuser"], "text" => "answer"]]);