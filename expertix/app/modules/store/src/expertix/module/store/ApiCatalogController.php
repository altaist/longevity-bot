<?php

namespace Expertix\Module\Store;

use Expertix\Core\Controller\Base\BaseApiController;
use Expertix\Core\Db\SqlFilter;
use Expertix\Core\Util\Log;
use Expertix\Module\Services\service\ServiceModel;
use Expertix\Module\Store\Product\ProductModel;

class ApiCatalogController extends BaseApiController
{
	function onCreate()
	{
		$this->addRoute("product_create", "createProduct");
		$this->addRoute("product_update", "updateProduct");
		$this->addRoute("product_delete", "deleteProduct");
		$this->addRoute("product_get_all", "getProducts");
		$this->addRoute("product_get", "getProduct");

		$this->addRoute("product_service_create", "createServiceForProduct");
		$this->addRoute("product_service_delete", "deleteServiceForProduct");
		$this->addRoute("product_service_get_list", "getServicesForProduct");
	}
	function getModel()
	{
		return new ProductModel();
	}
	function getChildModel()
	{
		return new ServiceModel();
	}


	function getProducts($request)
	{
		$model = $this->getModel();
		$filter = new SqlFilter($request);
		return $model->getProductsList($filter);
	}
	function getProduct($request)
	{
		return $this->getProductWithServices($request);
	}
	function getProductWithServices($request)
	{
		$model = $this->getModel();
		$key = $request->getRequired("key");
		$product = $model->getProduct($key);
		if (!$product) return null;
		$productId = $product->getId();
		
		$serviceModel = $this->getChildModel();
		$services = $serviceModel->getServiceListForProduct($productId);

		if (is_array($services) && count($services) > 0) {
			$product->set("serviceId", $services[0]["serviceId"]);
		}
		$product->set("services", $services);
		//Log::d("getProductWithServices", $product, 0);
		return $product;
	}

	public function createProduct($request)
	{
		$model = $this->getModel();
		return $model->createUpdateProduct($request, "create");
	}
	public function updateProduct($request)
	{
		$model = $this->getModel();
		return $model->createUpdateProduct($request, "update");
	}
	public function deleteProduct($request)
	{
		$model = $this->getModel();
		$key = $request->get("key");
		return $model->deleteProduct($key);
	}

	// Childs
	function getServicesForProduct($request)
	{

		if (!$request->get("key")) {
			$request->set("key", $request->get("parentKey"));
		}

		$product = $this->getProduct($request);
		if (!$product) {
			return null;
		}

		return $product->get("services");
	}
	public function createServiceForProduct($request)
	{
		$model = $this->getModel();
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
