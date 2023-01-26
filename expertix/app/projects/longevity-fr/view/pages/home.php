<?php //$view->component("header", ["title" => "Название проекта", "home_icon" => "home", "home_href" => "'home'", "class" => "menu-top1"]); 
?>

<div class="container">
	<div class="my-3">
		<q-img src="img/med/grandparents2.jpg" height="400px" class="rounded" rounded>
			<div class="absolute-full flex flex-center text-center">
				<div class="text-h3">Ассистент долголетия</div>
				<div class="text-h6">
					<div></div>
				</div>
			</div>
		</q-img>
	</div>
	<div class="my-5">
		<div class="title2 my-5 text-center text-orange">Цифровой сервис, помогающий продлить здоровую жизнь человека</div>
		<div class="title5 p-3 my-3 mx-md-5 border-left-red border-right-red rounded text-justify ">
			{{lorem2}}
		</div>
	</div>
	<div class="my-3">
		<div id="mainCards" class="my-3">
			<div class="row justify-around items-start content-center q-col-gutter-md">
				<div class="col-12 col-md-4 item-stretch" v-for="(item, index) in mainMenu">
					<q-card :class="'bg-' + (item.color || 'blue' )+' text-white'">
						<q-card-section class="q-mt-none text-h5">
							{{ item.title }}
						</q-card-section>
						<q-separator dark inset></q-separator>
						<q-card-section class="q-mt-none text-subtitle1">
							{{ item.subTitle }}
						</q-card-section>
						<q-card-actions align="right" v-if="item.href">
							<q-btn :href="item.href" label="Подробнее" flat color="white"></q-btn>
						</q-card-actions>
					</q-card>
				</div>
			</div>
		</div>
	</div>
	<div class="my-5">
		<?php $view->section("Треки развития") ?>
		<div class="row q-col-gutter-sm">
			<div class="col-6 col-md-3">
				<q-btn label="Питание" icon="spa" stack stretch class="full-width" size="lg" color="deep-orange"></q-btn>
			</div>
			<div class="col-6 col-md-3">
				<q-btn label="Движение" icon="hiking" stack stretch class="full-width" size="lg" color="deep-orange"></q-btn>
			</div>
			<div class="col-6 col-md-3">
				<q-btn label="Интеллект" icon="school" stack stretch class="full-width" size="lg" color="deep-orange"></q-btn>
			</div>
			<div class="col-6 col-md-3">
				<q-btn label="Настроение" icon="theater_comedy" stack stretch class="full-width" size="lg" color="deep-orange"></q-btn>
			</div>
		</div>
	</div>
	<div class="my-3">

	</div>
	<div class="my-5">
		<?php
		$view->component("@user/signup", ["color" => "orange", "btn-ok-label" => "Создать аватар"]);
		?>
	</div>
	<div class="my-5">
		<?php $view->section("Как это работает") ?>
		<div class="my-3">
			<q-stepper v-model="stepper" ref="stepper" header-nav color="orange" :contracted="$q.screen.lt.md" animated>
				<q-step :name="0" title="Узнаем" icon="school">
					<h5 class="my-3">Узнаем</h5>
					Ассистент собирает данные от пользователя, умных гаджетов и других источников информации. За каждый ввод данных пользователь получает вознаграждение
				</q-step>
				<q-step :name="1" title="Делаем" icon="hiking">
					<h5 class="my-3">Делаем</h5>
					На основе проанализированной информации создаются паттерны поведения и рекоменации, которым должен следовать пользователь для увеличения продолжительности жизни
				</q-step>
				<q-step :name="2" title="Выигрываем" icon="emoji_events" :done="step > 2">
					<h5 class="my-3">Получаем</h5>
					Полезные действия прокачивают характеристики виртуального персонажа и за развитие своего здоровья пользователь увеличивает ожидаемую продолжительность жизни.
				</q-step>
				<template v-slot:navigation>
					<q-stepper-navigation>
						<q-btn @click="$refs.stepper.next()" color="orange" label="Дальше" v-if="stepper <2"></q-btn>
						<q-btn v-if="stepper > 0" flat color="orange" @click="$refs.stepper.previous()" label="Назад" class="q-ml-sm"></q-btn>
					</q-stepper-navigation>
				</template>
			</q-stepper>
		</div>
	</div>
	<div class="my-5">
		<?php $view->section("Roadmap") ?>
		<div class="my-5">
			<q-timeline color="orange">

				<q-timeline-entry title="Шаг 1" >
					<div>
						Сбор аналитики и проблемные интервью, формирование образа продукта
					</div>
				</q-timeline-entry>

				<q-timeline-entry title="Шаг 2"  icon="spa">
					<div>
						Разработка прототипа и проверка продуктовых гипотез
					</div>
				</q-timeline-entry>

				<q-timeline-entry title="Шаг 3" >
					<div>
						Создание компании и первый раунд финансирования
					</div>
				</q-timeline-entry>

			</q-timeline>
		</div>

	</div>
	<div class="my-3">
		<?php $view->section("Founders") ?>
		<div>
			<div class="row mt-3">
				<div class="col-12 col-md-4 p-md-2">
					<center><img src="img/med/nedelskiy.jpg" height="300" style="border-radius: 50%;">
						<div class="title3 mt-3">Виталий Недельский</div>
						<div class="subtitle1 mt-3">Founder, CEO, Chief Product</div>
					</center>
					<div>
					</div>
				</div>
				<div class="col-12 col-md-4 p-md-2">
					<center><img src="img/med/tatyana.jpg" height="300" style="border-radius: 50%;">
						<div class="title3 mt-3">Татьяна Степанова</div>
						<div class="subtitle1 mt-3">Co-founder, Private investor and mentor</div>
					</center>
					<ul>
					</ul>
				</div>
				<div class="col-12 col-md-4 p-md-2">
					<center><img src="img/med/pecherskiy.jpg" height="300" style="border-radius: 50%;">
						<div class="title3 mt-3">Александр Печерский</div>
						<div class="subtitle1 mt-3">CTO, IT-developer</div>
					</center>
					<ul>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="my-5" v-if="false">
		<?php $view->section("FAQ") ?>
		<div>
			<q-list bordered>
				<q-expansion-item group="group1" icon="info" label="Как создать аватара?" default-opened header-class="color1">
					<q-card>
						<q-card-section>
							{{lorem2}}
						</q-card-section>
					</q-card>
				</q-expansion-item>

				<q-separator></q-separator>

				<q-expansion-item group="group1" icon="info" label="Какие данные нужно предоставить?" header-class="color1">
					<q-card>
						<q-card-section>
							{{lorem2}}
						</q-card-section>
					</q-card>
				</q-expansion-item>

				<q-separator></q-separator>
				<q-expansion-item group="group1" icon="info" label="Как контролируется соблюдение предписаний?" header-class="color1">
					<q-card>
						<q-card-section>
							{{lorem2}}
						</q-card-section>
					</q-card>
				</q-expansion-item>

				<q-separator></q-separator>
			</q-list>

		</div>
	</div>
	<div class="my-5">
		<?php
		$view->component("@user/signup", ["color" => "orange", "btn-ok-label" => "Создать ассистента"]);
		?>
	</div>
	<div class="text-center">
		<q-img src="img/med/ekg.png" style="width:100%">
	</div>



</div>


<?php $view->component("footer", ["title" => "", "class" => "menu-footer1"]); ?>