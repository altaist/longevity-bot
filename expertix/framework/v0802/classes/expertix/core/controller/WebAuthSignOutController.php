<?php
namespace Expertix\Core\Controller;

use Expertix\Core\App\App;
use Expertix\Core\App\AppContext;
use Expertix\Core\Auth\AuthManager;
use Expertix\Core\Controller\Base\BaseController;
use Expertix\Core\Exception\AuthException;
use Expertix\Core\Exception\RedirectException;
use Expertix\Core\Util\Log;

class WebAuthSignOutController extends BaseController{
	public function process()
	{
		$user = $this->getUser();
		$this->signOut($user);
	}
	public function signOut($user)
	{
		
		$authManager = AppContext::getApp()->getUserManager();
		$authManager->signOutAndRedirect($user);
	}	
	
	/*
	protected function redirectSuccess(){
		$auth = $this->getControllerConfig()->get("auth");
		if(!$auth){
			throw new AuthException("Empty auth param in redirect success");
		}

		if (!empty($auth["auth_redirect_signout"])) {
			App::redirectPath($auth["auth_redirect_signout"]);
			return;
		}
		
		App::redirectPath("/");		
	}
	*/
}