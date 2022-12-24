<?php

namespace Expertix\Module\Store\Order;

use Expertix\Module\Services\Activity\ActivityModel;
use Expertix\Core\Controller\Base\BaseApiController;
use Expertix\Core\Db\SqlFilter;
use Expertix\Core\Util\ArrayWrapper;
use Expertix\Core\Util\Log;

class OrderApiController extends BaseApiController
{
	protected function onCreate()
	{
		$this->addRoute("order_create", "create");
		$this->addRoute("order_update", "updateOrder");
		$this->addRoute("order_delete", "deleteOrder");

		$this->addRoute("order_get_list", "getOrderList");
		$this->addRoute("order_get", "getOrderWithActivityList");

		$this->addRoute("order_activity_create", "createActivityForOrder");
		$this->addRoute("order_activity_delete", "deleteActivityForOrder");
		$this->addRoute("order_activity_get_list", "getActivityListForOrder");
	}
	private function getModel()
	{
		return new OrderModel();
	}
	private function getChildModel()
	{
		return new ActivityModel();
	}

	public function getOrderList($request)
	{
		$model = $this->getModel();
		$filter = new SqlFilter($request);
		return $model->getCollection($filter);
	}
	public function getOrder($request)
	{
		$model = $this->getModel();
		$key = $request->getRequired("key");
		$dataObject = $model->getCrudObject($key);
		if (!$dataObject) {
			throw new \Exception("Не найдены данные для ключа $key", 1);
		}
		return $dataObject;
	}
	public function getOrderWithActivityList($request)
	{
		$dataObject = $this->getOrder($request);
		$dataObjectId = $dataObject->getId();

		$childList = $this->getOrderChildList($dataObjectId, "getActivityListForOrder");
		$dataObject->set("childs", $childList);
		return $dataObject;
	}
	public function getActivityListForOrder($request)
	{
		$key = $request->get("key", $request->get("parentKey"));
		if (!$key) {
			throw new \Exception("Не указан параметр key", 1);
		}
		$request->set("key", $key);
		$obj = $this->getOrderWithActivityList($request);
		return $obj->get("childs");

		//		$model = $this->getModel();
		//		$dataObjectId = $model->getIdByKey($key);
		//		return $this->getOrderChildList($dataObjectId, "getActivityListForOrder");
	}

	private function getOrderChildList($dataObjectId, $getChildsFunc)
	{
		$childModel = $this->getChildModel();
		$childList = $childModel->$getChildsFunc($dataObjectId);
		Log::d("getOrderChildList", $childList, 0);
		return $childList;
	}

	// Create update

	public function create($request)
	{
		// Заказ может создавать только авторизованный пользователь
		$user = $this->requireUser();
		
		$productsArr = $request->required("products");
		if(!is_array($productsArr)){
			throw new WrongOrderException("Ошибка создания заказа. Неверный массив товаров", 1);			
		}
		$order = new ArrayWrapper([]);

		$clientId = $user->getId();
		$operatorId = null;
		$agencyId = $user->getAgencyId();

		// В режиме работы оператора (привелегированный пользователь) 
		if($user->getLevel()>0){
			// Если установлен clientId, значит, заказ заводил оператор. Запоминаем отдельно оператора
			$clientId = $request->get("clientId", null);
			if($clientId){
				$operatorId = $user->getId();
			}else{
				// Если clientId не был установлен, устанавливаем текущим пользователем
				$clientId = $user->getId();
			}

			$agencyId = $request->get("agencyId", $user->getAgencyId());
		}

		$order->set("clientId", $clientId);
		$order->set("operatorId", $operatorId);
		$order->set("agencyId", $agencyId);
		$order->set("operatorCompanyId", $user->getCompanyId());

		$model = $this->getModel();
		return $model->create($order, $productsArr);
	}
	public function updateOrder($request)
	{
		$model = $this->getModel();
		$key = $request->getRequired("key");

		return $model->update($request, $key);
	}
	public function deleteOrder($request)
	{
		$model = $this->getModel();
		$key = $request->get("key");
		return $model->hide($key);
	}

	// Create Update For childs


	public function createChildForOrder($request)
	{
		$model = $this->getModel();
		$modelChild = $this->getChildModel();

		if (!$request->get("relParentId")) {
			$orderKey = $request->getRequired("parentKey");
			$orderId = $model->getIdByKey($orderKey);
			$request->set("relParentId", $orderId);
		}

		return $modelChild->createUpdateActivity($request, "create");
	}
	public function deleteActivityForOrder($request)
	{
		$model = $this->getChildModel();
		$key = $request->get("key");
		return $model->deleteActivity($key);
	}
}
