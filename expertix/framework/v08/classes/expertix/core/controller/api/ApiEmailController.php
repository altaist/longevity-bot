<?php
namespace Expertix\Core\Controller\Api;

use Expertix\Core\App\AppContext;
use Expertix\Core\Auth\AuthManager;
use Expertix\Core\Controller\Base\BaseApiController;
use Expertix\Core\Controller\Base\BaseController;
use Expertix\Core\User\Exception\WrongUserException;
use Expertix\Core\User\User;
use Expertix\Core\User\UserModel;

class ApiEmailController extends BaseApiController
{
	private $emailHelper = null;

	protected function onCreate()
	{
		$this->addRoute("send_login_notify", "sendLoginNotify");
		$this->addRoute("send_login_completed", "sendLoginCompleted");
		$this->addRoute("send_confirm_code", "send_confirm_code");
		$this->addRoute("send_order", "send_order");

		$this->addRoute("email_signup", "emailOnSignup");
		
		
		$this->emailHelper = AppContext::getEmailManager();
		
	}
	
	public function findEmailById($request){
		$userModel = new UserModel();
		$userId = $request->required("userId");
		$user = $userModel->getUserById($userId);

		if (!$user) {
			throw new WrongUserException("Не найден пользователь с таким id", UserModel::ERR_NOT_FOUND, "Не найден пользователь $userId при отправке почты");
		}
		$email = $user->get("email");
		if (!$email) {
			throw new WrongUserException("Не найден email дл пользователя с таким id", UserModel::ERR_NOT_FOUND, "Не найден email для пользователя $userId при отправке почты");
		}
		
		return $email;
	}
	
	public function findUserByEmail($request)
	{
		$userModel = new UserModel();
		$email = $request->required("email");
		$user = $userModel->getUserByEmail($email);

		if (!$user) {
			throw new WrongUserException("Не найден пользователь с таким email", UserModel::ERR_NOT_FOUND, "Не найден пользователь для $email при отправке почты");
		}
		$email = $user["email"];
		if (!$email) {
			throw new WrongUserException("Не найден email дл пользователя с таким id", UserModel::ERR_NOT_FOUND, "Не найден email для пользователя $userId при отправке почты");
		}

		return new User($user);
	}


	public function sendLoginNotify($request)
	{
		$user = $this->findUserByEmail($request);
		$config = AppContext::getConfig();
		$siteBase = $config->getBaseSiteUrl();
		$link = $siteBase . "auth/" . $user->get("authLink");

		$emailConfig = $config->getAppParam("email");

		$to = $user->get("email");
		//$subject = "данные для входа в систему";
		$subject = $emailConfig["login_notify"]["subject"];


		//$body = "<p>Для входа в систему перейдите по <a href='$link'>этой ссылке</a></p>";
		$body = $emailConfig["login_notify"]["body"];
		if (!$subject || !$body) {
			return "No subject or body";
		}
		$body = str_replace("#LINK#", $link, $body);

		return $this->emailHelper->send($to, $subject, $body);
	}

	public function emailOnSignup($request)
	{

		$user = $this->getuser();
		if (!$user) {
			return "Wrong email";
		}
		$lang = $request->get("lang", "");
		if($lang) $lang="_".$lang;

		$config = AppContext::getConfig();
		$siteBase = $config->getBaseSiteUrl();
		$link = $siteBase . "auth/" . $user->get("authLink");

		$emailConfig = $config->getAppParam("email");

		$to = $user->get("email");
		$subject = $emailConfig["signup".$lang]["subject"];


		//$body = "<p>Для входа в систему перейдите по <a href='$link'>этой ссылке</a></p>";
		$body = $emailConfig["signup"]["body"];

		if (!$subject || !$body) {
			return "No subject or body";
		}
		
		$body = str_replace("#LINK#", $link, $body);

		$emailHelper = AppContext::getEmailManager();
		return $emailHelper->send($to, $subject, $body);
	}
	
	
}