<?php
namespace Test\App;

use Expertix\Core\Test\BaseTestController;
use Expertix\Core\Util\Log;

class AppTestController {

	public function prepare()
	{
	}

	public function run()
	{
		Log::d("App test");
	}
} 