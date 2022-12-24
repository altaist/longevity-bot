<?php
namespace Expertix\Bot;
use Expertix\Core\Util\ArrayWrapper;

class ChatInstance extends ArrayWrapper{

	
	public function getLinkKey()
	{
		return $this->get("affKey");
	}
	public function getAuthKey()
	{
		return $this->get("affKey");
	}

	/**
	 * @return mixed
	 */
	public function getChatId() {
		//return $this->getTmChatId();
		return $this->get("chatId");
	}
	public function getTmChatId() {
		$str = $this->get("chatId");
		$pos = strpos($str, "_");
		return substr($str, 0, $pos??strlen($str));
	}

	/**
	 * @return mixed
	 */
	public function getUserName() {
		return $this->get("userName");
	}
}