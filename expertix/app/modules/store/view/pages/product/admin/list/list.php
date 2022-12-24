<?php
$theme->setAutoPrint(true);
$theme->sectionTitle("Курсы");
$theme->startGrid("col-12 col-md-6");
$theme->html("<div class=\"my-3\"><a href=\"#\" @click.prevent=\"onCreateModal()\">Добавить новый курс</a></div>");
$theme->endGrid();

?>
<div>
</div>
<div class="row my-5">
	<div class="col-12 col-md-4 my-2" v-for="item in storage.list">
		<div class="card">
			<img class="card-img-top" :src="item.img">
			<div class="card-body">
				<h5 class="card-title">{{item.title}}</h5>
				<p class="card-text">{{item.subTitle}}</p>
				<div class="my-3">
					<div class="row">
						<div class="col-6">
							<a href="#" @click.prevent="onDelete(item.key)" class="card-link">Удалить</a>
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


<?php
include __DIR__ . "/_footer.php";
?>

