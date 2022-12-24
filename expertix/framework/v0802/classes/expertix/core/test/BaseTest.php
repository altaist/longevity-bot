<?php

namespace Expertix\Core\Util\Tester;

use Expertix\Core\App\AppContext;
use Expertix\Core\util\MyLog;

class BaseTester{
	public $wrongCounter = 0;
	public $successCounter = 0;

	public function runFunction($function=null){
		if($function){
			$function();
		}
	}
	
	function getApp(){
		return AppContext::getApp();
	}
	
	function print($message1, $message2, $end=false){
		MyLog::d($message1, $message2, $end);
	}

	function assertEquals($obj, $testValue, $message = "")
	{

		if ($obj === $testValue) {
			$this->successCounter++;
			return true;
		} else {
			$this->wrongCounter++;
			throw new TesterException($obj, $testValue, $message);
		}
	}

	function assertNull($obj, $message)
	{
		return $this->assertEquals($obj, null, $message);
	}

	function assertNotNull($obj, $message)
	{
		if ($obj === null) {
			$this->wrongCounter++;
			throw new TesterException($obj, null, $message);
		}
		$this->successCounter++;
		return true;
	}
	function assertNotEmpty($obj, $message)
	{
		if (empty($obj)) {
			$this->wrongCounter++;
			throw new TesterException($obj, null, $message);
		}
		$this->successCounter++;
		return true;
	}
}


