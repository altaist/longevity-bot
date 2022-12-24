<?php
namespace Expertix\Module\Store\Order;

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
		return $this->getOrder($key);
	}
	public function getCrudCollection($query, $user=null)
	{
		return $this->getOrderListForService($query);
	}
		
	public function getOrder($key){
		$tableName = $this->getTableName();
		$type = $this->getDataType();
		$keyField = $this->getKeyField();
		
		$sql = "select data.*, data.{$keyField} as `key` from $tableName as data where data.{$keyField}=? and data.isDeleted=0 order by data.orderId desc";
		$order = DB::getRow($sql, [$key]);
		
		if(!$order){
			return null;
		}
		
		return new Order($order);		
	}

	function getCollection($filter, $orderBy)
	{
		return $this->getOrderListForService($filter);
	}

	function getOrderListForService($serviceId)
	{
		$tableName = $this->getTableName();
		$type = $this->getDataType();
		$keyField = $this->getKeyField();
		

		$sql = "select *, data.{$keyField} as `key` from $tableName as data where serviceId=? and isDeleted=0 order by data.{$type}Id desc";
		$result = DB::getAll($sql, [$serviceId]);
		return $result;
	}

	public function create($order, $productsArr)
	{
		$clientId = $order->get('clientId');
		$operatorId = $order->get('operatorId');
		$operatorCompanyId = $order->get('operatorCompanyId');
		$agencyId = $order->get('agencyId');
		$state = 0;
		
		$addedIds = [-1];
		$addedQuery = "?";
		foreach ($productsArr as $key => $productArr) {
			$product = new ArrayWrapper($productArr);
			Log::d("Adding product: ". $product->get("productId"));
			
			$productId = $product->get('productId');
			$quantity = $product->get('quantity');
			$price = $product->get('price');
			$price1 = $product->get('price1');
			$price2 = $product->get('price2');
			$price3 = $product->get('price3');
			$priceNetto1 = $product->get('priceNetto1');
			$priceNetto2 = $product->get('priceNetto2');
			$priceNetto3 = $product->get('priceNetto3');
			$quantity1 = $product->get('quantity1');
			$quantity2 = $product->get('quantity2');
			$quantity3 = $product->get('quantity3');
			$extraPay = $product->get('extraPay');
			$prepaid1 = $product->get('prepaid1');
			$prepaid2 = $product->get('prepaid2');
			$dateFrom = $product->get('dateFrom');
			$dateTo = $product->get('dateTo');
			$placeId = $product->get('placeId');
			$contactsTel = $product->get('contactsTel');
			$contactsName = $product->get("contactsName");
			$contactsAddress = $product->get("contactsAddress");
			$comments = $product->get('comments');
			$isDeleted = 0;

			$orderKey = $this->createKey('OrderModel');
			$params = [$productId, $clientId, $operatorId, $operatorCompanyId, $agencyId, $quantity, $price, $price1, $price2, $price3, $priceNetto1, $priceNetto2, $priceNetto3, $quantity1, $quantity2, $quantity3, $state, $extraPay, $prepaid1, $prepaid2, $dateFrom, $dateTo, $placeId, $comments, $contactsTel, $contactsName, $contactsAddress, $isDeleted, $orderKey];

			$sql = "insert into store_order(productId, clientId, operatorId, operatorCompanyId, agencyId, quantity, price, price1, price2, price3, priceNetto1, priceNetto2, priceNetto3, quantity1, quantity2, quantity3, state, extraPay, prepaid1, prepaid2, dateFrom, dateTo, placeId, comments, contactsTel, contactsName, contactsAddress, isDeleted, orderKey) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$addedIds[] = DB::add($sql, $params);
			$addedQuery .= ", ?";
		}
		
		$sql = "select * from store_order where orderId IN ($addedQuery)";
		return DB::getAll($sql, $addedIds);
		
	}
	

	public function update($request, $key)
	{
		if (!$key) {
			throw new \Exception("Неверный ключ объекта для изменений", 1);
		}
		
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

		$orderKey = $key;
		$params = [$productId, $userId, $operatorId, $quantity, $price, $price1, $price2, $price3, $priceNetto1, $priceNetto2, $priceNetto3, $quantity1, $quantity2, $quantity3, $state, $extraPay, $prepaid1, $prepaid2, $dateFrom, $dateTo, $placeId, $comments, $isDeleted, $orderKey];

		$sql = "update store_order set productId=?, userId=?, operatorId=?, quantity=?, price=?, price1=?, price2=?, price3=?, priceNetto1=?, priceNetto2=?, priceNetto3=?, quantity1=?, quantity2=?, quantity3=?, state=?, extraPay=?, prepaid1=?, prepaid2=?, dateFrom=?, dateTo=?, placeId=?, comments=?, isDeleted=?  where orderKey=?";
		return DB::set($sql, $params);
	}
	
}