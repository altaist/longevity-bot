<?php
$user = $pageData->getUser();
$model = $pageData->getModel();
$services = $model->getServicesForUser($user);
//print_r($user);
//print_r($services);

//print_r($services);

$theme->setAutoPrint(true);
$theme->sectionTitle("Мои курсы");
$theme->startGrid("col-12 col-md-4");

foreach ($services as $key => $service) {
	$theme->moduleComponent("store", "product/item", [$service["title"], $service["subTitle"], "img/intellect/nauka1.jpg", "service/" . $service["serviceKey"]]);
}

$theme->endGrid();
