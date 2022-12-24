<div id="carousel" class="">

	<div id="myCarousel" class="pt-3 carousel slide" data-ride="carousel">

		<!--ol class="carousel-indicators">
						<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
						<li data-target="#myCarousel" data-slide-to="1"></li>
						<li data-target="#myCarousel" data-slide-to="2"></li>
					</ol-->
		<div class="carousel-inner">
			<div class="carousel-item active">
				<img src="img/intellect/inn1.jpg" class="cover bd-placeholder-img">
				<div class="overlay"></div>
				<div class="container">
					<div class="carousel-caption text-left">
						<h1>Опубликуй проект</h1>
						<p>И получи поддержку от компаний и организаций региона</p>
						<p><a class="btn btn-lg btn-secondary" href="#da" role="button">Узнать больше!</a></p>
					</div>
				</div>
			</div>
			<div class="carousel-item">
				<img src="img/intellect/inn2.jpg" class="cover bd-placeholder-img">
				<div class="overlay"></div>
				<div class="container">
					<div class="carousel-caption text-left">
						<h1>Научись новому</h1>
						<p>Корпоративные образовательные программы</p>
						<p><a class="btn btn-lg btn-secondary" href="#da" role="button">Узнать больше!</a></p>
					</div>
				</div>
			</div>

		</div>

		<a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Предыдущий</span>
		</a>
		<a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Следующий</span>
		</a>
	</div>

</div>

<div>
	<div class="card-deck mb-3 feature-block">
		<?= $pageBuilder->card("Есть идея или стартап?", "Опубликуй проект за 5 минут и получай откдики и оценки", null, "project-edit/", "bg-danger text-white shadow") ?>
		<?= $pageBuilder->card("Ищите проекты и команды?", "Смотри список активных проектов и выбирай лучшие", null, "#", "bg-warning text-white shadow") ?>
		<?= $pageBuilder->card("Мероприятия и обучение!", "Круглые столы, дискуссионные площадки, лекции и мастер-классы", null, "#",  "bg-success text-white shadow") ?>

	</div>
</div>


<div class="my-5">
	<div class="my-3">
		<div class="title3">Последние проекты</div>
		<hr>
	</div>
	<div class="my-3">
		<div class="row">
			<div class="col-12 col-md-12 my-1">
				<b-button href="project-edit/" variant="info">Добавить свой проект!</b-button>

			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12 col-md-12 my-1" v-for="item in filteredListTop10">
			<?php include __DIR__ . "/project/_item.php" ?>
		</div>
	</div>
	<div class="title4 mb-2">
		<a href="projects/"><span class="text-danger">Посмотреть все проекты</span></a>
	</div>

</div>

<div class="my-4">
	<div class="my-3">
		<div class="title2">Готовы поддержать!</div>
		<hr>
	</div>
	<div class="row">
		<div class="col-12 col-md-4 my-3" v-for="item in storage.list2">
			<a :href="item.siteUrl || '#'">{{item.title}}</a>
		</div>
	</div>

</div>
<!--div class="my-3">
	<div class="my-3">
		<div class="title2">Бизнес-Ангелы</div>
		<hr>
	</div>
	<div class="my-3">
		<div class="row">
			<div class="col-12 col-md-6 my-1">

			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12 col-md-6 my-1">
		</div>
	</div>

</div>
<div class="my-3">
	<div class="my-3">
		<div class="title2">Полезные ресурсы</div>
		<hr>
	</div>
	<div class="my-3">
		<div class="row">
			<div class="col-12 col-md-6 my-1">

			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12 col-md-6 my-1">
		</div>
	</div>

</div-->