<?php
namespace Expertix\Module\Services\Meeting;

use Expertix\Core\Data\DataObject;

class Meeting extends DataObject{
	public function getId(){
		return $this->get("meetingId");
	}
	
	public function getKey()
	{
		return $this->get("meetingKey");
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