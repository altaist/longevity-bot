<?php

use Expertix\Core\App\AppContext;
use Expertix\Core\Controller\Api\ApiEmailController;
use Expertix\Core\Controller\Base\BaseApiController;
use Expertix\Core\Exception\AppException;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Email\EmailHelper;

class ApiEmail extends ApiEmailController{
	public function onCreate()
	{
		$this->addRoute("email_signup", "emailOnSignup");
	}
	
	public function emailOnSignup(ArrayWrapper $request)
	{
		
		$user = $this->getuser();
		if(!$user){
			return "Wrong email";
		}
		
		$config = AppContext::getConfig();
		$siteBase = $config->getBaseSiteUrl();
		$link = $siteBase . "auth/". $user->get("authLink");

		$emailConfig = $config->getAppParam("email");
		
		$to = $user->get("email");
		$subject = $emailConfig["signup"]["subject"];
		
		
		//$body = "<p>Для входа в систему перейдите по <a href='$link'>этой ссылке</a></p>";
		$body = $emailConfig["signup"]["body"];
		
		if(!$subject || !$body){
			return "No subject or body";
		}

		$emailHelper = AppContext::getEmailManager();
		return $emailHelper->send($to, $subject, $body);
	}
}