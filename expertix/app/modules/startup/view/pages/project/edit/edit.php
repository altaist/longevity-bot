<div>
	<div class="" v-if="screen==1">
		<div id="form_subscribe" class="row">
			<div class="col-12 col-md-6">
				<b-form-group label="Название" label-for="data.item.title" invalid-feedback="">
					<b-input id="data.item.title" v-model="data.item.title" size="lg"></b-input><br>
				</b-form-group>
			</div>

			<div class="col-sm-12 col-md-6">
				<b-form-group label="Ваше имя" label-for="firstName" invalid-feedback="">
					<b-input id="firstName" v-model="profile.user.firstName" size="lg"></b-input><br>
				</b-form-group>
			</div>
			<div class="col-sm-12 col-md-6">
				<b-form-group label="Email" label-for="email" invalid-feedback="">
					<b-input id="email" v-model="profile.user.email" size="lg"></b-input><br>
				</b-form-group>
			</div>
			<div class="col-sm-12 col-md-6">
				<b-form-group label="Телефон" label-for="tel" invalid-feedback="">
					<b-input id="tel" v-model="profile.user.tel" size="lg"></b-input><br>
				</b-form-group>
			</div>
			<div class="col-sm-12 col-md-6">
				<b-form-group label="Школа" label-for="school" invalid-feedback="">
					<b-input id="school" v-model="profile.user.school" size="lg"></b-input><br>
				</b-form-group>
			</div>
			<div class="col-sm-12 col-md-12">
				<b-button @click="onClickCrud" variant="success" size="lg">Записаться</b-button>
			</div>
		</div>
	</div>
	<div id="form_project" class="" v-if="screen==2">
		<div class="title2 my-3">Редактор проекта</div>
		<div class="row">
			<div class="col-12 col-md-12 my-1">
				<b-form-group label="Название проекта" label-size="lg" label-for="element_form.item.title" invalid-feedback="">
					<b-input id="element_form.item.title" v-model="form.item.title" size="lg" rows="2"></b-input>
				</b-form-group>
			</div>

			<div class="col-12 col-md-12 my-1">
				<b-form-group label="Краткое описание" label-size="lg" label-for="element_form.item.subTitle" invalid-feedback="">
					<b-textarea id="element_form.item.subTitle" v-model="form.item.subTitle" size="lg" rows="2"></b-textarea>
				</b-form-group>
			</div>
			<div class="col-12 col-md-6 my-1">
				<b-form-group label="Статус проекта" label-size="lg" v-slot="{ ariaDescribedby }">
					<b-form-radio-group id="form-project-types" v-model="form.item.type" :options="projectTypes" :aria-describedby="ariaDescribedby" button-variant="outline-primary" size="lg" name="projectTypes" buttons></b-form-radio-group>
					<div class="my-1">Выберите ПРОЕКТ, если у вас уже есть прототип или БИЗНЕС, если уже были первые продажи</div>
				</b-form-group>
			</div>
			<div class="col-12 col-md-6 my-1">
				<b-form-group label="Какая помощь нужна" label-size="lg" v-slot="{ ariaDescribedby }">
					<b-form-checkbox-group id="form-project-types" v-model="form.item.supportTypes" :options="supportTypes" :aria-describedby="ariaDescribedby" button-variant="outline-success" size="lg" name="supportTypes" buttons></b-form-checkbox-group>
				</b-form-group>
			</div>

			<div class="col-12 col-md-6 my-1">
				<b-form-group label="Ссылка на сайт" label-size="lg" label-for="element_form.item.siteUrl" invalid-feedback="">
					<b-input id="element_form.item.siteUrl" v-model="form.item.siteUrl" type="url" size="lg"></b-input>
				</b-form-group>
			</div>
			<div class="col-12 col-md-6 my-1">
				<b-form-group label="Ссылка на презентацию" label-size="lg" label-for="element_form.item.presentation" invalid-feedback="">
					<b-input id="element_form.item.presentation" v-model="form.item.presentation" type="url" size="lg"></b-input>
				</b-form-group>
			</div>
			<div class="col-12 col-md-6 my-1">
				<b-form-group label="Изображение" label-size="lg" label-for="element_form.item.img" invalid-feedback="">
					<b-input id="element_form.item.img" v-model="form.item.img" size="lg" type="url"></b-input>
				</b-form-group>
			</div>
			<div class="col-12 col-md-6 my-1">
				<b-form-group label="Видео" label-size="lg" label-for="element_form.item.video" invalid-feedback="">
					<b-input id="element_form.item.video" v-model="form.item.video" size="lg" type="url"></b-input>
				</b-form-group>
			</div>
			<div class="col-12 col-md-12 my-1">
				<b-form-group label="Подробное описание" label-size="lg" label-for="element_form.item.description" invalid-feedback="">
					<b-textarea id="element_form.item.description" v-model="form.item.description" size="lg" rows="2"></b-textarea>
				</b-form-group>
			</div>
			<div class="col-12 col-md-6 my-1">
				<b-form-group label="Как вас зовут?" label-for="element_login.name" invalid-feedback="">
					<b-input id="element_login.name" v-model="login.name" size="lg"></b-input>
				</b-form-group>
			</div>
			<div class="col-12 col-md-6 my-1">
				<b-form-group label="Email" label-for="element_login.email" invalid-feedback="">
					<b-input id="element_login.email" v-model="login.email" size="lg"></b-input>
				</b-form-group>
			</div>
		</div>
		<div class="row" vif123="profile.user && profile.user.userId">
			<div class="col-12 col-md-6 my-1">&nbsp;
			</div>
			<div class="col-12 col-md-6 my-1 text-right">
				<b-form-group label=" " label-for="btn" invalid-feedback="">
					<b-button title="Сохранить" href="#" @click.prevent="onBtnSaveClick" variant="primary" size="lg" class="mr-auto">
						Сохранить
					</b-button>
				</b-form-group>
			</div>
		</div>

	</div>
	<div id="create_result" class="my-3" v-if="screen==3">
		<div class="title3">Спасибо, данные сохранены!</div>
		<div class="title4 my-2">После проверки администратором новый проект будет опубликован в системе</div>
		<div class="my-5">
			<div class="row">
				<div class="col-12 col-md-6 p-3">
					<a href="projects">Вернуться к списку проектов</a>
				</div>
				<div class="col-12 col-md-6 p-3 text-right">
					<b-button title="Новый проект" href="project-edit" variant="outline-info" class="mr-auto">
						Новый проект
					</b-button>
				</div>
			</div>
		</div>
	</div>
</div>