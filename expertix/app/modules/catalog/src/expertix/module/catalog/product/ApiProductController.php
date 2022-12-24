<?php

namespace Expertix\Module\Catalog\Product;

use Expertix\Core\Controller\Base\BaseApiController;
use Expertix\Core\Db\SqlFilter;
use Expertix\Core\Util\Log;

class ApiProductController extends BaseApiController
{
	function onCreate()
	{

		$this->addRoute("product_get_all", "getProductList");
		$this->addRoute("product_get_all_admin", "getProductListAdmin");
		$this->addRoute("product_get_subscribed", "getProductListForUser");
		$this->addRoute("product_get", "getProduct");
		$this->addRoute("product_get_with_childs", "getProductWithChilds");
		
		$this->addRoute("product_get_users", "getUsersForProduct");
		$this->addRoute("product_get_users_all", "getUsersAll");
		
		
		$this->addRoute("subscribe", "subscribeProduct", 0);
//		$this->addAutoRoute("subscribe", "ProductModel", "subscribeProduct", 1);


		$this->addRoute("product_create", "createProduct", 5);
		$this->addRoute("product_update", "updateProduct", 5);
		$this->addRoute("product_delete", "deleteProduct", 10);
		
		$this->addRoute("product_service_create", "createServiceForProduct");
		$this->addRoute("product_service_delete", "deleteServiceForProduct");
		$this->addRoute("product_service_get_list", "getServicesForProduct");

		$this->addRoute("product_remove_img", "removeProductImg");
		
		
		$this->addRoute("meeting_get", "getMeeting");
		$this->addRoute("meeting_create", "createMeeting");
		$this->addRoute("meeting_update", "updateMeeting");
		$this->addRoute("meeting_delete", "deleteMeeting");
		$this->addRoute("meeting_remove_img", "removeMeetingImg");
		
		
	}
	function getProductModel()
	{
		return new ProductModel();
	}
	function getServiceModel()
	{
		return new ServiceModel();
	}
	function getMeetingModel()
	{
		return new MeetingModel();
	}	
	function subscribeProduct($request){
		$model = $this->getProductModel();
		$userId = $this->getUser()->getId();
		//$productKey = $request->get("productKey");
		//$productId = $model->getIdByKey($productKey);
		
		$productId = $request->get("productId");
		
		return $model->subscribe($userId, $productId);
	}


	function getProductList($request)
	{
		$model = $this->getProductModel();
		$request->set("state", 1);
		Log::d("request", $request->getArray());

		$filter = new SqlFilter($request->getArray());
		return $model->getFilteredCollection($filter);
	}
	function getProductListAdmin($request)
	{
		$model = $this->getProductModel();
		$filter = new SqlFilter($request);
		return $model->getFilteredCollection($filter);
	}
	function getProduct($request)
	{
		$model = $this->getProductModel();
		$key = $request->getRequired("key");
		$product = $model->getProduct($key);
		return $product;
	}
	function getProductWithChilds($request)
	{
		$product = $this->getProduct($request);
		if (!$product) return null;
		
		$productId = $product->getId();
		$userId = $this->getUserId();
		// Services
		$product->set("services", $this->getServicesForProduct($productId));

		// Meetings
		$product->set("meetings", $this->getMeetingsForProduct($productId));
		
		$productModel = $this->getProductModel();
		if($userId){
			$subscription = $productModel->getSubscription($userId, $productId);
			$product->set("subscription", $subscription);			
		}
		
		//Log::d("getProductWithServices", $product, 0);
		return $product;
	}

	public function getProductListForUser($request)
	{
		$model = $this->getProductModel();
		$userId = $this->getUserId();
		return $model->getProductsForUser($userId);
	}
	
	protected function getServicesForProduct($productId)
	{
		$serviceModel = $this->getServiceModel();
		$filter = new SqlFilter(["productId" => $productId]);
		$services = $serviceModel->getFilteredCollection($filter);

		return $services;
	}
	
	protected function getMeetingsForProduct($productId){
		$meetingModel = $this->getMeetingModel();
		$filter = new SqlFilter(["productId" => $productId]);
		$meetings = $meetingModel->getFilteredCollection($filter) or [];
		return $meetings;
	}
	
	// Meeting
	public function getMeeting($request){
		$key = $request->get("key");
		$meetingModel = $this->getMeetingModel();
		$meeting = $meetingModel->getObject($key);
		
		$productModel = $this->getProductModel();
		$parentKey = $productModel->getKeyById($meeting["productId"]);
		
		$meeting["parentKey"] = $parentKey;
		return $meeting;
	}
	public function createMeeting($request)
	{
		$meetingModel = $this->getMeetingModel();
		return $meetingModel->create($request, ["title", "subTitle", "description", "img", "video", "productId", "state"]);
	}
	public function updateMeeting($request)
	{
		$meetingModel = $this->getMeetingModel();
		return $meetingModel->update($request, ["title", "subTitle", "description", "img", "video", "productId", "state"]);
	}
	public function deleteMeeting($request)
	{
		$key = $request->get("key");
		$meetingModel = $this->getMeetingModel();
		return $meetingModel->delete($key);
	}
	public function removeMeetingImg($request)
	{
		$model = $this->getMeetingModel();
		$id = $request->get("objectId");

		$this->removeObjImg($model, $id);
	}
	
	// Users
	public function getUsersForProduct($request){
		$key = $request->get("key");
		$productModel = $this->getProductModel();
		$users = $productModel->getUsersForProduct($key);
		
		return $users;
	}	
	public function getUsersAll($request){
		$productModel = $this->getProductModel();
		$users = $productModel->getUsersAll();
		
		return $users;
	}	
	
	
	//

	public function createProduct($request)
	{
		$model = $this->getProductModel();
		return $model->create($request, ["title", "subTitle", "description", "img", "video", "state", "isActive"]);
	}
	public function updateProduct($request)
	{
		$model = $this->getProductModel();
		return $model->update($request, ["title", "subTitle", "description", "img", "video", "state", "isActive"]);
	}
	public function deleteProduct($request)
	{
		$model = $this->getProductModel();
		$key = $request->get("key");
		return $model->delete($key);
	}
	
	public function removeProductImg($request){
		$model = $this->getProductModel();
		$id = $request->get("objectId");
		
		$this->removeObjImg($model, $id);
	}

	// Childs

	public function createServiceForProduct($request)
	{
		$model = $this->getProductModel();
		$modelChild = $this->getChildModel();

		if (!$request->get("productId")) {
			$productKey = $request->getRequired("parentKey");
			$productId = $model->getIdByKey($productKey);
			$request->set("productId", $productId);
		}

		return $modelChild->createUpdateService($request, "create");
	}
	public function deleteServiceForProduct($request)
	{
		$model = $this->getChildModel();
		$key = $request->get("key");
		return $model->deleteService($key);
	}
}
