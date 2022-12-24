<?php

use Expertix\Core\App\App;
use Expertix\Core\App\AppContext;
use Expertix\Core\Util\ArrayWrapper;

$key = $pageData->getObjectId();
$product = null;
$includePath = "";
if ($key) {
	$model = $pageData->getModel(); //new Expertix\Module\Store\ProductModel();
	$productArray = $model->getProductWithServices($key);
	
	if($productArray){
		$product = new ArrayWrapper($productArray);
		$viewKey = $product->get("viewKey", "default");
		$includePath = __DIR__ . "/custom/$viewKey.php";

		$pageData->set("productId", $product->get("productId"));
		//print_r($product->getArray());
	}
	
}else{
	App::redirect404();
}



include $includePath;



?>

