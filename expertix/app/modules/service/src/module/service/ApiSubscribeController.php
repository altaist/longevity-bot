<?php
namespace Module\Service;

use Expertix\Core\Controller\Base\BaseApiController;
use Expertix\Core\Db\DB;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;

class ApiSubscribeController extends BaseApiController{

	protected function onCreate()
	{
		parent::onCreate();

		$this->addRoute("subscribe", "subscribe", 1);
		$this->addRoute("get_products", "getProductsForUser", 1);
	}
	
	public function subscribe($request){
		$user = $this->getUser();
		if (!$user){
			throw new \Exception("Для выполнения операции необходимо зарегистрироваться");
		}
		
		$userId = $user->getId();
		$productId = $request->get("productId", null);
		$serviceId = $request->get("serviceId", null);
		
		$jsonData = $request->get("jsonData");
		$jsonDataStr = "";
		try {
			$jsonDataStr = json_encode($jsonData);
		} catch (\Throwable $th) {
		}
		
		$state = $request->get("state", 0);
		$accessLevel = $request->get("accessLevel", 0);
		$role = $request->get("role", 0);
		$resultLevel = $request->get("resultLevel", 0);
		
		// Check if exists
		$subscribId = DB::getValue("select subscriptionId from srv_subscription where productId=? and userId=?", [$productId, $userId]);
		if($subscribId!=null){
			return $subscribId;
		}

		$sql = "insert into srv_subscription (userId, productId, serviceId, jsonData, state, role, accessLevel, resultLevel) values(?, ? , ?, ?, ?, ?, ?, ?)";
		$params = [$userId, $productId,  $serviceId, $jsonDataStr, $state, $role, $accessLevel, $resultLevel];
		return DB::add($sql, $params, "Adding subscription");
	}
	
	public function getProductsForUser(){
		$user = $this->getUser();
		$userId = $user->getId();
		
		$sql = "select * from srv_subscription s inner join store_product p on s.productId=p.productId where s.userId=? order by s.created ";
		$params = [$userId];
		return DB::getAll($sql, $params);
	}
	

}