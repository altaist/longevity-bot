<?php

namespace Expertix\Core\Controller\Api;


use Expertix\Core\Auth\AuthHelper;

use Expertix\Core\Controller\Base\BaseApiController;

use Expertix\Core\Db\DB;
use Expertix\Core\Exception\ApiException;
use Expertix\Core\User\Exception\WrongUserException;
use Expertix\Core\User\Exception\DuplicateUserException;

use Expertix\Core\User\User;
use Expertix\Core\User\UserHelper;
use Expertix\Core\User\UserManager;
use Expertix\Core\User\UserManagerAdmin;

use Expertix\Core\Util\Log;

class ApiAuthByLoginController extends BaseApiController
{

	protected function onCreate()
	{
		$this->addRoute("signup", "signUp");
		$this->addRoute("signup_password", "signUpByPassword");
		$this->addRoute("signin_password", "signInByLoginAndPassword");

		
		$this->addRoute("signin_confirm_code", "signInByLoginAndConfirmCode");
		$this->addRoute("signup_confirm_code", "signInUpByConfirmCode");

		$this->addRoute("signout", "signOut");
	}

	public function getUserManager()
	{
		$userManager = new UserManager($this->getAuthConfig());
		return $userManager;
	}
	public function getUserManagerAdmin()
	{
		$userManager = new UserManagerAdmin($this->getAuthConfig());
		return $userManager;
	}
	
	/**
	 * 
	 */
	
	 public function signUp($request){
		$userManager = $this->getUserManagerAdmin();
		$user = $userManager->createUserAndAuth($request);
		return $user;
	 }
	 

	

	/**
	 * By password
	 */

	public function signInByLoginAndPassword($request)
	{
		$request->getRequired("login", "Необходимо указать логин");
		$authManager = $this->getAuthManager();

		$user = $authManager->authByLoginAndPassword($request);
		Log::d("Auth by login and password. Result user:", $user ? $user->getArray() : null, 0);
		if (empty($user) || !$user->getArray()) {
			throw new WrongUserException("Ошибка входа в систему", 1);
		}
		return $user;
	}


	// Signup
	function signUpByPassword($request)
	{
		$userHelper = new UserHelper();
		$userArray = $userHelper->signUpByLogin($request);

		if (empty($userArray)) {
			throw new WrongUserException("Ошибка регистрации в системе", 1);
		}
		$user = new User($userArray);
		if (!$user) return null;
		return $user->getArray();
	}

	public function updateUserRole($request)
	{
		$level = $request->get("level", 0);
		$role = $request->get("role", 0);

		// Create priveleged users
		if ($level > 0) {
			$user = $this->getUser();
			if (empty($user["level"]) || $user["level"] < 1) {
				throw new ApiException("Wrong user level for setting level for new user", 0);
			}
		}
	}

	/**
	 * By confirm code
	 */

	function signInUpByConfirmCode($request)
	{
		$userHelper = new UserHelper();
		$userArray = null;
		$confirmCode = $request->get("confirmCode");

		try {
			if ($confirmCode) {
				// Есть код подтверждения - пытаемся войти в систему 
				Log::d("signInUp confirmCode=$confirmCode");
				return $this->signInByLoginAndConfirmCode($request);
			} else {
				$userArray = $userHelper->signUpByLogin($request, 0, 0);
				Log::d("signInUp", $userArray);
			}
		} catch (DuplicateUserException $e) {
			Log::d("signInUp DuplicateException");
			if ($e->getUserKey()) {
			}
		}

		return $userArray;
	}

	public function signInByLoginAndConfirmCode($request)
	{
		$login = $request->getRequired("login", "Необходимо указать логин");
		$confirmCode = $request->get("confirmCode");
		if ($confirmCode) {
			$authManager = $this->getAuthManager();
			$user = $authManager->authByLoginAndConfirmCode($request);
			return $user;
		} else {
			$authHelper = new AuthHelper();
			return $authHelper->createAuthConfirmCode($login);
		}
	}

	public function signOut($request)
	{
		$authManager = $this->getAuthManager();
		return $authManager->signoutAndRedirect($this, null);
	}


	public function exp_subscribe($request)
	{
		$user = $this->signUp($request);
		if (!$user) {
			throw new \Exception("Ошибка при регистрации пользователя", 1);
		}

		$this->subscribeProduct($user, $request);

		return $user->getArray();
	}
	public function subscribeProduct($user, $request)
	{
		if (!$user) return null;
		$userId = $user->getId();

		$firstName = $request->get("firstName");
		$lastName = $request->get("lastName");
		$productId = $request->get("productId", null);
		$serviceId = $request->get("serviceId", null);
		$productType = $request->get("productType");
		$serviceKey = $request->get("serviceKey"); // App::SERICES[$serviceKey]
		$autosubscribe = $request->get("autosubscribe", false);
		$productTitle = $request->get("productTitle");
		$comments = $request->get("comments");

		$objectId = $request->get("objectId", $productId);
		// $serviceId = App::SERVICES[$serviceKey]
		//$serviceId = DB::getValue("select serviceId from service where serviceKey=?", $serviceKey, -1);
		$state = $request->get("state", 0);
		$accessLevel = $request->get("accessLevel", 0);
		$role = $request->get("role", 0);
		$resultLevel = $request->get("resultLevel", 0);


		$sql = "insert into srv_subscription (userId, productId, serviceId, state, role, accessLevel, resultLevel) values(?, ? , ?, ?, ?, ?, ?)";
		$params = [$userId, $productId,  $serviceId, $state, $role, $accessLevel, $resultLevel];
		DB::add($sql, $params, "Adding subscription");

		// Form request
		//$sql = "insert into form_request (userId, productId, firstName, lastName, comments) values(?, ? ,?, ?, ?)";
		//$params = [$userId, $productId, $firstName, $lastName, $comments];
		//DB::add($sql, $params);


		// Simple order
		$price1 = $request->get("price1");
		$quantity1 = $request->get("quantity1");
		$paxAdults = $request->get("paxAdults");
		$paxChilds = $request->get("paxChilds");
		$paxInfants = $request->get("paxInfants");

		$sql = "insert into store_simpleorder (userId, productId, price1, quantity, paxAdults, paxChilds, paxInfants) values(?, ? ,?, ?, ?, ?, ?)";
		$params = [$userId, $price1, $quantity1, $paxAdults, $paxChilds, $paxInfants];
		//DB::add($sql, $params);

		// Subscribe
		if ($autosubscribe) {
		}
	}
}
