<?php
namespace Expertix\Core\User;

use Expertix\Core\User\Exception\WrongUserException;
use Expertix\Core\Util\Log;
use Expertix\Core\Util\Utils;

class AuthPolicy{
	public function checkAccess($user, $params){
		$paramLevel = $params->get("auth_level"); //Utils::getArrValue($params, "auth_level", null);
		$level = $user->get("level");
		$userRole = $user->get("role");
		
		if (!empty($paramLevel)) {
			if ($level != $paramLevel) {
				throw new WrongUserException("У вас нет нужного уровня доступа к запрошенному ресурсу", 1);
			}
		}
//		Log::d($user, $params, 0);
		$paramMinLevel = $params->get("auth_min_level", null);
//		Log::d("checkAccess level: $level, min_level: $paramMinLevel", "", 1);
		if (!empty($paramMinLevel)) {
			if ($level < $paramMinLevel) {
				throw new WrongUserException("У вас нет нужного уровня доступа к запрошенному ресурсу", 1, "Уровень доступа $level при минимальном $paramMinLevel");
			}
		}

		if (!empty($params->get("auth_roles"))) {
			$roles = $params->get("auth_roles");
			$checked = false;
			if (is_array($roles)) {
				foreach ($roles as $key => $value) {
					if ($userRole == $value) {
						$checked = true;
						break;
					}
				}
			} else {
				$checked = ($roles == $userRole);
			}

			if (!$checked) {
				throw new WrongUserException("У пользователя с этой ролью нет нужного уровня доступа к запрошенному ресурсу", 1);
			}
		}


		if (!empty($params->get("auth_require_fields"))) {
			$requireFields = $params->get("auth_require_fields");
			if (is_string($requireFields)) {
				$this->checkField($user, $requireFields, "");
			} else {
				foreach ($requireFields as $key => $field) {
					$value = is_array($field) ? $field[0] : null;
					$this->checkfield($user, $field, $value);
				}
			}
		}

		return $user;	
	}
	private function checkField($user, $field, $value = null)
	{
		if (empty($user->get($field)) || ($value && $user->get($field) != $value)) {
			throw new WrongUserException("Для пользователя не установлено обязательное поле $field", 1);
		}
		return true;
	}
}