<?php

namespace Expertix\Core\Db;

use Expertix\Core\Util\Log;

class SqlEditor{
	
	private $sqlUpdate = "";
	private $sqlFields = "";
	private $sqlParams = "";
	private $params = [];
	
	function __construct($request, $fields)
	{
		$strFields = "";
		$params = [];
		foreach ($fields as $key => $fieldName) {
			$strFields .= "$fieldName=?,";
			$params[] = $request->get($fieldName);
		}
		Log::d("!!!",$strFields);

		$strFields = substr($strFields, 0, strlen($strFields)-1);
		
		$this->sqlUpdate = "{$strFields}";
		
		$this->params = $params;
		
	}
	
	function getSqlUpdate()
	{
		return $this->sqlUpdate;
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