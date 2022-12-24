<?php

namespace Expertix\Core\User;

use Expertix\Core\App\SessionHelper;
use Expertix\Core\Exception\RedirectException;
use Expertix\Core\User\Exception\WrongUserException;
use Expertix\Core\Util\Log;

class UserManager
{

	private $userFactory = null;
	private $userPolicy = null;
	private $authConfig = null;

	public function __construct($authConfig)
	{
		$this->authConfig = $authConfig;
		$this->setUserPolicy(new AuthPolicy());
		$this->setUserFactory(new BaseUserFactory());
	}

	public function setUserPolicy($userPolicy)
	{
		$this->userPolicy = $userPolicy;
		return $this;
	}
	public function setUserFactory($userFactory)
	{
		$this->userFactory = $userFactory;
		return $this;
	}

	public function setAuthConfig($authConfig)
	{
		$this->authConfig = $authConfig;
		return $this;
	}

	public function setAutoRedirect($flag)
	{
		$this->autoRedirect = $flag;
		return $this;
	}

	public function getUserModelAuth()
	{
		return new UserModelAuth();
	}


	// Auth
	/**
	 *  Check auth by Link and auto redirect
	 */
	public function authBySession()
	{
		if (!$this->checkNeedAuthBySession()) {
			return null;
		}
		$userAuth = $this->getUserModelAuth();
		$userKey = $this->getKeyFromSession();
		if (!$userKey) {
			throw new WrongUserException("Ошибка получения пользователя по сессии", 0, "Пустой userKey в сессии");
		}

		return $this->auth($userAuth->authByKey($userKey));
	}
	/**
	 *  Check auth by Link and auto redirect
	 */
	public function authByLink($authLink)
	{
		$userAuth = $this->getUserModelAuth();
		return $this->auth($userAuth->authByLink($authLink));
	}

	/**
	 *  Check auth by userKsy. Protected
	 */
	protected function authByKey($authLink)
	{
		$userAuth = $this->getUserModelAuth();
		return $this->auth($userAuth->authByKey($authLink));
	}

	/**
	 *  Check auth by password and throws exceptions. Without autoredirecting!
	 */
	public function authByPassword($login, $password)
	{
		$userAuth = $this->getUserModelAuth();
		return $this->auth($userAuth->authByPassword($login, $password));
	}

	protected function auth($user)
	{
		if (!$user) {
			throw new WrongUserException("Ошибка авторизации", 1, "Пустой user на входе в auth");
		}

		// throw wrong user creator
		$user = $this->userFactory->createUser($user);
		if (!$user) {
			throw new WrongUserException("Ошибка авторизации", 1, "Пустой user после userFactory");
		}

		// throws wrong access
		if ($this->userPolicy) {
			$this->userPolicy->checkAccess($user, $this->authConfig);
		}



		// Set session
		$this->saveKeyInSession($user);

		return $user;
	}

	protected function checkNeedAuth()
	{
		$authConfig = $this->authConfig;

		if (!$authConfig || !is_array($authConfig->getArray())) {
			return false;
		}
		return true;
	}
	protected function checkNeedAuthBySession()
	{
		if (!$this->checkNeedAuth()) return false;
		$authConfig = $this->authConfig;

		if (!$authConfig->get("auth_by_session")) {
			return false;
		}

		return true;
	}

	public function redirectSuccess($user)
	{
		$authConfig = $this->authConfig;
		if (!$authConfig) {
			throw new WrongUserException("Empty auth param in config from success auth redirecting", 0);
		}
		if (!$user) {
			throw new WrongUserException("Empty user in success auth redirecting", 1);
		}

		//Log::d("RedirectController processWeb", $authConfig, 1);

		if ($authConfig->get("auth_redirect_success")) {
			throw new RedirectException($authConfig->get("auth_redirect_success"));
		}

		$roles = $authConfig->get("roles");
		$userRole = $user->get("role");

		if ($roles && $userRole) {
			if (!empty($roles[$userRole])) {
				$url =  $roles[$userRole];
				//Log::d("RedirectController processWeb", $url, 1);
				throw new RedirectException($authConfig->get("auth_redirect_success"));
			}
		}

		throw new WrongUserException("Cannot detect url from success auth redirecting", 1, "Cannot detect url from success auth redirecting");
	}


	public function processError($e)
	{
		//Log::d("UserManager processError", $e->getLogMessage());
		$authConfig = $this->authConfig;
		if ($authConfig && $authConfig->getArray()) {
			//Log::d("AuthArray", $authConfig->getArray(), 0);

			// Автоматический редирект, если не указан параметр блокировки редиректа
			$authNoRedirect = $authConfig->get("auth_redirect_fail")=="no";
			//Log::d("AuthNoRedirect: ", $authConfig->get("auth_redirect_fail_no"));
			if (empty($authNoRedirect)) {
				$authRedirectPath = $authConfig->get("auth_redirect_fail", "access");
				//Log::d("AuthRedirectPath", $authRedirectPath, 0);
				throw new RedirectException($authRedirectPath);
			}
		}
		return null;
	}

	// Auth Off
	public function signOutAndRedirect($user, $_redirtectPath = null)
	{
		// Sign out
		$result = $this->signOut($user); // true if user was existed

		// Redirect

		$redirtectPath = $_redirtectPath ? $_redirtectPath : $this->authConfig->get("auth_redirect_signout", "/");

		if ($redirtectPath) {
			throw new RedirectException($redirtectPath);
		}
		return $result;
	}
	public function signOut($user)
	{
		$key = $user ? $user->getKey() : null;
		if (!$key) {
			return false;
		}

		$this->removeKeyFromSession($key);
		return true;
	}


	//

	private function getKeyFromSession()
	{
		return (new SessionHelper())->getUserKeyFromSession();
	}
	private function saveKeyInSession($user)
	{
		$key = $user->get("userKey");
		return (new SessionHelper())->saveUserKeyInSession($key);
	}
	private function removeKeyFromSession($key)
	{
		return (new SessionHelper())->clearUserKeyFromSession($key);
	}
}
