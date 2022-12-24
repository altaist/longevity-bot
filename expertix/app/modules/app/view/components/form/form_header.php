<?php

use Expertix\Core\Util\Log;

if (!$user) {
	return;
}

//Log::d("js_obj_name!!!", $params->get("js_obj_name"));
$jsObjName = $params->get("js_obj_name");
$jsObjType = $params->get("obj_type", $jsObjName);
$jsObjIdField = $params->get("obj_id_field", $jsObjType."Id");


$ctrlTagOptions = 'outlined size="lg"';
$ctrlClassOptions =	$props->get("ctrlClassOptions");

$color = $params->get("color", "primary");