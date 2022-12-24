<?php
namespace Expertix\Core\Util;

use Expertix\Core\Util\ArrayWrapper as UtilArrayWrapper;

class ArrayWrapper{
	private $dataArr = [];

	function __construct($arr=[])
	{
		$this->createFromArr($arr);
	}

	public function createFromArr($arr)
	{
		if (!is_array($arr)) {
			$this->setArray([]);
			return;
		}
		$this->setArray($arr);
		return $this->getArray();
	}
	public function getArray()
	{
		return $this->dataArr;
	}
	function setArray($arr)
	{
		$this->dataArr = $arr;
	}

	function check($paramName)
	{
		return !empty($this->get($paramName));
	}
	function checkRecursive($paramName)
	{
		return !empty($this->getRecursive($paramName));
	}
	function get($paramName, $defaultValue=""){
		$dataArr = $this->getArray();
		//MyLog::d("ArrayWrapper get() key: $paramName");
		//if (!isset($dataArr)) return $defaultValue;
		return $this->search($dataArr, $paramName, $defaultValue);
	}
	
	function getRequired($paramName, $message = null){
		if(!isset($this->getArray()[$paramName])){
			throw new \Exception($message ? $message : "Не указан необходимый параметр $paramName", 1);
		}
		$result = $this->get($paramName, null);
		if($result == null){
		}
		return $result;
	}
	function required($paramName, $message=null){
		return $this->getRequired($paramName, $message);
	}
	
	function getWrapper($paramName, $defaultValue = ""){
		$arr = $this->get($paramName, $defaultValue);
		return new ArrayWrapper($arr);
	}
	function getSub($paramName, $defaultValue = ""){
		return $this->getWrapper($paramName, $defaultValue);
	}
	
	function getRecursive($key, $defaultValue="")
	{
		return $this->searchRecursive($this->getArray(), $key, $defaultValue);
	}
	function set($paramName, $value)
	{
		//$oldValue = $dataArr[$paramName];
		$this->dataArr[$paramName] = $value;
		//MyLog::d("ArrayWrapper set() key: $paramName", $this->dataArr);
		//return $oldValue;
	}
	function setIfEmpty($paramName, $value){
		$founded = $this->get($paramName, "");
		if(!empty($founded)) return;
		$this->set($paramName, $value);
	}
	
	function removeField($fieldName){
		unset($this->getArray()[$fieldName]);
	}
	
	function merge($newArray){
		$this->setArray(Utils::mergeArrays($this->getArray(), $newArray), false);
	}
	function mergeRecursive($newArray)
	{
		$this->setArray(Utils::mergeArrays($this->getArray(), $newArray), true);
	}
	protected function search($array, $paramName, $defaultValue){
		return isset($array[$paramName]) ? $array[$paramName] : $defaultValue;
	}

	protected function searchRecursive($array, $paramName, $defaultValue){
		$resultValue = $this->search($array,$paramName, $defaultValue);
		if (!empty($resultValue)) {
			return $resultValue;
		}
		MyLog::d("ArrayWrapper searchRecursive() key: $paramName, resultValue:", $resultValue);
		foreach ($array as $key => $val) {
			if(is_array($val) && sizeof($val)>0){
				//MyLog::d("ArrayWrapper before searchRecursive() recurtion");
				$foundedValue = $this->searchRecursive($val, $paramName, $defaultValue);
				if(!empty($foundedValue)){
					MyLog::d("Founded in array!", $val);
					return $foundedValue;	
				} 
			}
		}
		return $defaultValue;
	}
	
	
}