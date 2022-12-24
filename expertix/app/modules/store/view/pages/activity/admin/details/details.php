<?php
include __DIR__ . "/_header.php";
?>
<div>
	<h2 class="title1" style="color: orange"><?= $data->get("title") ?></h2>
</div>
<?php

//$theme->moduleComponent("store", "product/form-product-edit", $data);

$theme->setAutoPrint(true);

$theme->sectionTitle("Редактирование");
$theme->html("<div class='my-5'>");
$theme->moduleComponent("store", "product/form-product-edit-vh", [$theme]);
$theme->html("</div>");

$theme->startRow();
$theme->startCol("col-6 col-md-6 text-bottom");
$theme->button("onCrudCancel", "Отмена")->endCol()->startCol("col-6 col-md-6 text-right text-bottom");
$theme->button("onCrudSave", "Сохранить")->endCol();
$theme->endRow();




?>

<div class="my-5">
	<div class="title3">
<?php $theme->sectionTitle("Сервисы")?>
	</div>
	<div>
		<div class="my-3"><a href="#" @click.prevent="onCreateChildModal()">Добавить новый сервис</a></div>
	</div>
	<div class="row my-3">
		<div class="col-12 col-md-4 my-1" v-for="item in storage.list">
			<div class="card">
				<img class="card-img-top" :src="item.img">
				<div class="card-body">
					<h5 class="card-title">{{item.title}}</h5>
					<p class="card-text">{{item.subTitle}}</p>
					<div class="my-1">
						<div class="row">
							<div class="col-6">
								<a href="#" @click.prevent="onChildDelete(item.key)" class="card-link">Удалить</a>
							</div>
							<div class="col-6 text-right">
								<a :href="''+getChildItemDetailsLink(item.key)" class="card-link">Перейти</a>
							</div>
						</div>
					</div>
				</div>
			</div><!-- //card-->
		</div>
	</div>
</div>

<?php
include __DIR__ . "/_footer.php";
?>