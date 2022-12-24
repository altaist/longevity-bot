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