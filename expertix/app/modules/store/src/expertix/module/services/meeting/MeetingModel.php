<?php
namespace Expertix\Module\Services\Meeting;

use Expertix\Core\Db\DB;
use Expertix\Core\Data\BaseModel;

use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;

class MeetingModel extends BaseModel
{
	
	function __construct()
	{
		$this->tableName = "srv_meeting";
		$this->dataType = "meeting";
		$this->keyField = "meetingKey";
	}
	
	
	public function getCrudObject($key, $user=null)
	{
		return $this->getMeeting($key);
	}
	public function getCrudCollection($query, $user=null)
	{
		return $this->getMeetingListForService($query);
	}
	

	
	public function getMeeting($key){
		$tableName = $this->getTableName();
		$type = $this->getDataType();
		$keyField = $this->getKeyField();
		
		$sql = "select data.*, data.{$keyField} as `key` from $tableName as data where data.{$keyField}=? and data.isDeleted=0 order by data.meetingId desc";
		$meeting = DB::getRow($sql, [$key]);
		
		if(!$meeting){
			return null;
		}
		
		return new Meeting($meeting);		
	}

	function getCollection($filter)
	{
		return $this->getMeetingListForService($filter);
	}

	function getMeetingListForService($serviceId)
	{
		$tableName = $this->getTableName();
		$type = $this->getDataType();
		$keyField = $this->getKeyField();
		

		$sql = "select *, data.{$keyField} as `key` from $tableName as data where serviceId=? and isDeleted=0 order by data.{$type}Id desc";
		$result = DB::getAll($sql, [$serviceId]);
		return $result;
	}
	
	function create($request, $relParentId=-1){

		$title = $request->get("title");
		$subTitle = $request->get("subTitle");
		$description = $request->get("description");
		$state = $request->get("state");

		$key = $this->createKey($title);
		Log::d("createMeeting key:", $key);
		$params = [$title, $subTitle, $description, $state, $relParentId];
		$params[] = $key;

		$sql = "insert into {$this->getTableName()} (title, subTitle, description, state, serviceId, `{$this->getKeyField()}`) values(?,?,?,?,?,?);";
		$result = DB::add($sql, $params);
		return $result;		
	}
	
	function update($request, $key)
	{

		if (!$key) {
			throw new \Exception("Неверный ключ объекта для изменений", 1);
		}

		$title = $request->get("title");
		$subTitle = $request->get("subTitle");
		$description = $request->get("description");
		$state = $request->get("state");
		$relParentId = $request->get("relParentId");

		$params = [$title, $subTitle, $description, $state, $relParentId];
		$params[] = $key;
		$sql = "update {$this->getTableName()} set `title`=?, `subTitle`=?, `description`=?, state=?, `serviceId`=? where `{$this->getKeyField()}`=?;";
		$result = DB::set($sql, $params);
		


		$sql = "insert into {$this->getTableName()} (title, subTitle, description, state, serviceId, {$this->getKeyField()}) values(?,?,?,?,?,?);";
		$result = DB::add($sql, $params);
		return $result;
	}
	function createUpdate123($request, $action, $user = null)
	{
		$tableName = $this->getTableName();
		$type = $this->getDataType();
		$keyField = $this->getKeyField();
		

		$parentId = $request->getRequired("serviceId");
		
		if(!$parentId){
			throw new \Exception("Неверный идентификатор сервиса", 1);
		}
		$title = $request->get("title");
		$subTitle = $request->get("subTitle");
		$description = $request->get("description");
		$state = $request->get("state");

		$result = null;

		if ($action == "update") {
			$key = $request->getRequired("key");
			$params = [$title, $subTitle, $description, $state, $parentId];
			$params[] = $key;
			$sql = "update $tableName set `title`=?, `subTitle`=?, `description`=?, state=?, `serviceId`=? where `{$keyField}`=?;";
			$result = DB::set($sql, $params);
		} else {
			$key = $this->createKey($title, $tableName, $keyField);
			Log::d("createUpdateMeeting key:", $key);
			$params = [$title, $subTitle, $description, $state, $parentId];
			$params[] = $key;

			$sql = "insert into $tableName (title, subTitle, description, state, serviceId, {$keyField}) values(?,?,?,?,?,?);";
			$result = DB::add($sql, $params);
		}		
		
		return $result;
	}

}