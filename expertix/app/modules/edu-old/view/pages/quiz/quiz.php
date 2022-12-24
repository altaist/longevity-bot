<div v-if="quizSrc && quizSrc.trim()" class="bg-white">

	<div v-if="checkQuizState('intro')">
		<div class="text-center title2 my-5">Итоговое тестирование по дополнительной общеобразовательной программе (ДОП) «Добровольческое (волонтёрское) сопровождение проектов в сфере экотуризма»</div>
		<div class="text-center my-5">
			<b-button title="lang.btn_start" variant="primary" class=" " size="lg" @click.prevent="switchStateToQuiz()">{{lang.btn_start}}</b-button>
		</div>
	</div>
	<div v-if="checkQuizState('results')">
		<div class="my-5">
			<h3>Спасибо за вашу работу!</h3>
			<div class="my-3 text-success" v-if="getStatistic().completed">Тест пройден!</div>
			<div class="my-3 text-danger" v-else>Тест не пройден!</div>
			<div class="my-3">Ответов на вопросы: {{getStatistic().answered}} / {{getStatistic().all}}</div>
			<div class="my-3 text-success">Правильных ответов: {{getStatistic().correct}}</div>
			<div class="my-3 text-danger">Ошибочных ответов: {{getStatistic().wrong}}</div>

			<div class="row my-5">
				<div class="col-12 col-md-4" v-if="getStatistic().completed">
					<b-button variant="warning" class="" size="lg" @click.prevent="onQuizSaveResult(form.item)">{{lang.btn_save}}</b-button>
				</div>
				<div class="col-12 col-md-4">
					<b-button variant="primary" class="" size="lg" @click.prevent="switchStateToQuiz()">{{lang.btn_start_again}}</b-button>
				</div>
			</div>
		</div>
	</div>
	<div v-if="checkQuizState('quiz')">
		<!--h4 class="title2">{{quiz.title}}</h4>
		<div class="mt-2"></div-->
		<div class="my-3" v-for="item in questions">
			<div id="'q'+item.id" class="border shadow round p-3 my-3" v-if="questionVisible(item)">
				<!--h5 :class="'title3 '+questionSectionColor(item)">{{item.title}}</h5-->
				<div class="row my-3">
					<div class="col-12 p-3">
						<div class="title4">{{item.text}}</div>
					</div>
					<div class="col-12" v-if="checkAnswersView(item, 'choice', 'list')">
						<b-list-group>
							<b-list-group-item href="#" @click.prevent="setAnswer(item, answer)" active123="answer.selected" :variant="buttonColor2(answer)" class123="'text-'+buttonColor2(answer)" v-for="answer in item.answers">{{getAnswerText(answer)}}</b-list-group-item>
						</b-list-group>

					</div>
					<div class="col-12" v-if="+checkAnswersView(item, 'sortable', 'list')">
						<b-list-group>
							<draggable v-model="item.answers" group="people">
								<!--div v-for="answer in item.answers" :key="answer.id">{{answer.text}}</div-->

								<b-list-group-item href="#" @click.prevent="setAnswer(item, answer)" active123="answer.selected" :variant="buttonColor2(answer)" :class="'text-'+buttonColor2(answer)" v-for="answer in item.answers">{{getAnswerText(answer)}}</b-list-group-item>

							</draggable>
						</b-list-group>
					</div>
					<div class="col-12" v-if="false">
						<b-form-checkbox-group v-model="item.selected" stacked :options="item.answers" value-field="id" text-field="controlText" :name="'answers'+item.id"></b-form-checkbox-group>
					</div>
					<div class="col-12" v-if="false && checkAnswersView(item,'input')">
						<b-input v-model="item.input"></b-input>
					</div>


					<template v-for="answer in item.answers">
						<div class="col-12 col-lg-6 p-2" v-if="checkAnswersView(item,'choice', 'btn', false)">
							<b-button title="answer.controlText" :variant="buttonColor(answer)" :class=" 'w-100 ' + answer.align " size="lg" @click.prevent="setAnswer(item, answer)">{{getControlAnswerText(item, answer)}}</b-button>
						</div>
						<div class="col-12 col-sm-6 col-md-3 p-2" v-if="checkAnswersView(item,'choice', 'btn', true)">
							<b-button title="answer.controlText" :variant="buttonColor(answer)" :class="'w-100 ' + answer.align" size="lg" @click.prevent="setAnswer(item, answer)">{{getControlAnswerText(item, answer)}}</b-button>
						</div>
						<div class="col-6 col-sm-6 col-md-3 p-2" v-if="checkAnswersView(item,'choice', 'btn', true)">
							<b-button title="answer.controlText" :variant="buttonColor(answer)" :class="'w-100 ' + answer.align" size="lg" @click.prevent="setAnswer(item, answer)">{{getControlAnswerText(item, answer)}}</b-button>
						</div>
					</template>
					<div class="col-12 px-3 py-2" v-for="item in item.inputs" v-if="true">
						<b-input v-model="item.value"></b-input>
					</div>
				</div>
			</div>
		</div>

		<div id="questionsNav" v-show="isShowNavButtons">
			<div class="row px-3">
				<div class="col-12 col-md-6 p-3">
					<b-button title="lang.btn_prev" variant="primary" class=" w-100" size="lg" @click.prevent="onBtnPrev" v-if="showPrevBtn">{{lang.btn_prev}}</b-button>
				</div>
				<div class="col-12 col-md-6 p-3">
					<b-button variant="primary" class="w-100" size="lg" @click.prevent="onBtnNext" v-if="showNextBtn">{{lang.btn_next}}</b-button>
					<b-button variant="warning" class="w-100" size="lg" @click.prevent="switchStateToResults" v-if="!showNextBtn && isLastQuestion">{{lang.btn_results}}</b-button>
				</div>
			</div>
		</div>
		<div v-show="!isShowNavButtons">
			<div class="text-center my-5">
				<div class="my-1">
					<b-button variant="warning" class="" size="lg" @click.prevent="switchStateToResults">{{lang.btn_results}}</b-button>
				</div>
			</div>
		</div>
	</div>


</div>
<div v-else>
	<div class="my-5">Нет активных тестов</div>
</div>