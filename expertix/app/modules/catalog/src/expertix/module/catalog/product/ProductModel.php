<?php

namespace Expertix\Module\Catalog\Product;


use Expertix\Core\Db\DB;

use Expertix\Core\Data\BaseModel;

use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;


class ProductModel extends BaseModel
{
	function setup()
	{
		$this->tableName = "store_product";
		$this->dataType = "product";
		$this->keyField = "productKey";
	}

	public function getSubscription($userId, $productId)
	{
		$params = [$userId, $productId];
		$result = DB::getRow("select * from srv_subscription where userId=? and productId=?", $params, __FUNCTION__);
		return $result;
	}
	
	public function subscribe($userId, $productId){
		$sql = "insert into srv_subscription (userId, productId) values(?,?)";
		$params = [$userId, $productId];
		$id = DB::add($sql, $params);
		return DB::getRow("select * from srv_subscription where subscriptionId=?", [$id]);
	}
	
	public function getProductsForUser($userId){		
		$sql = "select p.*, s.* from store_product p inner join srv_subscription s on p.productId=s.productId and s.userId=? order by s.subscriptionId desc";
		$params = [$userId];
		return DB::getAll($sql, $params);
	}


	function getProduct($productKey)
	{

		$sql = "select p.*, p.productKey as `key` from store_product p where productKey=? or slug=? and isDeleted=0";
		$productArray = DB::getRow($sql, [$productKey, $productKey]);
		//Log::d("getProduct for $productKey:", $productArray);
		if (!$productArray) {
			//			$sql = "select * from store_product where slug=? and isDeleted=0";
			//			$productArray = DB::getRow($sql, [$productId]);
		}

		if (!$productArray) return null;
		return new Product($productArray);
	}

	function getProductList($filter)
	{
		$filter_sql = "1=1";
		$filter_params = [];
		if ($filter) {
			$filter_sql = $filter->getSqlWherePart();
			$filter_params = $filter->getParams();
		}
		$params = $filter_params;

		$sql = "select p.*, p.productKey as `key` from store_product p where $filter_sql and isDeleted=0 order by p.productId desc";

		$rows = DB::getAll($sql, $params);
		return $rows;
	}
	
	public function getUsersForProduct($productKey){
		$sql = "select u.userId, person.*, u.email, u.role, u.level, u.authLink, p.productId, p.productKey from app_person person inner join app_user2 u on u.personId=person.personId inner join srv_subscription s on s.userId=u.userId inner join store_product p on p.productId=s.productId and p.productKey=? order by u.userId desc";
		$params = [$productKey];
		$result = DB::getAll($sql, $params);
		return $result;
	}
		
	function getAction($id, $user = null){
		$params = [$id];
		$result = null;
	
		$sql = "select srv_action.* from srv_action where actionId=?";
		$result = DB::getRow($sql, $params);
		if($result==null) return null;
		return new ArrayWrapper($result);
	}

	function createUpdateProduct($request, $action, $user=null)
	{
		$title = $request->getRequired("title");
		$subTitle = $request->get("subTitle");
		$description = $request->get("description");
		$img = $request->get("img");
		$slug = $request->get("slug");
		$video = $request->get("video");
		$state = $request->get("state");
		
		$type = $request->get("type");
		$categoryId = $request->get("categoryId");
		
		$siteUrl = $request->get("siteUrl");
		$presentation = $request->get("presentation");
		
		
		$result = null;

		if ($action=="update") {
			$key = $request->getRequired("productKey");
			if(!$slug) $slug = $key;
			$params = [$title, $subTitle, $description, $img, $video, $slug, $state];
			$params[] = $key;
			$sql = "update store_product set `title`=?, `subTitle`=?, `description`=?, `img`=?, `video`=?, `slug`=?, state=? where `productKey`=?;";
			$result = DB::set($sql, $params);
		} else {
			$key = $this->createKey($title, "store_product", "productKey");
			Log::d("createUpdateProduct key:", $key);
			if(!$slug) $slug = $key;
			$params = [$title, $subTitle, $description, $img, $video, $slug, $state];
			$params[] = $key;
		
			$sql = "insert into store_product (title, subTitle, description, img, video, slug, state=? productKey) values(?,?,?,?, ?, ?, ?);";
			$result = DB::add($sql, $params);
		}

		return $result;
	}
	
}
