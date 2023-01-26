<?php
$params->setIfEmpty("jsObjName", "formData");
$jsObjName = $params->get("jsObjName");
$ctrlTagOptions = 'outlined size="lg"';

if (!$user) {
	return;
}
?>
<div class="row q-col-gutter-sm">

	<div class="col-12 col-md-6 <?= "" ?>">
		<q-input v-model="<?= $jsObjName ?>.medData.temperature" label="Температура" <?= $ctrlTagOptions ?>>
		</q-input>
	</div>
	<div class="col-6 col-md-3 <?= "" ?>">
		<q-input v-model="<?= $jsObjName ?>.medData.pressure1" label="Давление" <?= $ctrlTagOptions ?>>
		</q-input>
	</div>
	<div class="col-6 col-md-3 <?= "" ?>">
		<q-input v-model="<?= $jsObjName ?>.medData.pressure2" label="на" <?= $ctrlTagOptions ?>>
		</q-input>
	</div>
	<div class="col-12 col-md-6 <?= "" ?>">
		<q-input v-model="<?= $jsObjName ?>.medData.glucose" label="Сахар" <?= $ctrlTagOptions ?>>
		</q-input>
	</div>
	<div class="col-12 col-md-6 <?= "" ?>">
		<q-input v-model="<?= $jsObjName ?>.medData.saturation" label="Сатурация" <?= $ctrlTagOptions ?>>
		</q-input>
	</div>
</div>
<div class="my-5" v-if="true">
	<?php
	$view->moduleComponent("app", "form/actions", $params);
	?>
</div>
<div class="my-5" v-else">
	{{computedTimerString}} / {{timerDelaySec}} sec left
</div>