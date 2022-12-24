<?php
namespace Expertix\Bot;

use Expertix\Bot\Command\BotCommand;
use Expertix\Core\Util\Log;

class BotRouter
{
	private $routeArr = [];
	
	function __construct($routeArr=null)
	{
		if($routeArr){
			$this->loadFromArray($routeArr);
		}
	}
	
	public function clear(){
		$this->routeArr = [];
	}
	protected function getRouteArray(){
		return $this->routeArr;
	}

	public function loadFromArray($srcRouteArr)
	{
		if (!$srcRouteArr) return;
		foreach ($srcRouteArr as $key => $commandData) {
			$this->addCommand($key, $commandData);
		}
	}

	public function addCommand($key, $commandData)
	{
		$command = null;
		if (is_string($commandData)) {
			$command = new BotCommand(["method" => $commandData]);
		} else if (is_array($commandData)) {
			$command = new BotCommand($commandData);
		} else {
			$command = $commandData;
		}
		
		return $this->addCommandToArr($key, $command);

	}

	private function addCommandToArr($key, $command)
	{

		$this->routeArr[$key] = $command;
//		Log::d("Added command to array. Array is:", $this->routeArr);
		return $command;
	}

	//

	public function route($key)
	{
		$command = $this->searchCommand($key);
		return $command;
	}
	protected function searchCommand($key)
	{
//		$routeArr = $this->getRouteArray();
//		Log::d("Search for $key :", $routeArr);
		return isset($this->routeArr[$key]) ? $this->routeArr[$key] : null;
	}
}
