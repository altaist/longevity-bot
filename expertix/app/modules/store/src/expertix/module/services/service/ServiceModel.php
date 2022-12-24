<?php
namespace Expertix\Module\Services\Service;

use Expertix\Core\Db\DB;
use Expertix\Core\Data\BaseModel;

use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;

class ServiceModel extends BaseModel
{
	protected $tableName = "srv_service";
	protected $dataType = "service";
	
	public function getCrudObject($key, $user=null)
	{
		return $this->getService($key);
	}
	public function getCrudCollection($query, $user=null)
	{
		return $this->getServiceListForProduct($query);
	}
	
	public function getIdByKey($key){
		$tableName = $this->tableName;
		$type = $this->dataType;
		return DB::getValue("select {$type}Id from $tableName where {$type}Key=?", [$key]);
	}

	
	public function getService($key){
		$sql = "select s.*, s.serviceKey as `key`, p.title as productTitle, p.subTitle as productSubTitle, p.slug as 'productSlug' from srv_service s inner join store_product p on p.productId=s.productId where s.serviceKey=? and s.isDeleted=0 order by s.serviceId desc";
		$service = DB::getRow($sql, [$key]);
		
		if(!$service){
			return null;
		}
		
		return new Service($service);		
	}

	function getServiceList($filter)
	{
		return $this->getServiceListForProduct($filter);
	}

	function getServiceListForProduct($productId)
	{
		$sql = "select *, srv_service.serviceKey as `key` from srv_service where productId=? and isDeleted=0 order by srv_service.serviceId desc";
		$services = DB::getAll($sql, [$productId]);
		return $services;
	}
	

	public function getServicesForUser($user){
		$userId = $user->getId();
		
		$sql ="select service.*, service.serviceKey as `key` from srv_service service inner join srv_subscription subs on service.serviceId = subs.serviceId and subs.userId=? and service.isDeleted=0 order by subs.subscriptionId desc, service.serviceId desc" ;
		$result = DB::getAll($sql, [$userId]);
		return $result;
	}
	
	/**
	 * undocumented function summary
	 *
	 * Undocumented function long description
	 *
	 * @param  $request Description
	 * @return type
	 * @throws conditon
	 **/
	function createUpdateService($request, $action, $user = null)
	{
		
		$productId = $request->getRequired("productId");
		
		if(!$productId){
			throw new \Exception("Неверный идентификатор продукта", 1);
		}
		$title = $request->get("title");
		$subTitle = $request->get("subTitle");
		$description = $request->get("description");
		$state = $request->get("state");

		$result = null;

		if ($action == "update") {
			$key = $request->getRequired("key");
			$params = [$title, $subTitle, $description, $state, $productId];
			$params[] = $key;
			$sql = "update srv_service set `title`=?, `subTitle`=?, `description`=?, state=?, `productId`=? where `serviceKey`=?;";
			$result = DB::set($sql, $params);
		} else {
			$key = $this->createKey($title, "srv_service", "serviceKey");
			Log::d("createUpdateService key:", $key);
			$params = [$title, $subTitle, $description, $state, $productId];
			$params[] = $key;

			$sql = "insert into srv_service (title, subTitle, description, state, productId, serviceKey) values(?,?,?,?,?,?);";
			$result = DB::add($sql, $params);
		}		
		
		return $result;
	}

	function deleteService($key)
	{
		$sql = "update srv_service set isDeleted=1 where serviceKey = ?";
		return DB::set($sql, [$key]);
	}
	
	
}