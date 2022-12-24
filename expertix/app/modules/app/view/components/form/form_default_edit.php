<?php
$params->setIfEmpty("js_obj_name", "formData");
include __DIR__ . "/" . "form_header.php";
?>
<div>
	<div class="row q-col-gutter-sm">
		<?php
		include __DIR__ . "/fields/content-text.php"
		?>

		<?php
		include __DIR__ . "/fields/content-media.php"
		?>

		<div class="col-12 col-md-12 ">
			<hr>
		</div>

		<div class="col-12 col-md-12 <?= $ctrlClassOptions ?>">
			<q-toggle v-model="<?= $jsObjName ?>.state" label="Опубликовать" color="<?= $color ?>" true-value="1" false-value="0" keep-color></q-toggle>
		</div>
		<!--div class="col-12 col-md-12 <?= $ctrlClassOptions ?>">
			<q-toggle v-model="<?= $jsObjName ?>.isActive" label="Доступен для регистрации" color="<?= $color ?>" true-value="1" false-value="0" keep-color></q-toggle>
		</div-->

		<div class="col-12">
			<div class="my-5 p-1">
				<?php
				$view->moduleComponent("app", "form/actions", $params);
				?>
			</div>
		</div>
	</div>
</div>