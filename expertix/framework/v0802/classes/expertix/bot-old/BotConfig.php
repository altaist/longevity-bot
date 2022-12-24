<?php

namespace Expertix\Bot;

use Exception;
use Expertix\Core\Util\ArrayWrapper;

class BotConfig extends ArrayWrapper
{
	private $lang = "en";
	private $res = null;
	private $resText = null;
	
	function __construct($array, $lang="en")
	{
		parent::__construct($array);
		$this->res = $this->getWrapped("res");
		$this->setLang($lang);
//		$this->resText = $this->getWrapped("res")->getWrapped("text")->getWrapped($this->getLang());
	}
		
	public function getApiUrl($default="")
	{
		return $this->get("api_url");
	}
	public function getBotId($default="")
	{
		return $this->required("bot_id", "Wrong bot id");
	}
	public function getToken(){
		return $this->required("token");
	}
	public function getRoute(){
		return $this->required("route");
	}
	public function getLang(){
		return $this->lang;
	}
	public function setLang($lang){
		$this->lang = $lang;
		$this->resText = $this->res->getWrapped("text")->getWrapped($this->getLang());				
	}
	public function getResource(){
		return $this->res;
	}
	public function setResource($res){
		$this->res = $res;
	}
	public function getImgResources()
	{
		return $this->getResource()->get("img", []);
	}
	public function getTextResources()
	{
		return $this->resText;
	}
	public function getText($key, $default="")
	{
		return $this->getTextResources()->get($key, $default);
	}
		

	public function getTextAbout(){
		return $this->getText("about");
	}
	public function getTextHelp(){
		return $this->getText("help");
	}
	public function getTextWrongCommand()
	{
		return $this->getText("wrong_command", "Wrong command");
	}
	public function getTextAppError(){
		return $this->getText("error", "Internal bot error");
	}

	
	
}
