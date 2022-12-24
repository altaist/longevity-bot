<div>
	<h2 class="title1" style="color: orange"><?= $data->get("title", $data->get("productTitle")) ?></h2>
	<div class="subtitle" style="font-size: 1.6rem">
		<?= $data->get("subTitle", $data->get("productSubTitle")) ?>
	</div>
	<div class="mt-3">
		<?= $theme->a("Посмотреть на сайте", "product/{$data->get('productSlug')}", "target='blank'") ?>
	</div>
	<div class="mt-5 mb-3">
		<?= $theme->sectionTitle("Информация для учеников", "", "bg-danger text-white shadow", "#") ?>
	</div>
	<div class="description">
		<?= $data->get("description", "Вы можете уточнить информацию о времени занятий у своих кураторов") ?>
	</div>
	<div class="mt-5 my-3">
		<?= $theme->sectionTitle("Занятия", "", "bg-danger text-white shadow", "#") ?>
	</div>
	<?php
	$theme->setAutoPrint(true);
	$theme->startGrid("col-12 col-md-4");
	
		$list = $data->get("activities");
		if(is_array($list)){
			$theme->setAutoPrint(true);
			$theme->startRow("col-12 col-md-6");
			foreach ($list as $key => $activity) {
				$type = "quiz";
				$key = $activity['key'];
//				$theme->a($activity["title"], "a/$type/$key");
				$theme->moduleComponent("store", "product/item", [$activity["title"], $activity["subTitle"], "img/intellect/nauka1.jpg", "a/$type/$key"]);

			}
			$theme->endRow();
		}
	?>
</div>