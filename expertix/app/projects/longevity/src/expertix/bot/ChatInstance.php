<?php
namespace Expertix\Bot;
use Expertix\Core\Util\ArrayWrapper;

class ChatInstance extends ArrayWrapper{
	
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
	public function getLang($default){
		return $this->get("lang", $default);
	}
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
	public function getUserName() {
		return $this->get("userName");
	}

	// Chat config
	public function getDialogContext(){
		return $this->getSavedChatConfig();
	}
	
	public function getDialogContextForGroup($groupKey, $experiment = 0){
		$configArr = $this->getSavedChatConfig();
		if(!$configArr){
			$configArr = [[$groupKey => ["index" => 0]]];//$this->createChatContentConfig($experiment);
		}
		
		if(!isset($configArr[$experiment][$groupKey])){
			$configArr[$experiment][$groupKey] = ["index" => 0];
		}
		
		return $configArr;
	}

	protected function getSavedChatConfig():?array{
		$configStr = $this->get("contentConfig");
		//Log::d("!!!", $configStr);
		if(!$configStr){
			return null;
		}
		$configArr = null;
		$configArr = json_decode($configStr, true);
		if(!is_array($configArr)){
			return null;
		}

		//return new ArrayWrapper($configArr);
		return $configArr;
	}
}