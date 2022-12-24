<?php
namespace Expertix\Core\User;

use Expertix\Core\Util\UUID;

class AuthHelper{
	//Password flags
	const PW_NONE			= 0;	//Password is default unencoded
	const PW_MD5 			= 1;	//Password has been ecoded to MD5 already
	const PW_SALT 			= 2;	//Password has been salted already
	static function createKey($prefix, $length = 8)
	{
		return UUID::gen_uuid($prefix, $length);
	}
	static function createKey2($prefix = "")
	{
		return uniqid(substr(md5($prefix), 0, 4));
	}
	static function createAuthLink($login, $authId)
	{
		//		return "l" . substr(md5($login), 2, 6) ;
		return "l" . self::createKey($login);
	}
	static function createAutoPassword($prefix, $value = null)
	{
		if ($value) return $value;
		return self::createKey2($prefix);
	}
	static function createAutoLogin($prefix, $value = null)
	{
		if ($value) return $value;
		return self::createKey2($prefix);
	}
	static function encrypt($text, $saltArr = [])
	{
		$timeNow = time();
		srand($timeNow);
		$salt = "" . rand();
		foreach ($saltArr as $item) {
			$salt .= $item;
		}

		$random_hash = md5($timeNow . $salt);

		$salt = substr(md5($random_hash), 0, 6);
		$result = md5(md5($text) . $salt);
		return [$result, $salt];
	}
	
	static public function comparePassword($password, $userinfo, $password_flags = self::PW_NONE)
	{
		$sqlpwd = $userinfo["password"];
		if ($password_flags == self::PW_NONE)
			$password = md5(md5($password) . $userinfo["salt"]);
		elseif ($password_flags == self::PW_MD5) //password was supplied in md5, but it's unsalted. salt it now
			$password = md5($password . $userinfo["salt"]);

		if (strcmp($password, $sqlpwd) != 0) {
			return FALSE;
		}
		return TRUE;
	}

}