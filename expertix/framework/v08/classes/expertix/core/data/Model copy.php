<?php
namespace Expertix\Core\Data;
use Expertix\Core\Util\Utils;

class Model
{
	public const MODE_CREATE = 0;
	public const MODE_UPDATE = 1;
	
	public $table = "";
	public $fields = [];

	private $objectId = null;
	private $objectType = null;

	//abstract function createDb();

	function getObjectId()
	{
		return $this->objectId;
	}

	function getObjectType()
	{
		return $this->objectType;
	}
	function getTable()
	{
		return $this->table;
	}
	function getFields()
	{
		return $this->fields;
	}

	function getParam($paramsArr, $key, $defaultValue = null)
	{
		return Utils::getParam($paramsArr, $key, $defaultValue);
	}
	function getParamStrong($paramsArr, $key)
	{
		return Utils::getParamStrong($paramsArr, $key);
	}

	function deleteObject($type, $id)
	{
		$sql = "delete from $type where $type" . "Id=?";
		$params = [$id];
		//$result = DB::set($sql, $params);
		//return $result;
	}
}