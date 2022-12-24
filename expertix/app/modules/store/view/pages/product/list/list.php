<?php
include __DIR__ . "/_header.php";
?>


<?php
$filter = new \Expertix\Core\Db\SqlFilter(["appId" => 0]);
$model = $pageData->getModel();
$list = $model->getProductsList($filter);

$theme->setAutoPrint(true);
$theme->sectionTitle("Наши курсы");
$theme->startGrid("col-12 col-md-6");

foreach ($list as $key => $product) {
	$theme->moduleComponent("store", "product/item", [$product["title"], $product["subTitle"], "img/intellect/nauka1.jpg", "podgotovka-ege-oge/" . $product["slug"]]);
}

$theme->endGrid();
?>

<?php
include __DIR__ . "/_footer.php";
?>
