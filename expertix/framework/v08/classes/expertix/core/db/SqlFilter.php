<?php

namespace Expertix\Core\Db;

use Expertix\Core\Util\Log;

class SqlFilter{
	
	private $sqlWhere = "1=1";
	private $params = [];
	
	function __construct($fields = null)
	{
//		Log::d("!!!", $fields);
		if($fields){
			$this->process(is_object($fields)?$fields->getArray(): $fields);
		}
	}

	function process($fields, $union = "and", $conditions = null)
	{
		$strWhere = "1=?";
		$arrValues = $union == "and" ? [1] : [0];
		foreach ($fields as $key => $value) {
//			Log::d("!!!", $key . ": ". is_null($value) .is_int($value) . is_numeric($value) .($value===""));
			if (!is_int($value) && ($value === null || $value === "" || (is_array($value) && count($value) == 0))) {
				//
			} else {

				$dbField = $key;
				$condition = empty($conditions[$key]) ? "=" : $conditions[$key];
				$val = "";
				if (is_array($value)) {
					$dbField = empty($value["f"]) ? $dbField : $value["f"];
					$condition = empty($value["cond"]) ? $condition : $value["cond"];
					$val = empty($value["val"]) ? $val : $value["val"];
				} else {
					$val = $value;
				}

				$val = is_int($value) ? (int)$val : $val;

				if ($val === 0 || !empty($val)) {
					$strWhere .= " $union `" . $dbField . "` $condition ?";
					//$strParams.= ", ?";
					$arrValues[] = $val;
				}
			}
		}
//		return ["sql" => $strWhere, "params" => $arrValues, "values" => $arrValues];
		$this->sqlWhere = $strWhere;
		$this->params = $arrValues;
	}
	
	function getSqlWherePart()
	{
		return $this->sqlWhere;
	}
	function getParams()
	{
		return $this->params;
	}
}