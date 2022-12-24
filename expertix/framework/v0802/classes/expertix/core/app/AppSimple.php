<?php

namespace Expertix\Core\App;

use Expertix\Core\App\Response\AppResponse;
use Expertix\Core\Config\Config;
use Expertix\Core\Auth\AuthManager;
use Expertix\Core\Controller\Base\BaseController;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Db\DB;

use Expertix\Core\Exception\{AppInitException, RedirectException};
use Expertix\Core\User\AffHelper;
use Expertix\Core\Util\Log;
use Expertix\Core\util\MyLog;

class AppSimple extends App
{
	public function process()
	{
		$response = null;
		try {
			$response = $this->getResponse();
			$controller = $this->routeController();
			if (!$controller) {
				throw new AppInitException("Ошибка определения контроллера", 1);
			}
			$this->initAppWithController($controller);			
			
			$controller->sendHeader();
			$view = $controller->process();
			if(!$view) return;
			
			$view->render($response);
				
		} catch (RedirectException $e) {
			$url = $e->getRedirectUrl();
			if (!empty($url)) {
				$this->redirectUrl($url);
			}
			$path = $e->getRedirectPath();
			$this->redirectPath($path);
		}catch (AppInitException $e) {
			$response->print("<h2>App init error</h2>");
			$response->print("<h3>Error:" . $e->getMessage() . "</h3>");
			$response->print("<h3>Code:" . $e->getCode() . "</h4>");
		}catch (\Throwable $e) {
			$response->print("<h2>App Error</h2>");
			$response->print("<h3>Error:" . $e->getMessage() . "</h3>");
			$response->print("<h3>Code:" . $e->getCode() . "</h4>");
			if($this->isDebug()){
				$response->print($e->getTraceAsString());
			}
		}
		
//		MyLog::printLog();
	}

	protected function initAppWithController($controller){
	}

}
