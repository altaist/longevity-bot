<?php
namespace Expertix\Module\Startup\Project;

use Expertix\Core\Db\DB;
use Expertix\Core\Data\BaseModel;

use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;

class ProjectModel extends BaseModel
{


	function __construct()
	{
		$this->tableName = "prj_project";
		$this->dataType = "project";
		$this->keyField = "projectKey";
	}
	

	public function getCrudObject($key, $user = null)
	{
		return $this->getProject($key);
	}
	public function getCrudCollection($query, $user = null)
	{
		return $this->getProjectList($query);
	}

	public function	getProject($key){
		$sql = "select p.*, p.projectKey as `key`, pa.fav, pa.helpMoney, pa.helpInfo, pa.helpEdu, pa.actionComments from prj_project p left join prj_project_action pa on p.projectId=pa.projectId where p.projectKey = ? and p.isDeleted=0";
		$result = DB::getRow($sql, [$key]);
		return new Project($result);
	}

	public function getProjectList($request, $userId=-1)
	{
		//$type=$request->get("type", 0);
		$sql = "select p.*, p.projectKey as `key`, pa.fav, pa.helpMoney, pa.helpInfo, pa.helpEdu, pa.actionComments from prj_project p left join prj_project_action pa on p.projectId=pa.projectId  where p.isDeleted=0 order by p.projectId desc";
		
		$result = DB::getAll($sql);
		return $result;
	}

	public function getProjectListForMeeting($projectId)
	{
		$sql = "select a.*, a.projectKey as `key` from srv_project a left join srv_project_meeting am on am.projectId=a.projectId where am.meetingId=? and a.isDeleted=0 order by a.projectId desc";
		$result = DB::getAll($sql, [$projectId]);
		return $result;
	}

	public function getActionListForProject($projectId)
	{
		$sql = "select pa.*, u.firstName, u.lastName from prj_project_action pa left join app_user u on u.userId=pa.userId where projectId=? order by created desc";
		$result = DB::getAll($sql, [$projectId]);
		return $result;
	}
	//

	function create($request, $userId)
	{

		$title = $request->get("title");
		$subTitle = $request->get("subTitle");
		$description = $request->get("description");
		$state = $request->get("state");
		$type = $request->get("type");
		$authorId = $userId;
		if(!$authorId) $authorId = -1; //!!!

		$siteUrl = $request->get("siteUrl");
		$presentation = $request->get("presentation");
		$img = $request->get("img");
		$video = $request->get("video");

		$key = $this->createKey($title);
		Log::d("createMeeting key:", $key);
		$params = [$title, $subTitle, $description, $state, $type, $siteUrl, $presentation, $img, $video, $authorId];
		$params[] = $key;

		$sql = "insert into {$this->getTableName()} (title, subTitle, description, state, type, siteUrl, presentation, img, video, authorId, `{$this->getKeyField()}`) values(?, ?, ?,?,?,?,?,?,?,?,?);";
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
		$type = $request->get("type");
		
		$siteUrl = $request->get("siteUrl");
		$presentation = $request->get("presentation");
		$img = $request->get("img");
		$video = $request->get("video");


		$params = [$title, $subTitle, $description, $state, $type, $siteUrl, $presentation, $img, $video];
		$params[] = $key;
		$sql = "update {$this->getTableName()} set `title`=?, `subTitle`=?, `description`=?, state=?, type=?, siteUrl=?, presentation=?, img=?, video=? where `{$this->getKeyField()}`=?;";
		$result = DB::set($sql, $params);
		return $result;
	}
	
	function getProjectId($request){
		$key = $request->getRequired("key");
		$id = $this->getIdByKey($key);

		if (!$id) {
			throw new \Exception("Неверный ключ объекта для изменений", 1);
		}
		return $id;		
	}

	function updateLike($request, $action)
	{
		$key = $request->getRequired("key");
		$value = $request->get("value", 1);		
		$projectId = $this->getIdByKey($key);
		

		if (!$projectId) {
			throw new \Exception("Неверный ключ объекта для изменений", 1);
		}
		
		$count = DB::getValue("select `$action` from prj_project where projectKey=?", [$key]);
		if(!$count){
			$count = 0;
		}
		$count+=$value ;
		
		$sql = "update prj_project set `$action`=? where projectKey=?";
		DB::set($sql, [$count, $key]);

		return $count;
	}
	
	function updateAction($request, $action, $userId){
		
		if(!$userId) return null;
		$projectId = $this->getProjectId($request);
		
		
		$check = DB::getValue("select projectId from prj_project_action pa where projectId=? and pa.userId=? ", [$projectId, $userId]);
		if (!$check) {
			$sql = "insert into prj_project_action(projectId, userId) values(?,?)";
			$params = [$projectId, $userId];
			DB::add($sql, $params);
		}

		$value = $request->get("value");

		if(is_array($value)){
			$sql = "update prj_project_action pa set helpMoney=0, helpInfo=0, helpEdu=0 where projectId=? and userId=?";
			DB::set($sql, [$projectId, $userId]);
			
			$fieldNames = ["helpMoney", "helpInfo", "helpEdu"];
			
			$arrValue = isset($value["types"])?$value["types"]:[];
			foreach ($arrValue as $key => $val) {
				if($val>=1 && $val<=count($fieldNames)){
					Log::d("Update value $val", $fieldNames[$val - 1]);
					$sql = "update prj_project_action pa set `{$fieldNames[$val-1]}`=1 where projectId=? and userId=?";
					DB::set($sql, [$projectId, $userId]);
				}else{

					
				}
			}
			
			$comments = isset($value["comments"])?$value["comments"]:null;
			if($comments){
				Log::d("Update value as comments", $comments);
				$sql = "update prj_project_action pa set `actionComments`=? where projectId=? and userId=?";
				DB::set($sql, [$comments, $projectId, $userId]);
			}
			
		}else{
			$sql = "update prj_project_action pa set `$action`=? where projectId=? and userId=?";
			DB::set($sql, [$value, $projectId, $userId]);
		}

		
	
	}
	
	public function checkinForEvent($request){
		$activityId = $request->get("activityId", 1);
		$name = $request->get("name");
		$org = $request->get("org");
		$presentationTitle = $request->get("presentationTitle");
		
		$sql = "insert into srv_action (activityId, name, org, presentationTitle) values(?,?,?,?)";
		return DB::add($sql, [$activityId, $name, $org, $presentationTitle]);
		
	}
	
	public function getCheckinList($request){
		$activityId = $request->get("activityId", 1);
		$sql = "select * from srv_action where activityId=?";
		return DB::getAll($sql, [$activityId]);
	}

}
