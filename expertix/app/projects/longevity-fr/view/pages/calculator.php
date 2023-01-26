<?php $view->component("header", ["title" => "Личный кабинет",  "home_href" => "'home'", "class" => "menu-top1"]); ?>

<div>

	<div class=" my-3" v-if="true">
		<q-breadcrumbs size="lg">
			<q-breadcrumbs-el label="Home" icon="home" href="lk"></q-breadcrumbs-el>
			<q-breadcrumbs-el label="Wizard"></q-breadcrumbs-el>
		</q-breadcrumbs>
	</div>
	<div class="text-center my-4" v-if="true">
		<div class="text-h4  text-deep-orange ">Healthy aging wizard</div>
	</div>
	<div class="my-5">


		<div class="my-3">
			<q-stepper v-model="stepper" ref="stepper" header-nav color="orange" :contracted="$q.screen.lt.md" animated>
				<q-step :name="0" title="I am" icon="person">
					<div class="my-md-2 my-1 text-center">
						<h5 class="my-3">Base info</h5>
						<hr>
						<!--div class="my-2 subtitle1">Расскажи нам о себе и узнай, как может измениться твоя жизнь с помощью цифрового ассистента</div-->
						<div class="my-2 subtitle1">Tell us about yourself and find out how your life can change with the help of a digital assistant</div>
						<hr>
						<div class="row q-col-gutter-sm mt-md-5 mt-3">
							<div class="col-6 col-md-4">
								<q-input v-model.number="calculator.age" type="number" label="Your age" filled></q-input>
							</div>
							<div class="col-6 col-md-4">
								<q-select v-model="calculator.gender" :options="['Male', 'Female', 'Other']" label="Your gender" filled></q-select>
							</div>
							<div class="col-12 col-md-4">
								<q-select v-model="calculator.region" :options="['Europe', 'Middle East', 'USA and Canada', 'Latin America', 'Asia', 'Africa', 'Australia']" label="Region" filled></q-select>
							</div>
							<div class="col-6 col-md-4">
								<q-input v-model.number="calculator.weight" type="number" label="Weight" filled></q-input>
							</div>
							<div class="col-6 col-md-4">
								<q-input v-model.number="calculator.length" type="number" label="Body length" filled></q-input>
							</div>
						</div>
					</div>
					<div class="my-md-2 my-1 text-center">
						<h5 class="my-3">Activity</h5>
						<hr>

						<div class="row q-col-gutter-md">
							<div class="col-12 col-md-6 ">
								<div class="my-3 text-subtitle1">
									Walking per day (min)
								</div>

								<div class="my-2 ">
									<q-avatar :color="getColorByLevel(calculator.activityLevel)" text-color="white">{{calculator.activityLevel}}</q-avatar>
								</div>
								<div class="mx-md-2 my-3">
									<q-slider v-model="calculator.activityLevel" :min="0" :max="100" :step="5" snap label :color="getColorByLevel(calculator.activityLevel)"></q-slider>

								</div>
							</div>
							<div class="col-12 col-md-6 ">
								<div class="my-3 text-subtitle1">
									Contacts with friends per month
								</div>

								<div class="my-3">
									<q-avatar :color="getColorByLevel(calculator.socialLevel)" text-color="white">{{calculator.socialLevel}}</q-avatar>
								</div>
								<div class="mx-md-2 my-3">
									<q-slider v-model="calculator.socialLevel" :min="0" :max="100" :step="5" snap label :color="getColorByLevel(calculator.socialLevel)"></q-slider>
								</div>
							</div>
						</div>

					</div>
				</q-step>
				<q-step :name="1" title="I can" icon="calculate">


					<div class="my-md-3 my-1 text-center">
						<h5 class="my-3">I can change:</h5>
						<hr>
						<!--div class="my-2 subtitle1">Мы предлагаем разные сценарии будущего. Посмотрите, каких результатов можно достичь, немного изменения свои привычки</div-->
						<div class="my-2 subtitle1">See what results can be achieved by changing your habits a little</div>
						<hr>

						<div class="row q-col-gutter-md mt-md-5 mt-3">
							<div class="col-12 col-md-6 ">
								<div class="my-2 text-subtitle1">
									Walking time per day
								</div>

								<div class="my-2">
									<q-avatar :color="getColorByLevel(calculator.changeActivityLevel)" text-color="white">{{calculator.changeActivityLevel}}</q-avatar>
								</div>
								<div class="mx-md-2 my-3">
									<q-slider v-model="calculator.changeActivityLevel" :min="0" :max="+100" :step="10" snap label :color="getColorByLevel(calculator.changeActivityLevel)"></q-slider>

								</div>
							</div>
							<div class="col-12 col-md-6 ">
								<div class="my-2 text-subtitle1">
									Meetings with friends per month
								</div>

								<div class="my-2">
									<q-avatar :color="getColorByLevel(calculator.changeSocialLevel)" text-color="white">{{calculator.changeSocialLevel}}</q-avatar>
								</div>
								<div class="mx-md-2 my-3">
									<q-slider v-model="calculator.changeSocialLevel" :min="0" :max="50" :step="10" snap label :color="getColorByLevel(calculator.changeSocialLevel)"></q-slider>
								</div>
							</div>
							<div class="col-12 col-md-6 ">
								<div class="my-2 text-subtitle1">
									% vegetables in the diet
								</div>

								<div class="my-2">
									<q-avatar :color="getColorByLevel(calculator.changeDiet)" text-color="white">{{calculator.changeDiet}}</q-avatar>
								</div>
								<div class="mx-md-2 my-3">
									<q-slider v-model="calculator.changeDiet" :min="0" :max="70" :step="10" snap label :color="getColorByLevel(calculator.changeDiet)"></q-slider>
								</div>
							</div>
							<div class="col-12 col-md-6 ">
								<div class="my-2 text-subtitle1">
									Books read per month
								</div>

								<div class="my-2">
									<q-avatar :color="getColorByLevel(calculator.changeMentalLevel)" text-color="white">{{calculator.changeMentalLevel}}</q-avatar>
								</div>
								<div class="mx-md-2 my-3">
									<q-slider v-model="calculator.changeMentalLevel" :min="0" :max="10" :step="1" snap label :color="getColorByLevel(calculator.changeMentalLevel)"></q-slider>
								</div>
							</div>

						</div>

						<!--div class="my-5"><q-btn color="primary" icon="check" label="Save" @click="updateCalculator" ></q-btn></div-->
					</div>

				</q-step>
				<q-step :name="2" title="Roadmap" icon="calculate">
					<div class="my-md-2 my-1 text-center">
						<h5 class="my-2">Roadmap</h5>
						<!--div class="my-2 subtitle1">Мы предлагаем разные сценарии будущего и поможем вам добиваться их выполнения</div-->
						<div class="my-2 subtitle1">We offer different scenarios for the future and will help you achieve their fulfillment</div>
						<hr>
						<div class="my-3 text-center">
							<!--q-chip size="lg">
							<q-avatar :color="calculatedResult<=0?'red':'positive'" text-color="white">{{calculatedResultStr}}</q-avatar>
							Health rating
						</q-chip-->
							<q-chip size="lg" icon="star" :color="calculatedResult<=0?'red':'positive'" text-color="white">
								{{calculatedResultStr}}
							</q-chip>

						</div>
					</div>
					<div class="my-3">
						<?php $view->component("med/missions", []) ?>
					</div>

				</q-step>

				<template v-slot:navigation>
					<q-stepper-navigation>
						<q-btn v-if="stepper > 0" flat color="primary" @click="$refs.stepper.previous()" label="Previous"></q-btn>
						<q-btn @click="$refs.stepper.next() || updateCalculator()" color="primary" label="Next" v-if="stepper <2" class="q-ml-sm"></q-btn>
						<q-btn @click="updateCalculator() || goto('lk')" color="primary" label="Save" v-if="stepper==2" class="q-ml-sm"></q-btn>
					</q-stepper-navigation>
				</template>
			</q-stepper>
		</div>




	</div>

</div>

<q-page-scroller position="bottom-right" :scroll-offset="0" :offset="[18, 18]">
	<q-chip v-if="stepper==1" size="lg" icon="star" :color="calculatedResult<=0?'red':'positive'" text-color="white">
		{{calculatedResultStr}}
	</q-chip>
	<q-btn v-if="false" square :color="calculatedResult<=0?'red':'positive'" :label="calculatedResultStrExtra"></q-btn>
</q-page-scroller>

<?php $view->component("footer", ["title" => "", "class" => "menu-footer1"]); ?>