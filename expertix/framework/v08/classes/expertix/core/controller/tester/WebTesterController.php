<?php
namespace Expertix\Core\Controller\Tester;

use Expertix\Core\Controller\Base\BaseController;
use Expertix\Core\Exception\AppInitException;

class WebTesterController extends BaseController{
	public function process(){

		$controllerConfig = $this->getControllerConfig();
		$testerClass = $controllerConfig->get("tester_class");
		
		if(!$testerClass){
			throw new AppInitException("Error tester class", 1);
		}
		
		$tester = new $testerClass();
		$tester->run();
	}
}