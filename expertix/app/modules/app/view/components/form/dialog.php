<?php
$jsObjName = $params->get("js_obj_name");
$jsObjType = $params->get("obj_type", $jsObjName);
$jsObjIdField = $params->get("obj_id_field", $jsObjType . "Id");
$viewType = $props->get("dialog_type", "full");
?>

<q-dialog v-model="<?= $props->get("vue_model", "dialog") ?>" <?= $props->get("persistent") ? "persistent" : "" ?> <?= $props->get("small") ? "" : "full-width" ?> transition-show="scale" transition-hide="scale">

	<?php

	if ($viewType == "full") {
		include __DIR__ . "/dialog-with-layouts.php";
	} else if ($viewType == "simple") {
		include __DIR__ . "/dialog-simple.php";
	}

	?>
</q-dialog>
