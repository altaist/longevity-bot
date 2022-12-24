<?php
namespace Expertix\Core\Test;

use Expertix\Core\App\AppContext;
use Expertix\Core\Controller\Base\BaseController;
use Expertix\Core\Util\Log;

abstract class BaseTestController extends BaseController{

	abstract function prepare();
	abstract function run();

	public function process(){
		try {
			$controllerConfig = $this->getControllerConfig();
			$methodClass = $controllerConfig->get("method");

			$this->prepare();
			if ($methodClass) {
				$this->$methodClass();
			} else {
				$this->run();
			}
			
		} catch (TestException $e) {
			Log::d("Assert failed: ", $e->getMessage());
		}catch (\Throwable $th) {
			throw $th;
		}
	}

	public $wrongCounter = 0;
	public $successCounter = 0;

	public function runFunction($function = null)
	{
		if ($function) {
			$function();
		}
	}

	function getApp()
	{
		return AppContext::getApp();
	}

	function print($message1, $message2, $end = false)
	{
		Log::d($message1, $message2, $end);
	}

	function assertEquals($obj, $testValue, $message = "")
	{

		if ($obj === $testValue) {
			$this->successCounter++;
			return true;
		} else {
			$this->wrongCounter++;
			throw new TestException($obj, $testValue, $message);
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
			throw new TestException($obj, null, $message);
		}
		$this->successCounter++;
		return true;
	}
	function assertNotEmpty($obj, $message)
	{
		if (empty($obj)) {
			$this->wrongCounter++;
			throw new TestException($obj, null, $message);
		}
		$this->successCounter++;
		return true;
	}
	
	
	
}