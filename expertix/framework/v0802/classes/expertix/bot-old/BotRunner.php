<?php
namespace Expertix\Bot;

class BotRunner{
	private $config = null;
	private $botClass = null;
	private $transportClass = null;
	private $transport = null;
	private $bot = null;
	function __construct($configArr, $transport, $bot)
	{
		$this->config = new BotConfig($configArr);
		$this->bot = $bot;
		$this->transport = $transport;
	}

	public function run()
	{
		$this->bot->run();
	}
	

	/*
	function __construct($configArr, $botClass, $transportClass)
	{
		$this->config = new BotConfig($configArr);
		$this->transportClass = $transportClass;
		$this->botClass = $botClass;
		$this->transport = $this->createTransport();
		$this->bot = $this->createBot();
	}
	public function createTransport()
	{
		return new $this->transportClass($this->config);
	}
	public function createBot(){
		$bot = new $this->botClass($this->config, $this->transport);
		return $bot;
	}
*/

	// Getters
	public function getConfig()
	{
		return $this->config;
	} 
	public function getTransport()
	{
		return $this->transport;
	} 
	public function getBot()
	{
		return $this->bot;
	} 


}