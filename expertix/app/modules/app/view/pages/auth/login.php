<div class="container">
	{{user}}
	<hr>
	{{login}}
	<h4>Регистрация или вход без пароля</h4>
	<div class="row">
		<div class="col-12 col-md-6 my-1">
			<b-form-group label="Ваше имя" label-for="element_login.name" invalid-feedback="">
				<b-input id="element_login.name" v-model="login.name" size="lg"></b-input>
			</b-form-group>
		</div>
		<div class="col-12 col-md-6 my-1">
			<b-form-group label="Ваш email" label-for="element_login.email" invalid-feedback="">
				<b-input id="element_login.email" v-model="login.email" size="lg"></b-input>
			</b-form-group>
		</div>
		<div class="col-12 col-md-12 my-1" v-if="loginStep==1">
			<div class="row">
				<div class="col-12 col-md-6">
					<b-form-group label="Код подтверждения" label-for="element_login.confirmCode" invalid-feedback="">
						<b-input id="element_login.confirmCode" v-model="login.confirmCode" size="lg"></b-input>
					</b-form-group>
					Введите код подтверждения, который мы выслали вам по электронной почте
				</div>
				<div class="col-12 col-md-6">
				</div>
			</div>
		</div>
		<div class="col-12 col-md-6 my-1">
			<b-form-group label=" " label-for="btn" invalid-feedback="">
				<b-button title="Войти" href="#" @click.prevent="onBtnSignupClick" variant="primary" size="lg" class="mr-auto">
					Войти
				</b-button>
			</b-form-group>
		</div>
	</div>
	<h4>Вход без пароля по коду</h4>
	<div class="row">
		<div class="col-12 col-md-6 my-1">
			<b-form-group label="Ваш email" label-for="element_login.email" invalid-feedback="">
				<b-input id="element_login.email" v-model="login.email" size="lg"></b-input>
			</b-form-group>
		</div>
		<div class="col-12 col-md-6 my-1">
		</div>
		<div class="col-12 col-md-12 my-1" v-if="loginStep==1">
			<div class="row">
				<div class="col-12 col-md-6">
					<b-form-group label="Код подтверждения" label-for="element_login.confirmCode" invalid-feedback="">
						<b-input id="element_login.confirmCode" v-model="login.confirmCode" size="lg"></b-input>
					</b-form-group>
					Введите код подтверждения, который мы выслали вам по электронной почте
				</div>
				<div class="col-12 col-md-6">
				</div>
			</div>
		</div>
		<div class="col-12 col-md-6 my-1">
			<b-form-group label=" " label-for="btn" invalid-feedback="">
				<b-button title="Войти" href="#" @click.prevent="onBtnLoginClick" variant="primary" size="lg" class="mr-auto">
					Войти
				</b-button>
			</b-form-group>
		</div>
	</div>

	<div>
		<div>
			<div class="col-12 col-md-6 my-1">
				<b-form-group label=" " label-for="btn" invalid-feedback="">
					<b-button title="Test order" href="#" @click.prevent="onBtnOrder" variant="primary" size="lg" class="mr-auto">
						Сделать заказ
					</b-button>
				</b-form-group>
			</div>
		</div>
	</div>



	<div class="p-3 my-2" id="signin">
		<h3>Логин</h3>
		<b-input v-model="login.login" title="Email"></b-input><br>
		<b-input v-model="login.password" label="Пароль"></b-input><br>
		<b-button @click="signin" variant="success">Войти</b-button>
	</div>
	<div class="p-3 my-2" id="signup">
		<h3>Регистрация</h3>
		<b-input v-model="login.login" label="Email"></b-input><br>
		<b-input v-model="login.password" label="Пароль"></b-input><br>
		<b-input v-model="login.password2" label="Пароль повторно"></b-input><br>
		<b-button @click="signup()">Регистрация</b-button>

	</div>
	<div class="p-3 my-2" id="profile">
		<h3>Подписка</h3>
		<b-input v-model="profile.user.name" label="Как вас зовут?"></b-input><br>
		<b-input v-model="profile.user.tel" label="Телефон"></b-input><br>
		<b-input v-model="profile.user.email" label="Email"></b-input><br>
		<b-button @click="subscribe">Зарегистрироваться</b-button>
	</div>
	<div class="p-3 my-2" id="profile">
		<h3>Профиль</h3>
		<b-input v-model="profile.user.firstName"></b-input><br>
		<b-input v-model="profile.user.lastName"></b-input><br>
		<b-input v-model="profile.user.email"></b-input><br>
		<b-button @click="changeUserData">Изменить</b-button>
	</div>
</div>