<?php

namespace Expertix\Module\Store\Product;

use Expertix\Core\Db\DB;
use Expertix\Core\Data\BaseModel;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;


class ProductModel extends BaseModel
{
	protected $tableName = "store_product";
	protected $dataType = "product";
	
	public function getCrudObject($productId, $user=null)
	{
		return $this->getProduct($productId);
	}
	public function getCrudCollection($query, $user=null)
	{
		return $this->getProductsList($query);
	}

	public function getIdByKey($key)
	{
		$tableName = $this->tableName;
		$type = $this->dataType;
		return DB::getValue("select {$type}Id from $tableName where {$type}Key=?", [$key]);
	}


	function getProductWithServices123($productKey)
	{

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

	function getProductsList($filter)
	{
		$filter_sql = "1=1";
		$filter_params = [];
		if ($filter) {
			$filter_sql = $filter->getSqlWherePart();
			$filter_params = $filter->getParams();
		}
		$params = $filter_params;

		$sql = "select p.*, p.productKey as `key` from store_product p where $filter_sql and isDeleted=0";
		$rows = DB::getAll($sql, $params);
		return $rows;
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
	
	function deleteProduct($key){
		$sql = "update store_product set isDeleted=1 where productKey = ?";
		return DB::set($sql, [$key]);
	}
	function restoreProduct($key){
		$sql = "update store_product set isDeleted=0 where productKey = ?";
		return DB::set($sql, [$key]);
	}
	function deleteProductStrong($key)
	{
		$sql = "delete from store_product where productKey = ?";
		return DB::set($sql, [$key]);
	}
	
	// 

}
