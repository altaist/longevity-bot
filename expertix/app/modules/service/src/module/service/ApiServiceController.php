<?php
namespace Module\Service;

use Expertix\Core\Controller\Base\BaseApiController;
use Expertix\Core\Db\DB;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;

class ApiServiceController extends BaseApiController{
	protected function onCreate()
	{
		parent::onCreate();

		$this->addRoute("get_all_services", "getAllServices", 0);
		$this->addRoute("get_services", "getActiveServices", 0);

		$this->addRoute("service_delete", "serviceDelete", 0);
		$this->addRoute("service_update", "serviceUpdate", 0);
		$this->addRoute("service_create", "serviceCreate", 0);
	}
	
	public function getAllServices($request){
		$sql = "select * from srv_service order by dateFrom";
		return DB::getAll($sql, []);
	}
	public function getActiveServices($request){
		$sql = "select * from srv_service where dateFrom>=NOW() order by dateFrom";
		return DB::getAll($sql, []);
	}
	public function getHistoryServices($request)
	{
		$sql = "select * from srv_service where dateFrom<NOW() order by dateFrom";
		return DB::getAll($sql, []);
	}
	
	public function serviceDelete($request){
		return true;
	}
	public function serviceCreate($request){
		return true;
	}
	public function serviceUpdate($request){
		return true;
	}

}