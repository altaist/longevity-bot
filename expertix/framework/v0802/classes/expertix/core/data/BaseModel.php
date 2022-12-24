<?php

namespace Expertix\Core\Data;

use Expertix\Core\Db\DB;
use Expertix\Core\Db\SqlCreator;
use Expertix\Core\Db\SqlEditor;
use Expertix\Core\Db\SqlFilter;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;
use Expertix\Core\Util\Utils;
use Expertix\Core\Util\UUID;

abstract class BaseModel extends ArrayWrapper
{
	public const MODE_CREATE = 0;
	public const MODE_UPDATE = 1;

	protected $tableName = "";
	protected $dataType = "";
	protected $keyField = "";
	
	protected $user = null;
	
	public function __construct()
	{
		$this->setup();
	}
	
	abstract protected function setup();
	
	function getUser(){
		return $this->user;
	}
	function setUser($user){
		$this->user = $user;
	}	

	public function getObject($key, $user = null)
	{
		return $this->getRowByKey($key);
	}
	public function getObjectById($id, $user = null)
	{
		return $this->getRowById($id);
	}
	public function getCollection($params, $orderBy=null)
	{
		$filter = new SqlFilter($params);
		return $this->getFilteredCollection($filter, $orderBy);
	}
	public function getFilteredCollection($filter, $orderBy=null)
	{
		$tableName = $this->getTableName();
		$type = $this->getDataType();
		$keyField = $this->getKeyField();

		// Parse sql filter
		$filter_sql = "1=1";
		$params = [];
		if ($filter) {
			$filter_sql = $filter->getSqlWherePart();
			$params = $filter->getParams();
		}

		$_orderBy = " data.{$type}Id desc";
		if (is_array($orderBy)) {
			foreach ($orderBy as $key => $field) {
				$_orderBy .= (", " . $field);
			}
		} else if (is_string($orderBy)) {
			$_orderBy = $orderBy . $_orderBy;
		}

		$sql = "select *, data.{$keyField} as `key` from $tableName as data where $filter_sql and isDeleted=0 order by $_orderBy";
		Log::d($sql);
		$rows = DB::getAll($sql, $params);
		return $rows;
	}
	
	public function getFilteredCollectionWithChilds($filter, $orderBy, $childTable, $joinFieldChild, $joinFieldParent, $joinType="inner join"){
		$tableName = $this->getTableName();
		$type = $this->getDataType();
		$keyField = $this->getKeyField();

		// Parse sql filter
		$filter_sql = "1=1";
		$params = [];
		if ($filter) {
			$filter_sql = $filter->getSqlWherePart();
			$params = $filter->getParams();
		}

		$_orderBy = " data.{$type}Id desc";
		if (is_array($orderBy)) {
			foreach ($orderBy as $key => $field) {
				$_orderBy .= (", " . $field);
			}
		} else if (is_string($orderBy)) {
			$_orderBy = $orderBy . $_orderBy;
		}	

		$sql = "select data.*, linked.*, data.{$keyField} as `key` from $tableName as data $joinType $childTable as linked on linked.{$joinFieldChild}=data.{$joinFieldParant}  where $filter_sql and isDeleted=0 order by $_orderBy";
		$rows = DB::getAll($sql, $params);
		return $rows;
	}
	


	// Standart Sql
	function getRowByKey($key){
		$sql = "select d.*, d.{$this->getKeyField()} as `key` from {$this->getTableName()} d where d.{$this->getKeyField()}=?";
		return DB::getRow($sql, [$key]);
	}
	function getRowById($id)
	{
		$sql = "select d.*, d.{$this->getKeyField()} as `key` from {$this->getTableName()} d where d.{$this->getDataType()}Id=?";
		return DB::getRow($sql, [$id]);
	}
	public function getIdByKey($key){
		$tableName = $this->getTableName();
		$type = $this->getDataType();
		$keyField = $this->getKeyField();
		
		return DB::getValue("select {$type}Id from $tableName where $keyField=?", [$key]);
	}
	public function getKeyById($id){
		$tableName = $this->getTableName();
		$type = $this->getDataType();
		$keyField = $this->getKeyField();
		
		return DB::getValue("select $keyField from $tableName where {$type}Id=?", [$id], "", "getKeyById");
	}
	function getRowByField($field, $value)
	{
		$sql = "select d.*, d.{$this->getKeyField()} as `key` from {$this->getTableName()} d where d.{$field}=?";
		return DB::getRow($sql, [$value]);
	}

	// Create Update delete
	public function createEmptyArray()
	{
		return new ArrayWrapper(["empty" => true]);
	}
	
	function create($request, $fields=null){
		$tableName = $this->getTableName();
		$type = $this->getDataType();
		$keyField = $this->getKeyField();
		
		$key = $this->createKey(date(DATE_RSS));
		
		$sql_insert = "";
		$params = [];
		if($fields){
			$creator = new SqlCreator($request, $fields, $keyField, $key);
			$sql_insert = $creator->getSqlInsert();
			$params = $creator->getParams();
		}
		$sql = "insert into $tableName $sql_insert ";
		$id = DB::add($sql, $params);
		return $id;
	}
	function update($request, $fields=null){
		$tableName = $this->getTableName();
		$type = $this->getDataType();
		$keyField = $this->getKeyField();
		
		$key = $request->required($keyField);
		
		$sql_update = "";
		$params = [];
		if($fields){
			$creator = new SqlEditor($request, $fields);
			$sql_update = $creator->getSqlUpdate();
			$params = $creator->getParams();
		}
		
		$params[] = $key;
		
		$sql = "update $tableName set $sql_update where $keyField=?";
		
		return DB::set($sql, $params, __FUNCTION__);
	}
	
	function delete($key)
	{
		$sql = "delete from {$this->getTableName()} where {$this->getKeyField()} = ?";
		Log::d("Delete key:$key");
		return DB::set($sql, [$key]);
	}
	function deleteSoft($key)
	{
		$sql = "update {$this->getTableName()} set isDeleted=1 where {$this->getKeyField()} = ?";
		return DB::set($sql, [$key]);
	}
	function hide($key)
	{
		$sql = "update {$this->getTableName()} set state=0 where {$this->getKeyField()} = ?";
		return DB::set($sql, [$key]);
	}
	function changePos($key, $newPos){
		$sql = "update {$this->getTableName()} set pos=? where {$this->getKeyField()} = ?";
		return DB::set($sql, [$newPos, $key]);		
	}
	
	// Img
	public function updateImgByKey($objectKey, $value)
	{
		return $this->updateFieldByKey("img", $objectKey, $value);
	}
	
	public function updateImgById($objectId, $value)
	{
		return $this->updateFieldById("img", $objectId, $value);
	}

	public function updateFieldById($fieldName, $objectId, $value)
	{
		$tableName = $this->getTableName();
		$type = $this->getDataType();
		
		$sql = "update $tableName set $fieldName=? where {$type}Id=?";
		return DB::set($sql, [$value, $objectId]);
	}
	public function updateFieldByKey($fieldName, $objectKey, $value)
	{
		$tableName = $this->getTableName();
		$keyField = $this->getKeyField();
		
		$sql = "update $tableName set $fieldName=? where $keyField=?";
		return DB::set($sql, [$value, $objectKey]);
	}
	
	// Utils
	
	protected function createKey($title, $_table = null, $_keyField = null)
	{
		$table = $_table ? $_table : $this->getTableName();
		$keyField = $_keyField ? $_keyField : $this->getKeyField();

		$key = UUID::gen_uuid($title);
		$foundedKey = null;
		if ($table) {
			for ($i = 0; $i < 20; $i++) {
				$foundedKey = DB::getValue("select $keyField from $table where $keyField=?", [$key]);
				if (!$foundedKey) {
					break;
				}
			}
			if ($foundedKey) {
				throw new \Exception("Wrong key generating algorithm", 0);
			}
		}

		return $key;
	}
	

	// Getters setters
	protected function getKeyField()
	{
		return $this->keyField;
	}
	protected function getDataType()
	{
		return $this->dataType;
	}
	protected function getTableName()
	{
		return $this->tableName;
	}

	function setTableNeame($tableNeame)
	{
		$this->tableNeame = $tableNeame;
	}

	function setDataType($dataType)
	{
		$this->dataType = $dataType;
	}

	function setKeyField($keyField)
	{
		$this->keyField = $keyField;
	}
}
