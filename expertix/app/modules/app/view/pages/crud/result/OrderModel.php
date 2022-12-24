<?php
namespace Order;

use Expertix\Core\Db\DB;
use Expertix\Core\Data\BaseModel;

use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;

class OrderModel extends BaseModel
{	
	function __construct()
	{
		$this->tableName = "store_order";
		$this->dataType = "order";
		$this->keyField = "orderKey";
	}
	
	
	public function getCrudObject($key, $user=null)
	{
		return $this->getObject($key);
	}
	public function getCrudCollection($query, $user=null)
	{
		return $this->getCollection($query);
	}
public function getObject($request){ 

	$key = $request->get('orderKey', $request);
	$sql = "select 1, productId, userId, operatorId, quantity, price, price1, price2, price3, priceNetto1, priceNetto2, priceNetto3, quantity1, quantity2, quantity3, state, extraPay, prepaid1, prepaid2, dateFrom, dateTo, placeId, comments, isDeleted from store_order where orderKey=?";
	return DB::getrow($sql, [$key]);
}

public function getCollection($request){ 

	$sql = "select 1, productId, userId, operatorId, quantity, price, price1, price2, price3, priceNetto1, priceNetto2, priceNetto3, quantity1, quantity2, quantity3, state, extraPay, prepaid1, prepaid2, dateFrom, dateTo, placeId, comments, isDeleted from store_order";
	return DB::getAll($sql, []);
}

public function create($request){ 
	$productId = $request->get('productId');
	$userId = $request->get('userId');
	$operatorId = $request->get('operatorId');
	$quantity = $request->get('quantity');
	$price = $request->get('price');
	$price1 = $request->get('price1');
	$price2 = $request->get('price2');
	$price3 = $request->get('price3');
	$priceNetto1 = $request->get('priceNetto1');
	$priceNetto2 = $request->get('priceNetto2');
	$priceNetto3 = $request->get('priceNetto3');
	$quantity1 = $request->get('quantity1');
	$quantity2 = $request->get('quantity2');
	$quantity3 = $request->get('quantity3');
	$state = $request->get('state');
	$extraPay = $request->get('extraPay');
	$prepaid1 = $request->get('prepaid1');
	$prepaid2 = $request->get('prepaid2');
	$dateFrom = $request->get('dateFrom');
	$dateTo = $request->get('dateTo');
	$placeId = $request->get('placeId');
	$comments = $request->get('comments');
	$isDeleted = $request->get('isDeleted');

	$orderKey = $this->createKey('OrderModel');
	$params = [$productId, $userId, $operatorId, $quantity, $price, $price1, $price2, $price3, $priceNetto1, $priceNetto2, $priceNetto3, $quantity1, $quantity2, $quantity3, $state, $extraPay, $prepaid1, $prepaid2, $dateFrom, $dateTo, $placeId, $comments, $isDeleted, $orderKey];

	$sql = "insert into store_order(productId, userId, operatorId, quantity, price, price1, price2, price3, priceNetto1, priceNetto2, priceNetto3, quantity1, quantity2, quantity3, state, extraPay, prepaid1, prepaid2, dateFrom, dateTo, placeId, comments, isDeleted, orderKey) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	return DB::add($sql, $params);
}

public function update($request){ 
	$productId = $request->get('productId');
	$userId = $request->get('userId');
	$operatorId = $request->get('operatorId');
	$quantity = $request->get('quantity');
	$price = $request->get('price');
	$price1 = $request->get('price1');
	$price2 = $request->get('price2');
	$price3 = $request->get('price3');
	$priceNetto1 = $request->get('priceNetto1');
	$priceNetto2 = $request->get('priceNetto2');
	$priceNetto3 = $request->get('priceNetto3');
	$quantity1 = $request->get('quantity1');
	$quantity2 = $request->get('quantity2');
	$quantity3 = $request->get('quantity3');
	$state = $request->get('state');
	$extraPay = $request->get('extraPay');
	$prepaid1 = $request->get('prepaid1');
	$prepaid2 = $request->get('prepaid2');
	$dateFrom = $request->get('dateFrom');
	$dateTo = $request->get('dateTo');
	$placeId = $request->get('placeId');
	$comments = $request->get('comments');
	$isDeleted = $request->get('isDeleted');

	$orderKey = $request->get('orderKey');
	$params = [$productId, $userId, $operatorId, $quantity, $price, $price1, $price2, $price3, $priceNetto1, $priceNetto2, $priceNetto3, $quantity1, $quantity2, $quantity3, $state, $extraPay, $prepaid1, $prepaid2, $dateFrom, $dateTo, $placeId, $comments, $isDeleted, $orderKey];

	$sql = "update store_order set productId=? ,userId=? ,operatorId=? ,quantity=? ,price=? ,price1=? ,price2=? ,price3=? ,priceNetto1=? ,priceNetto2=? ,priceNetto3=? ,quantity1=? ,quantity2=? ,quantity3=? ,state=? ,extraPay=? ,prepaid1=? ,prepaid2=? ,dateFrom=? ,dateTo=? ,placeId=? ,comments=? ,isDeleted=?  where orderKey=?";
	return DB::set($sql, $params);
	}
}
