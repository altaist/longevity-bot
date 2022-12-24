<?php

namespace Expertix\Module\Catalog\Product;


use Expertix\Core\Data\BaseModel;
use Expertix\Core\Db\DB;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;


class ServiceModel extends BaseModel
{
	function setup()
	{
		$this->tableName = "srv_service";
		$this->dataType = "service";
		$this->keyField = "serviceKey";
	}
	
	public function getSubscription($userId, $serviceId){
		$params= [$userId, $serviceId];
		$result = DB::getRow("select * from subscription where userId=? and serviceId=?", $params);
		return $result;
	}
}