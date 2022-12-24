<div class="my-5" v-if="screen==1">
	<div class="my=5">
		<div class="title2" v-if="profile.data.checkin">Спасибо! Добро пожаловать на мероприятие!</div>
		<div class="title2" v-else>Добро пожаловать на мероприятие! Вы зарегистрированы под именем: {{profile.data.checkin.name}}</div>
		<div class="subtitle">Список участников и заявленных презентаций:</div>
		<div class="my-3">
			<div class="my-3" v-for="item in this.storage.list">
				<div class="card">
					<div class="p-3">
						<div class="row">
							<div class="col-12 col-md-6 p-3">
								<div class="title4">{{item.name}}</div>
								<div class=" my-2" v-if="item.presentationTitle"> Презентация: {{item.presentationTitle}}</div>
							</div>
							<div class="col-12 col-md-6 p-3">
								<div>{{item.org}}</div>
							</div>
						</div>

					</div>

				</div>
				<hr>
			</div>

		</div>

	</div>

	<div class="my-5"><a href="#" @click.prevent="screen=0">Добавить нового участника</a></div>

</div>
<div v-if="screen==0">

	<div class="title2">Регистрация на мероприятии "Стартап-среда"</div>
	<div class="subtitle">Спасибо, что пришли на наше мероприятие! Заполните, пожалуйста, краткую информацию о себе</div>
	<div class="my-5">
		<div class="row">
			<div class="col-12 col-md-6 my-1">
				<b-form-group label="Как вас зовут?" label-for="element_checkin.name" invalid-feedback="">
					<b-input id="element_checkin.name" v-model="checkin.name" size="lg"></b-input>
				</b-form-group>
			</div>
			<div class="col-12 col-md-6 my-1">
				<b-form-group label="Ваша организация" label-for="element_checkin.org" invalid-feedback="">
					<b-input id="element_checkin.org" v-model="checkin.org" size="lg"></b-input>
				</b-form-group>
			</div>


		</div>
	</div>
	<hr>
	<div class="my-5">
		<div class="title2">Для выступающих</div>
		<div class="subtitle">Напоминаем, что лимит времени на одно выступление - 3 минуты + 5 минут вопросы и обсуждения</div>
		<div class="my-5">
			<div class="row">
				<div class="col-12 col-md-12 my-1">
					<b-form-group label="Название презентации" label-for="element_checkin.presentationTitle" invalid-feedback="">
						<b-input id="element_checkin.presentationTitle" v-model="checkin.presentationTitle" size="lg"></b-input>
					</b-form-group>
				</div>
				<div class="col-12 col-md-12 my-1">
					<b-form-group label=" " label-for="btn" invalid-feedback="">
						<b-button title="Отправить" href="#" @click.prevent="onBtnClickCheckin" variant="primary" size="lg" class="mr-auto">
							Отправить
						</b-button>
					</b-form-group>
				</div>
			</div>

		</div>

	</div>

</div>