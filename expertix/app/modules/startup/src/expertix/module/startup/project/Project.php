<?php
namespace Expertix\Module\Startup\Project;

use Expertix\Core\Data\DataObject;

class Project extends DataObject{
	public function getId(){
		return $this->get("projectId");
	}
	
	public function getKey()
	{
		return $this->get("projectKey");
	}

} 