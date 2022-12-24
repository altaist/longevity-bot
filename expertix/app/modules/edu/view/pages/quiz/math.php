<?php
?>


<div class="my-3">

	<b-tabs @input="">

		<b-tab title="Редактор" vif="checkUserRole(1)" title-link-class="text-danger">
			<div class="my-3">
				<b-form-textarea id="textarea" v-model="srcText" @input="updateQuiz" placeholder="" rows="5" max-rows="30"></b-form-textarea>
			</div>
			<!--div>
				<b-button @click="onBtnParse" title="Парсинг">Обработать</b-button>
			</div-->
			<div class="my-3">
				<b-form-checkbox id="checkbox-1" v-model="config.showRightAnswer" size="lg">Показывать правильные ответы</b-form-checkbox>
			</div>
			<div class="my-3">

			</div>

		</b-tab>
		<b-tab title="Тест" vif="checkUserRole(1)" title-link-class="text-danger">
			<div class="my-3" v-if="config.showRightAnswer && computedStat.all>0">
				<div class="card">
					<div class="row p-3">
						<div class="col-12 col-md-3">
							<span class="subTitle">Вопросов: </span><span class="subTitle">{{computedStat.all}}</span>
						</div>
						<div class="col-12 col-md-3">
							<span class="subTitle">Ответов: </span><span class="subTitle">{{computedStat.answered}}</span>
						</div>
						<div class="col-12 col-md-3">
							<span class="subTitle">Правильно: </span><span class="subTitle">{{computedStat.ok}}</span>
						</div>
						<div class="col-12 col-md-3" v-if="computedStat.completed">
							<span class="subTitle text-success">Завершено</span>
						</div>
					</div>
				</div>
			</div>
			<div class="my-3 p-3">
				<div v-for="item in taskList">
					<div :class="'row '">
						<div class="col-8 col-md-6 p-1">
							<span :class="'title4 '+ getResultCssClass(item)">{{item.q}}</span>
						</div>
						<div class="col-4 col-md-2 p-1 text-right">
							<b-input v-model="item.r" @input="checkAnswer(item)" size="lg"></b-input>
						</div>
					</div>
				</div>
			</div>

		</b-tab>

	</b-tabs>
</div>