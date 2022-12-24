<?php

namespace Expertix\Core\Db;

use Expertix\Core\Exception\AppInitException;
use Expertix\Core\util\MyLog;

class DB
{
	/*
	public static $dsn = 'mysql:dbname=table;host=localhost';
	public static $user = 'user';
	public static $pass = 'password';
	*/
	public static $startupAttr = array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'");

	/**
	 * Объект \PDO.
	 */
	public static $dbh = null;

	/**
	 * Statement Handle.
	 */
	public static $sth = null;

	/**
	 * Выполняемый SQL запрос.
	 */
	public static $query = '';

	/**
	 * Подключение к БД
	 */
	public static function connect($sql_details){
		if(!$sql_details){
			throw new AppInitException('App: Database config is empty!', 0);
		}
		
		$dsn = $sql_details["dsn"];
		$user = $sql_details["user"];
		$pass = $sql_details["pass"];
		$startupAttr = self::$startupAttr;
		
		
		try {
			self::$dbh = new \PDO(
				$dsn,
				$user,
				$pass,
				$startupAttr
			);
			self::$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		} catch (\PDOException $e) {
			exit('Ошибка при подключении к базе данных: ' . $e->getMessage());
		}		
	}
	
	public static function disconnect(){
		self::$dbh = null;
	}
	 
	 
	public static function getDbh($sql_details = null)
	{
		return self::$dbh;
	}

	/**
	 * Добавление в таблицу, в случаи успеха вернет вставленный ID, иначе 0.
	 */
	public static function add($query, $param = array(), $debugText = null)
	{
		self::$query = $query;
		if ($debugText) {
			MyLog::d($debugText . " Sql ADD query:" . $query, $param);
		}
		self::$sth = self::getDbh()->prepare($query);
		return (self::$sth->execute((array) $param)) ? self::getDbh()->lastInsertId() : -1;
	}

	/**
	 * Выполнение запроса.
	 */
	public static function set($query, $param = array(), $debugText = null)
	{
		self::$query = $query;
		if ($debugText) {
			MyLog::d($debugText . " Sql SET query:" . $query, $param);
		}
		self::$sth = self::getDbh()->prepare($query);
		$result = self::$sth->execute((array) $param);
		return $result;
	}
	
	public static function delete($tableName, $keyField, $value){
		$sql = "delete from $tableName where $keyField=?";
		$result = self::set($sql, [$value]);
		
		// Log delete
		$userKey = null;
		$sql = "insert into log_delete (`userKey`, `tableName`, `keyField`, `keyValue`) values(?, ?, ?, ?)";
		$params = [$userKey, $tableName, $keyField, $value];
	}

	/**
	 * Получение строки из таблицы.
	 */
	public static function getRow($query, $param = array(), $debugText = null)
	{
		self::$query = $query;
		if ($debugText) {
			MyLog::d($debugText . " Sql SELECT ROW:" . $query, $param);
		}
		self::$sth = self::getDbh()->prepare($query);
		self::$sth->execute((array) $param);
		return self::$sth->fetch(\PDO::FETCH_ASSOC);
	}

	/**
	 * Получение всех строк из таблицы.
	 */
	public static function getAll($query, $param = array(), $debugText = null)
	{
		self::$query = $query;
		if ($debugText) {
			MyLog::d($debugText . " Sql SELECT ALL:" . $query, $param);
		}
		self::$sth = self::getDbh()->prepare($query);
		self::$sth->execute((array) $param);
		return self::$sth->fetchAll(\PDO::FETCH_ASSOC);
	}


	/**
	 * Получение значения.
	 */
	public static function getValue($query, $param = array(), $default =null, $debugText = null)
	{
		self::$query = $query;
		if ($debugText) {
			MyLog::d($debugText . " Sql SELECT VALUE: '" . $query."'", $param);
		}
		$result = self::getRow($query, $param);
		if (!empty($result)) {
			$result = array_shift($result);
		}

		return (empty($result)) ? $default : $result;
	}

	/**
	 * Получение столбца таблицы.
	 */
	public static function getColumn($query, $param = array())
	{
		self::$query = $query;
		self::$sth = self::getDbh()->prepare($query);
		self::$sth->execute((array) $param);
		return self::$sth->fetchAll(\PDO::FETCH_COLUMN);
	}
	
	public static function getTableColumns($tableName, $exceptColumns = null){
		$exceptSql = "";
		if($exceptColumns){
			$exceptSql = " AND column_name not in ( $exceptColumns ) ";
		}
		$columns = DB::getColumn("SELECT column_name FROM information_schema.columns WHERE table_schema = database() AND table_name = ? $exceptSql", [$tableName]);
		return $columns;
	}
	
	/*
	 * Транзакции
	 */

	static function beginTransaction()
	{
		self::getDbh()->beginTransaction();
	}
	static function commit()
	{
		self::getDbh()->commit();
	}
	static function rollback()
	{
		self::getDbh()->rollback();
	}


	//
	static function cutEnd($str, $symb = ",")
	{
		$pos = strrpos($str, $symb);
		if ($pos === false) {
			return $str;
		}
		return substr($str, 0, $pos);
	}
	function select($sql, $values)
	{
		$errors = [];
		try {
			$data = DB::getAll($sql, $values);
		} catch (\Exception $e) {
			$errors[] = $e->getMessage();
			MyLog::error($e->getMessage());
		}

		return array("errors" => $errors, "result" => $data);
	}

	static function createWhere($fields, $union = "and", $conditions = null)
	{
		$strWhere = "1=?";
		$arrValues = $union == "and" ? [1] : [0];
		foreach ($fields as $key => $value) {
			//MyLog::debug($key . ": ". is_null($value) .is_int($value) . is_numeric($value) .($value===""));
			if (!is_int($value) && ($value === null || $value === "" || (is_array($value) && count($value) == 0))) {
				//
			} else {

				$dbField = $key;
				$condition = empty($conditions[$key]) ? "=" : $conditions[$key];
				$val = "";
				if (is_array($value)) {
					$dbField = empty($value["dbField"]) ? $dbField : $value["dbField"];
					$condition = empty($value["condition"]) ? $condition : $value["condition"];
					$val = empty($value["value"]) ? $val : $value["value"];
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
		return ["sql" => $strWhere, "params" => $arrValues, "values" => $arrValues];
	}

	static function createQuery($values, $fields = null)
	{
		if (empty($values)) return null;
		$keys = empty($fields) ? array_keys($values) : $fields;
		$str_select = "";
		$str_fields = "";
		$str_update = "";
		$str_params = "";
		$paramsVal = [];
		foreach ($keys as $field) {

			$str_fields .= "`$field`, ";
			$str_params .= "?, ";
			$str_update .= "`$field`=?,";
			if (isset($values[$field])) {
				$value = $values[$field];
				if (is_array($value) || is_object($value)) { // Jsoned if object or array
					$value = json_encode($value);
				}
				$paramsVal[] = $value;
			}
		}
		$str_fields = self::cutEnd($str_fields);
		$str_params = self::cutEnd($str_params);
		$str_update = self::cutEnd($str_update);

		$str_select = $str_fields;
		return ["select" => $str_select, "fields" => $str_fields, "sets" => $str_update, "params" => $str_params, "values" => $paramsVal];
	}

	static function createSql($table, $values, $fields = null)
	{
		$q = self::createQuery($values, $fields);
		$fields = $q['fields'];
		$params = $q['params'];
		$sets = $q['sets'];
		$values = $q["values"];

		$sql_insert = "insert into $table ($fields) values ($params)";
		$sql_update = "update $table set $sets where id=?";
		$sql_delete = "delete from $table where id=?";
		$sql_select = "select * from $table where id=?";
		$sql_select_all = "select * from $table";


		return array_merge(
			$q ? $q : [],
			["sql_insert" => $sql_insert, "sql_update" => $sql_update, "sql_delete" => $sql_delete, "sql_select_all" => $sql_select_all, "sql_select" => $sql_select]
		);
	}

}