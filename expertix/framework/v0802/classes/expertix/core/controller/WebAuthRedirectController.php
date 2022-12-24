<?php
namespace Expertix\Core\Controller;

use Expertix\Core\App\App;
use Expertix\Core\App\AppContext;
use Expertix\Core\Auth\AuthManager;
use Expertix\Core\Controller\Base\BaseController;
use Expertix\Core\Exception\AuthException;
use Expertix\Core\Exception\RedirectException;
use Expertix\Core\Util\Log;

class WebAuthRedirectController extends BaseController{
	public function process()
	{
		if (!empty($auth["auth_redirect_signout"])) {
			App::redirectPath($auth["auth_redirect_signout"]);
			return;
		}

		$auth = $this->getAuth();
		if($auth){
			$this->redirectSuccessAuth($auth);
		}
		
	}
	
	protected function redirectSuccessAuth($authArray){
		$controllerData = $this->getControllerConfig()->getArray();
		$authConfig = $this->getControllerConfig()->get("auth");
		if(!$authConfig){
			throw new AuthException("Empty auth param in redirect success");
		}
		
//		Log::d("RedirectController processWeb", $controllerData, 1);
		
		if (!empty($authConfig["auth_redirect_success"])) {
			App::redirectPath($authConfig["auth_redirect_success"]);
			return;
		}
		if (!empty($controllerData["roles"]) && isset($authArray["role"])) {
			$roles = $controllerData["roles"];
			$userRole = $authArray["role"];
			if (!empty($roles[$userRole])) {
				$url =  $roles[$userRole];
				//Log::d("RedirectController processWeb", $url, 1);
				App::redirectPath($url);
			}
		}
		
		App::redirectPath("/");
		
	}
}