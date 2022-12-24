<?php
namespace Expertix\Module\Services\Service;

use Expertix\Core\Data\DataObject;

class Service extends DataObject{
	public function getId(){
		return $this->get("serviceId");
	}
	
	public function getKey()
	{
		return $this->get("serviceKey");
	}

	public function getTitle()
	{
		return $this->get("title");
	}
	public function getSubTitle()
	{
		return $this->get("subTitle");
	}
	public function getImg()
	{
		return $this->get("img");
	}
	public function getVideo()
	{
		return $this->get("video");
	}
	
} 