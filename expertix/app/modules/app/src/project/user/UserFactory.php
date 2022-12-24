<?php
namespace Project\User;

use Expertix\Core\Util\Log;

class UserFactory extends \Expertix\Core\User\BaseUserFactory{
	function createUser($authData)
	{
		$user = parent::createUser($authData);
		return $user;
		$model = new \Expertix\Module\Services\Service\ServiceModel();
		$services = $model->getServicesForUser($user);
		
		$user->set("services", $services);
//		Log::d("UserFactory123", $user, 1);
		return $user;
	}

}