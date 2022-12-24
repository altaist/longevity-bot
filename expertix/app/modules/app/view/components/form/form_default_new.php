<?php
$params->setIfEmpty("js_obj_name", "formDataNew");
include __DIR__ . "/" . "form_header.php";
?>

<div>
	<div class="row q-col-gutter-sm">
		<div class="col-12 col-md-6 my-1 <?= "ctrlClassOptions" ?>">
			<q-input v-model="<?= $jsObjName ?>.title" label="Название" <?= $ctrlTagOptions ?>>
			</q-input>
		</div>
		<div class="col-12 col-md-6 my-1 <?= "ctrlClassOptions" ?>">
			<q-input v-model="<?= $jsObjName ?>.subTitle" label="Краткое описание" <?= $ctrlTagOptions ?>>
			</q-input>
		</div>

		<div class="col-12">
			<div class="my-5">
				<?php
				$view->moduleComponent("app", "form/actions", $params);
				?>
			</div>
		</div>

	</div>
</div>