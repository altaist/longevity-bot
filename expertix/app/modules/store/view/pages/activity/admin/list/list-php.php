

<?php

use Expertix\Module\Store\Product\Product;

$filter = new \Expertix\Core\Db\SqlFilter([]);
$model = $pageData->getModel();
$list = $model->getProductsList($filter);

$theme->setAutoPrint(true);
$theme->sectionTitle("Курсы");
$theme->startGrid("col-12 col-md-6");
$theme->html("<div class=\"my-3\"><a href=\"#\" @click.prevent=\"onCreateEmpty('Новый курс')\">Добавить новый курс</a></div>");
$theme->endGrid();

$theme->startGrid("col-12 col-md-6");

foreach ($list as $key => $productArr) {
	$product = new Product($productArr);
	$theme->moduleComponent("store", "product/item-admin", [$product, "store-admin/product/" . $product->get("slug"), $product->getKey()]);
}

$theme->endGrid();
?>
<div>
	
</div>
<div class="my-5">
	
</div>


<?php
include __DIR__ . "/_footer.php";
?>
