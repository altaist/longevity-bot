<?php

$service = $pageData->getDataObject();
$pageData->set("serviceId", $service->get("serviceId"));
$viewKey = $service->get("viewKey", "default");
$data = $service;
$includePath = __DIR__ . "/custom/$viewKey.php";

include $includePath;

