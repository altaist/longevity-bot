<?php

namespace Expertix\Core\User;

use Expertix\Core\App\AppContext;
use Expertix\Core\Exception\AppException;
use Expertix\Core\Util\Log;

class UserMessageManager{
	

	public function notifyUserOnSignup($user, $lng=""){
		$lang = "";
		if ($lng) $lang = "_" . $lang;

		$emailConfig = AppContext::getEmailConfig("signup".$lang);
		if (!$emailConfig) {
			throw new AppException("Error sending email. Wrong email config", 0);
		}
		$link = $this->createAuthLink($user);

		$to = $user->get("email");
		$subject = $emailConfig->get("subject");
		$body = $emailConfig->get("body");

		if (!$subject || !$body) {
			throw new AppException("Error sending email. No subject or body", 0);
		}

		$body = str_replace("#LINK#", $link, $body);

		$emailHelper = AppContext::getEmailManager();
		return $emailHelper->send($to, $subject, $body);
	}

	public function notifyAdminOnSignup($user, $lng = "")
	{
		$emailConfig = AppContext::getEmailConfig("signup_admin");
		if (!$emailConfig) {
			throw new AppException("Error sending email. Wrong email config", 0);
		}
		$link = $this->createAuthLink($user);

		$to = $emailConfig->get("to", "apechersky@ya.ru");
		$subject = $emailConfig->get("subject");
		$body = $emailConfig->get("body");

		if (!$subject || !$body) {
			throw new AppException("Error sending email. No subject or body", 0);
		}

		$body .= "<div>User id: " . $user->get("userId") . "</div>";
		$body .= "<div>User name: " . $user->get("firstName") . "</div>";
		$body .= "<div>User email: " . $user->get("email") . "</div>";
		$body .= "<div>User tel: " . $user->get("tel") . "</div>";
		$body .= "<div>User auth link: <a href=\"$link\">" . str_replace("#LINK#", $link, $body) . "</a></div>";
		
		Log::d("notifyAdminOnSignup", $body);

		$emailHelper = AppContext::getEmailManager();
		return $emailHelper->send($to, $subject, $body);
	}

	public function notifyAdminOnFormSubmit($form, $lng = "")
	{
		$emailConfig = AppContext::getEmailConfig("form_submit_admin");
		if (!$emailConfig) {
			throw new AppException("Error sending email. Wrong email config", 0);
		}

		$to = $emailConfig->get("to", "apechersky@ya.ru");
		$subject = $emailConfig->get("subject");
		$body = $emailConfig->get("body");

		if (!$subject) {
			throw new AppException("Error sending email. No subject or body", 0);
		}

		$body .= "<div>Form Id: " . $form->get("formId") . "</div>";
		$body .= "<div>Product Id: " . $form->get("productId") . "</div>";
		$body .= "<div>User name: " . $form->get("firstName") . "</div>";
		$body .= "<div>User email: " . $form->get("email") . "</div>";
		$body .= "<div>User tel: " . $form->get("tel") . "</div>";
		$body .= "<div>Comments: " . $form->get("comments") . "</div>";

		$emailHelper = AppContext::getEmailManager();
		return $emailHelper->send($to, $subject, $body);
	}

	protected function createAuthLink($user)
	{
		$config = AppContext::getConfig();
		$siteBase = $config->getBaseSiteUrl();
		$link = $siteBase . "auth/" . $user->getAuthLink();
		return $link;
	}
}