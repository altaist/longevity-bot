<?php

namespace Expertix\Bot;

use Expertix\Bot\Command\BotCommand;
use Expertix\Bot\IBotContext;
use Expertix\Bot\Log\BotLog;
use Expertix\Bot\Model\ChatModel;
use Expertix\Bot\Telegram\TelegramResponse;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;

class BotManager implements IBotContext
{
	private $config = [];
	private $transport = null;
	private $app = null;
	private $router = [];
	private $defaultCommand;
	private $lastCommand = null;

	
	function __construct(BotConfig $config, $transport)
	{
		$this->config = $config;
		$this->transport = $transport;
		$this->router = new BotRouter();
		
		$this->onCreate();
	}
	protected function onCreate()
	{
		$this->loadCommandsFromConfig();
	}
	protected function onBeforeRun(BotCommand $command)
	{
		return true;
	}
	protected function processResult($response)
	{
		if ($response == null) {
			return;
		}

		if (is_string($response)) {
			$this->sendText($response);
		} elseif (is_array($response)) {
			$this->transport->sendResponse($response);
		} elseif (is_object($response) && is_subclass_of($response, ArrayWrapper::class, false)) {
			$this->transport->sendResponse($response->getArray());
		}
		
	}
	
	protected function echoRequest(){
		$this->sendText($this->transport->getRequest()->getRequestData());
	}
	
	protected function help($context){
		return $this->config->getTextHelp();
	}
	protected function about($context)
	{
		return $this->config->getTextAbout();
	}
	
	protected function sendError($error = null){
		$this->sendText($error?$error:$this->config->getTextAppError());
	}
	
	public function sendText($text){
		$this->transport->sendText($text);
	}
	protected function defaultCommand($context){
		$this->transport->sendText($this->config->getTextWrongCommand());
	}
	
	//
	
	protected function loadCommandsFromConfig(){
		$router = $this->router;
		$router->addCommand("help", "help");
		$router->addCommand("about", "about");
		$router->addCommand("start", "start");
		$router->addCommand("stop", "stop");
		$router->loadFromArray($this->config->getRoute());
	}
	
	
	
	//
	public function runFromRequest()
	{
		$transport = $this->getTransport();
		$transport->processRequest();
		$this->run();
		
	}

	public function runFromArrayData($requestData)
	{
		$transport = $this->getTransport();
		$transport->processRequest($requestData);
		$this->run();
		$this->setChatInstance(null);
	}

	
	private function run()
	{
		try {
			$context = $this;
			$request = $this->getTransport()->getRequest();
			$messageOrigin = $request->getTextOrigin();
			$key = $request->getTextWord(0);
			$key = mb_strtolower($key, 'utf-8');
			$key = str_replace("/","", $key);

			$command = $this->route($key);
			$command->setRequestText($key);
			$command->setRequestTextOrigin($messageOrigin);
			$context->setCommand($command);
			//Log::d("Run", $command->getArray());

			$func = $command->getMethod();
			//Log::d("<br><br>Func: $func");

			if(!$this->onBeforeRun($command)){
				return;
			}


			if (!method_exists($this, $func)) {
				$this->sendText($func);
				return;
			} else {
				// Calling a func
				$response = $this->$func($context);
			}

			return $this->processResult($response);

		} catch (\Throwable $th) {
			BotLog::error($th);
			Log::e($th->getMessage());
			throw $th;
			//$this->sendText($this->config->getTextAppError());
		}
	}
	
	
	protected function route($key){
		$command = $this->router->route($key);
		if (!$command) {
			$command = $this->getDefaultCommand();
		}
		return $command;
	}
	
	public function getDefaultCommand(){
		return new BotCommand(["method" => "defaultCommand", "key" => "defaultCommand"]);
	}
	
	protected function getTransport(): BotTransportAbstract{
		return $this->transport;
	}
	// Implements IBotContext
	public function getBotId()
	{
		return $this->getConfig()->getBotId();
	}
	public function getConfig()
	{
		return $this->config;
	}	
	public function getChatId()
	{
		
		$chatId = $this->getTransport()->getMessageChatId() .   "_" . $this->getBotId();
		if (!$chatId) {
			throw new BotException("Empty chatId in getChatId()", 0);
		}
		return $chatId;

	}
	public function getRequest()
	{
		return $this->getTransport()->getRequest();
	}
	public function getCommand()
	{
		return $this->lastCommand;
	}
	public function setCommand($command)
	{
		$this->lastCommand = $command;
	}
	


}