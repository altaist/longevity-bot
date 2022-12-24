<?php

namespace Expertix\Core\Db;

use Expertix\Core\Util\Log;

class SqlCreator{
	private $sqlInsert = "";
	private $sqlFields = "";
	private $sqlParams = "";
	private $params = [];

	function __construct($request, $fields, $keyField, $keyValue)
	{
		$strFields = "$keyField";
		$strParams = "?";
		$params = [$keyValue];
		foreach ($fields as $key => $fieldName) {
			$strFields .= ", $fieldName";
			$strParams .= ",?";
			$params[] = $request->get($fieldName);
		}

		$this->sqlInsert = "({$strFields}) values ({$strParams})";
		$this->sqlFieldsPart = $strFields;
		$this->sqlParamsPart = $strParams;

		$this->params = $params;
	}

	function getSqlInsert()
	{
		return $this->sqlInsert;
	}
	function getSqlFieldsPart()
	{
		return $this->sqlFields;
	}
	function getSqlParamsPart()
	{
		return $this->sqlParams;
	}
	function getParams()
	{
		return $this->params;
	}
}