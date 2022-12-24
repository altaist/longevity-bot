<?php

use Expertix\Core\App\App;
use Expertix\Core\App\AppContext;
use Expertix\Core\Util\ArrayWrapper;

$service = $pageData->getDataCollection();
print_r($service);

$key = $pageData->getObjectId();
$service = null;
$includePath = "";
if ($key) {
	$model = $pageData->getModel(); //new Expertix\Module\Store\ProductModel();
	$service = $model->getServiceWithActivities($key);

	if($service){
//		print_r($service);
		$viewKey = $service->get("viewKey", "default");
		$data = $service;
		$includePath = __DIR__ . "/custom/$viewKey.php";

		$pageData->set("serviceId", $service->get("serviceId"));
		//print_r($service->getArray());
	}
	
}else{
	App::redirect404();
}



include $includePath;
