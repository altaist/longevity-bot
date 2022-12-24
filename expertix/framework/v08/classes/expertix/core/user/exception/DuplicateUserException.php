<?php

namespace Expertix\Core\User\Exception;

class DuplicateUserException extends AuthException
{
	private $userKey = null;
	
	function __construct($message, $code, $key)
	{
		$this->setUserKey($key);
		parent::__construct($message, $code, $key);
	}
	
	function getUserKey(){
		return $this->userKey;
	}
	function setUserKey($userKey){
		$this->userKey = $userKey;
	}
}
