<?php
namespace Expertix\Core\Controller;

use Expertix\Core\App\AppContext;
use Expertix\Core\User\Exception\WrongUserException;
use Expertix\Core\Util\Log;

class WebAuthByLinkController extends WebPageController{
	public function process()
	{
		try {
			$userManager = AppContext::getApp()->getUserManager();
			$authLink = $this->getAuthLinkFromParams();
			
			if(!$authLink){
				throw new WrongUserException("Empty authLink parameter", 0);
			}
			
			$user = $userManager->authByLink($authLink);
			//Log::d("WebAuthByLink result", $user);
			$this->setUser($user);
			$userManager->redirectSuccess($user);
			
		} catch (WrongUserException $e) {
			$userManager->processError($e);			
		} 
		
		return parent::process();
	}
	
	public function getAuthLinkFromParams(){
		$authLink = "";
		$controllerConfig = $this->getControllerConfig();
		
		$routerParts = $controllerConfig->get("routerParts", null);
		if (is_array($routerParts) && !empty($routerParts[1]) && ($routerParts[0] == "client" || $routerParts[0] == "auth")) { // like url='/auth/dsfdfwfssdsvdsf'
			$authLink = $routerParts[1];
			//			Log::d("Auth by link from router parts: $authLink", "", 1);
		} else if (!empty($controllerConfig->get("authLink"))) {
			$authLink = $controllerConfig->get("authLink");
			//MyLog::debug("Auth by link from controllerConfigArray: $authLink");
		}
		
		return $authLink;
	}
	
}