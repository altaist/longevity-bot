<?php
namespace Expertix\Core\Data;

use Expertix\Core\App\AppContext;
use Expertix\Core\Util\ArrayWrapper;

class PageData extends ArrayWrapper{

	private $objectId;
	private $dataObject;
	private $dataCollection;
	private $storage;
	private $model;
	private $output = "";
	

	private $user;

	function getUser()
	{
		return $this->user;
	}
	function setUser($user)
	{
		$this->user = $user;
	}
	function getObjectId()
	{
		return $this->objectId;
	}
	function setObjectId($objectId)
	{
		$this->objectId = $objectId;
	}
	function getModel()
	{
		return $this->model;
	}
	function setModel($model)
	{
		$this->model = $model;
	}
	function getOutput()
	{
		return $this->output;
	}
	function setOutput($output)
	{
		$this->output = $output;
	}
	

	
	
	
	function getBaseSiteUrl()
	{
		return $this->getAppContext::getConfig()->getBaseSiteUrl();
	}
	function getBaseUrl()
	{
		return $this->getBaseSiteUrl();
	}
	
	function getAppId(){
		return AppContext::getConfig()->getAppId();
	}

	function getDataObject()
	{
		return $this->dataObject;
	}
	function setDataObject($data)
	{
		$this->dataObject = $data;
	}
	
	function getDataCollection()
	{
		return $this->dataCollection;
	}
	
	function setDataCollection($data)
	{
		$this->dataCollection = $data;
	}
	
	function getAffKey(){
		return $this->get("affKey");
	}
	function setAffKey($affKey){
		return $this->set("affKey", $affKey);
	}
	
	function getStorage()
	{
		return $this->storage;
	}
	
}