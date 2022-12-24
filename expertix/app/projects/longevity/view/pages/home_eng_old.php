<?php //$view->component("header", ["title" => "Название проекта", "home_icon" => "home", "home_href" => "'home'", "class" => "menu-top1"]); 
?>

<div class="container">
	<div class="my-3">
		<q-img src="img/med/grandparents2.jpg" height="400px" class="rounded" rounded>
			<div class="absolute-full flex flex-center text-center">
				<div class="text-h3">Digital Companion</div>
				<div class="text-h6">
					<div></div>
				</div>
			</div>
		</q-img>
	</div>
	<div class="my-5">
		<div class="title2 my-5 text-center text-orange">A digital service that helps longevity through big data collection and AI</div>
		<div class="title5 p-3 my-3 mx-md-5 border-left-red border-right-red rounded text-justify ">
			We are developing a digital companion that will collect biomedical and life data of the user in order to prolong his healthy and high-quality life. Data will be collected from various wearable devices, dialogue via a chatbot, voice and face analysis via a smartphone. The task is to collect the maximum amount of data about the user, compare it with the "ideal health model" and make recommendations. The metrics to be measured will be physical activity, heart rate, blood oxygen saturation, sleep quality, biomarkers of biological age, diet, emotional and physical feedback from the user. The result of data processing will be calculated as lifespan expectancy and will be a biofeedback for the user.
		</div>
	</div>
	<div class="my-3">
		<div id="mainCards" class="my-3">
			<div class="row justify-around items-start content-center q-col-gutter-md">
				<div class="col-12 col-md-4 item-stretch" v-for="(item, index) in mainMenuEng">
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
		<?php $view->section("Longevity drivers") ?>
		<div class="row q-col-gutter-sm">
			<div class="col-6 col-md-3">
				<q-btn label="Diet @Nutrition" icon="spa" stack stretch class="full-width" size="lg" color="deep-orange"></q-btn>
			</div>
			<div class="col-6 col-md-3">
				<q-btn label="Physical Activity" icon="hiking" stack stretch class="full-width" size="lg" color="deep-orange"></q-btn>
			</div>
			<div class="col-6 col-md-3">
				<q-btn label="Smart Lifestyle" icon="school" stack stretch class="full-width" size="lg" color="deep-orange"></q-btn>
			</div>
			<div class="col-6 col-md-3">
				<q-btn label="Social support" icon="theater_comedy" stack stretch class="full-width" size="lg" color="deep-orange"></q-btn>
			</div>
		</div>
	</div>
	<div class="my-3" v-if="false">
<q-btn label="test email" @click="onSubscribe(user)"></q-btn>
	</div>
	<div class="my-5">
		<?php
		$view->component("@user/signup_eng", ["color" => "orange", "btn-ok-label" => "Create companion"]);
		?>
	</div>
	<div class="my-5">
		<?php $view->section("How it works") ?>
		<div class="my-3">
			<q-stepper v-model="stepper" ref="stepper" header-nav color="orange" :contracted="$q.screen.lt.md" animated>
				<q-step :name="0" title="Linking" icon="school">
					<h5 class="my-3">Feeding</h5>
					We feed our companion with data from a wearable device and answers to questions in the chat
				</q-step>
				<q-step :name="1" title="Learning" icon="hiking">
					<h5 class="my-3">Learning</h5>
					The companion compares our data with the ideal health model for our age and gives recommendations for increasing lifespan expectancy
				</q-step>
				<q-step :name="2" title="Winning" icon="emoji_events" :done="step > 2">
					<h5 class="my-3">Winning</h5>
					Your healthy lifestyle improves your digital companion and increases the value of his crypto wallet. And of course, it gives you years of a healthy and happy life
				</q-step>
				<template v-slot:navigation>
					<q-stepper-navigation>
						<q-btn @click="$refs.stepper.next()" color="orange" label="Next" v-if="stepper <2"></q-btn>
						<q-btn v-if="stepper > 0" flat color="orange" @click="$refs.stepper.previous()" label="Prev" class="q-ml-sm"></q-btn>
					</q-stepper-navigation>
				</template>
			</q-stepper>
		</div>
	</div>
	<div class="my-5">
		<?php $view->section("Roadmap") ?>
		<div class="my-5">
			<q-timeline color="orange">

				<q-timeline-entry title="Step 1" subtitle="">
					<div>
						Customer Discovery - product solution fit @ MVP
					</div>
				</q-timeline-entry>

				<q-timeline-entry title="Step 2" subtitle="" icon="spa">
					<div>
						Customer Validation – product market fit @ business model
					</div>
				</q-timeline-entry>

				<q-timeline-entry title="Step 3" subtitle="">
					<div>Sales@Marketing, seed investment round</div>
				</q-timeline-entry>
				<q-timeline-entry title="Step 3" subtitle="">
					<div>Scale Execution on global market</div>
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
						<div class="title3 mt-3">Vitaliy Nedelskiy</div>
						<div class="subtitle1 mt-3">Founder, CEO, Chief Product</div>
					</center>
					<div>
					</div>
				</div>
				<div class="col-12 col-md-4 p-md-2">
					<center><img src="img/med/tatyana.jpg" height="300" style="border-radius: 50%;">
						<div class="title3 mt-3">Tatiana Stepina</div>
						<div class="subtitle1 mt-3">Founder, Private investor and mentor</div>
					</center>
					<ul>
					</ul>
				</div>
				<div class="col-12 col-md-4 p-md-2">
					<center><img src="img/med/pecherskiy.jpg" height="300" style="border-radius: 50%;">
						<div class="title3 mt-3">Alex Pecherskiy</div>
						<div class="subtitle1 mt-3">Founder, CTO</div>
					</center>
					<ul>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="my-5">
		<?php
			$view->component("@user/signup_eng", ["color" => "orange", "btn-ok-label" => "Create companion"]);
		?>
	</div>
	<div class="text-center">
		<q-img src="img/med/ekg.png" style="width:100%">
	</div>



</div>


<?php $view->component("footer", ["title" => "", "class" => "menu-footer1"]); ?>