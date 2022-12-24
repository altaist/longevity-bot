<?php
namespace Expertix\Bot\Command;

use Expertix\Core\Util\ArrayWrapper;

class BotCommand extends ArrayWrapper
{
	public function isEquals($key){
		return $this->getMethod()===$key;
	}	

	public function getMethod()
	{
		return $this->required("method");
	}
	public function getRequestText()
	{
		return $this->get("request_text");
	}
	public function setRequestText($text)
	{
		$this->set("request_text", $text);
	}
	public function getRequestTextOrigin()
	{
		return $this->get("request_text_origin");
	}
	public function setRequestTextOrigin($text)
	{
		$this->set("request_text_origin", $text);
	}
	public function getMethodDescription()
	{
		return $this->get("description");
	}
	public function getStateFrom()
	{
		return $this->get("state_from");
	}
	public function getStateTo()
	{
		return $this->get("state_to");
	}
	
}
