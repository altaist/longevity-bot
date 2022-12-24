<?php
namespace Expertix\Core\Controller\Api;

use Expertix\Core\App\AppContext;
use Expertix\Core\Auth\AuthManager;
use Expertix\Core\Controller\Base\BaseController;

class ApiAuthByVkController extends BaseController{
	public function process()
	{
		$authManager = AppContext::getApp()->getAuthManager();
		$authManager->auth($this);
	}
}