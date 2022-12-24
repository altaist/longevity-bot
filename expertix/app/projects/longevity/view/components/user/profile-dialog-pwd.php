<?php
$params->setIfEmpty("jsObjName", "formData");
$jsObjName = $params->get("jsObjName");
$ctrlTagOptions = 'outlined size="lg"';

if (!$user) {
	return;
}
?>
<div class="row q-col-gutter-sm">

	<div class="col-12 col-md-4 <?= "" ?>">
		<q-input v-model="<?= $jsObjName ?>.password" label="Password" <?= $ctrlTagOptions ?>>
		</q-input>
	</div>
	<div class="col-12 col-md-4 <?= "" ?>">
		<q-input v-model="<?= $jsObjName ?>.password2" label="Password2" <?= $ctrlTagOptions ?>>
		</q-input>
	</div>
</div>
<div class="my-5">
	<?php
	$view->moduleComponent("app", "form/actions", $params);
	?>
</div>