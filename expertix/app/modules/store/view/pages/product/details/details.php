<?php
include __DIR__ . "/_header.php";
?>
<div>
	<h2 class="title1" style="color: orange"><?= $dataObject->get("title") ?></h2>
	<div class="subtitle" style="font-size: 1.6rem">
		<?= $dataObject->get("subTitle") ?>
	</div>
	<div class="mt-5">
		<?= $theme->sectionTitle("Описание курса", "", "bg-danger text-white shadow", "#") ?>
	</div>
	<div class="description">
		<?= $dataObject->get("subTitle") ?>
	</div>
</div>
<?php
include __DIR__ . "/_footer.php";
?>