<?php

namespace Expertix\Core\User;
use Expertix\Core\Util\ArrayWrapper;

class User extends ArrayWrapper{
	public function getId(){
		return $this->get("userId");
	}
	public function getKey()
	{
		return $this->get("userKey");
	}
	public function getCompanyId(){
		return $this->get("companyId");
	}
	public function getAgencyId()
	{
		return $this->get("agencyId");
	}
	public function getLevel()
	{
		return $this->get("level");
	}
	
}