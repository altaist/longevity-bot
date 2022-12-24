<?php
namespace Expertix\Core\User;

use Expertix\Core\Auth\AuthHelper;
use Expertix\Core\Auth\AuthModel;

use Expertix\Core\Exception\AppException;
use Expertix\Core\User\Exception\WrongUserException;
use Expertix\Core\User\Exception\DuplicateUserException;
use Expertix\Core\Util\Log;
use Expertix\Core\Util\Utils;

class UserHelper 
{
	protected function getUserModel():UserModel
	{
		return new UserModel();
	}
	protected function getAuthModel()
	{
		return new AuthModel();
	}
	protected function getUserIdByKey($key)
	{
		Log::d("getUserIdByKey", $key);
		$model = $this->getUserModel();
		return $model->getUserIdByKey($key);
	}

	protected function getUserKeyFromRequest($request)
	{
		Log::d("getUserKeyFromRequest", $request);
		$userKey = $request->get("key", "");
		if (!$userKey) {
			throw new WrongUserException("Не задан идентификатор пользователя", 1);
		}
		return $userKey;
	}
	public function checkDuplicates($request)
	{
		$authModel = $this->getAuthModel();
		$userModel = $this->getUserModel();

		$userKey = $request->get("key", null);
		$login = $request->get("login", null);
		$email = $request->get("email", null);
		$tel = $request->get("tel", null);
		$socials = $request->get("socials", null);

		// throws exception
		$authModel->checkUniqueLogin($login);
		
/*		
		if ($isExists) {
			throw new WrongUserException("В базе уже есть пользователь с таким именем пользователя и email", 2);
		}
		$isExists = $userModel->checkDublicates($userKey, $email, $tel, $socials);
		if ($isExists) {
			throw new WrongUserException("В базе уже есть пользователь с такими контактными данными", 2);
		}
		return true;
*/
	}

	
	public function signUpByLogin($request){
		$userModel = $this->getUserModel();
		$authModel = $this->getAuthModel();
		$login = $request->get("login");
	
		// Если пользователь найден, генерируем код подтверждения
		if(!$authModel->checkUniqueLogin($login)){
			return $authModel->createAuthConfirmCode($login);			
			//throw new DuplicateUserException("В базе уже есть пользователь с таким логином", 1, null);
		}

		return $userModel -> createUserWithAuth($request, AuthHelper::AUTH_BY_LOGIN);
		
	}
	public function signUpByOAuth($request)
	{
		$userModel = $this->getUserModel();
		$authModel = $this->getAuthModel();

		return $userModel->createUserWithAuth($request, AuthHelper::AUTH_BY_OAUTH);
	}
	public function signUpByRandom($request)
	{
		$userModel = $this->getUserModel();
		$authModel = $this->getAuthModel();

		return $userModel->createUserWithAuth($request, AuthHelper::AUTH_BY_RANDOM);
	}
/*	
	public function createUser($request)
	{
		$userModel = $this->getUserModel();
		$this->checkDuplicates(null, $request);
		
		$user = $userModel -> createUser($request);
		return $user;
	}

*/

}
