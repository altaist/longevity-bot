<?php

namespace Expertix\Bot;
interface IBotContext{
	public function getConfig();
	public function getBotId();
	public function getChatId();
	public function getCommand();
	public function getRequest();	
	public function sendText($text);	
	
}