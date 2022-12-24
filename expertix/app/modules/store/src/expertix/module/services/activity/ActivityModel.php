<?php
namespace Expertix\Module\Services\Activity;

use Expertix\Core\Db\DB;
use Expertix\Core\Data\BaseModel;

use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;

class ActivityModel extends BaseModel
{


	function __construct()
	{
		$this->tableName = "srv_activity";
		$this->dataType = "activity";
		$this->keyField = "activityKey";
	}
	

	public function getCrudObject($key, $user = null)
	{
		return $this->getActivity($key);
	}
	public function getCrudCollection($query, $user = null)
	{
		return $this->getActivityListForMeeting($query);
	}

	public function getIdByKey($key)
	{
		return $key;
	}
	
	public function	getActivity($key){
		$sql = "select activity.*, activity.activityKey as `key` from srv_activity activity  where activity.activityKey = ? and activity.isDeleted=0";
		$result = DB::getRow($sql, [$key]);
		return new Activity($result);
	}

	public function getActivityListForMeeting($activityId)
	{
		$sql = "select a.*, a.activityKey as `key` from srv_activity a left join srv_activity_meeting am on am.activityId=a.activityId where am.meetingId=? and a.isDeleted=0 order by a.activityId desc";
		$result = DB::getAll($sql, [$activityId], "getActivityListForMeeting");
		return $result;
	}

	public function getItemListForActivity($activityId)
	{
return [];
	}
	//
	function createUpdateActivity($request, $action, $user = null)
	{

		$relParentId = $request->getRequired("relParentId");

		if (!$relParentId) {
			throw new \Exception("Неверный идентификатор встречи", 1);
		}
		$title = $request->get("title");
		$subTitle = $request->get("subTitle");
		$description = $request->get("description");
		$state = $request->get("state");

		$result = null;

		if ($action == "update") {
			$key = $request->getRequired("key");
			$params = [$title, $subTitle, $description, $state, $relParentId];
			$params[] = $key;
			$sql = "update srv_activity set `title`=?, `subTitle`=?, `description`=?, state=?, `serviceId`=? where `activityKey`=?;";
			$result = DB::set($sql, $params);
		} else {
			$key = $this->createKey($title, "srv_activity", "activityKey");
			Log::d("createUpdateactivity key:", $key);
			$params = [$title, $subTitle, $description, $state];
			$params[] = $key;

			$sql = "insert into srv_activity (title, subTitle, description, state, activityKey) values(?,?,?,?,?);";
			$activityId = DB::add($sql, $params);
			
			$params = [$activityId, $relParentId];
			$sql = "insert into srv_activity_meeting (activityId, meetingId) values(?,?);";
			$result = DB::set($sql, $params);

		}

		return $result;
	}

	function deleteActivity($key)
	{
		$sql = "update srv_activity set isDeleted=1 where activityId = ?";
		return DB::set($sql, [$key]);
	}
}
