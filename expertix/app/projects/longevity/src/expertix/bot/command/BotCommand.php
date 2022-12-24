<?php
namespace Expertix\Bot\Command;

use Expertix\Core\Util\ArrayWrapper;

class BotCommand extends ArrayWrapper
{
	public function isEquals($key)
	{
		return $this->getKey() === $key;
	}

	public function getMethod()
	{
		return $this->required("method");
	}
	public function getKey()
	{
		return $this->required("key");
	}
	public function setKey($key)
	{
		$this->set("key", $key);
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