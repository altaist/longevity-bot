<?php
namespace Expertix\Module\Services\Activity;

use Expertix\Core\Data\DataObject;

class Activity extends DataObject{
	public function getId(){
		return $this->get("activityId");
	}
	
	public function getKey()
	{
		return $this->get("activityKey");
	}

} 