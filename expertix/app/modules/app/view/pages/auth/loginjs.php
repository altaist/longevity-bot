<script>
	let vueAppConfig = {
		el: '#jsApp',
		mixins: [projectMixin],
		data: () => {
			return {
				loginStep: 0,

				login: {
					login: "",
					password: "",
					password2: "",
					role: 0,
					level: 0,
				}
			}
		},
		computed: {},
		methods: {



			/**
				Сначала пытаемся зарегистрировать нового пользователя. Если найден дубликат - показываем форму подтверждения
				При повторной отправке вызываем этот же метод
				Если установлен параметр confirmCode (пароль или код из email), то запрос рассматривается как подтверждение
			 */
			async userSignUp(callbackBefore) {

				try {
					let login = this.login;
					if (callbackBefore) {
						login = callbackBefore(this.login);
					}

					let user = await this.requestApi("user", "signup_signin", login);;
					this.debug("Api result:", user);
					if (!user || !user.userKey) {
						this.showConfirmLogin(); // Отображаем форму для ввода кода подтверждения
						return Promise.reject("Отображаем форму для ввода кода подтверждения");
					}

					this.hideConfirmLogin();
					this.debug("User from API: ", user);
					this.saveUser(user);
					return user;

				} catch (error) {
					this.alert(error.message);
					return Promise.reject();
				}
			},
			async userSignIn(callbackBefore) {

				try {
					let login = this.login;
					if (callbackBefore) {
						login = callbackBefore(this.login);
					}

					let user = await this.requestApi("user", "signin_code", login);;
					this.debug("Api result:", user);
					if (!user || !user.userKey) {
						this.showConfirmLogin(); // Отображаем форму для ввода кода подтверждения
						return Promise.reject("Отображаем форму для ввода кода подтверждения");
					}

					this.hideConfirmLogin();
					this.debug("User from API: ", user);
					this.saveUser(user);
					return user;

				} catch (error) {
					this.alert(error.message);
					return Promise.reject();
				}
			},

			user_prepareLoginData(_login) {
				let login = _login; // TODO
				if (!login.email) {
					throw new Error("Необходимо указать email");
				}

				if (this.loginStep == 1 && !login.confirmCode) {
					throw new Error("Необходимо указать код подтверждения");
				}


				login.login = login.email;
				return login;
			},
			user_prepareSignUpData(_login) {
				let login = _login; // TODO
				if (!login.name) {
					throw new Error("Необходимо указать ваше имя");
				}
				if (!login.email) {
					throw new Error("Необходимо указать email");
				}

				if (this.loginStep == 1 && !login.confirmCode) {
					throw new Error("Необходимо указать код подтверждения");
				}

				login.login = login.email;
				return login;
			},

			requestConfirmLogin() {
				if (!login.requestKey) {
					throw new Error("Ошибка подтверждения логина - не найден код подтверждения");
				}
				return this.requestApi("user", "login_confirm", this.login);
			},
			async requestLogin2(login) {

				this.requestApi("user", "signup_signin", login, (result) => {
					console.log(result);
					if (result && result.userKey) {
						this.hideConfirmLogin();
						this.debug("User form API: " + result);
						return result;
					}

					this.showConfirmLogin(); // Отображаем форму для ввода кода подтверждения
					return null;

				});

			},


			async saveUser(user) {
				this.user = user;
				//this.debug("saveUser:", this.user);
				return this.user;
			},
			onBtnOrder(){
				this.someAction(this.user);
			},

			async someAction(user) {
				if (!user || !user.userKey) {
					this.alert("Для выполнения операции необходимо зарегистрироваться");
					return;
				}
				let order = {
					products: [
						{productId: 1, quantity:1, price1:100}						
					]
				}

				console.log("Some action started");
				return this.requestApi("order", "order_create", order)
					.then(alert);
			},



			//

			signin() {
				this.requestApi("user", "signin", this.login, (result) => {
					console.log("User api controller result: ", result);
					this.profile.user = result;
				}, (error) => {
					console.log("Произошла ошибка ", error);

				});

			},
			checkLogin(login) {
				if (("" + login.login || "").length < 3) {
					alert("Неверное имя пользователя");
					throw new Error();
				}
				if (!login.password || login.password.length < 6) {
					alert("Пароль должен быть не менее 6 символов");
					return;
				}
				if (login.password != login.password2) {
					alert("Введенные пароли не совпадают");
					return;
				}

			},
			signup() {
				try {
					this.checkLogin(this.login);

				} catch (error) {
					return;
				}
				this.login.email = this.login.login;
				this.login.aff = PageController.aff;
				this.login.productTitle = "Курс 1";
				this.requestApi("user", "signup", this.login, (result) => {
					console.log("User api controller result: ", result);
					this.profile.user = result;
				}, (error) => {
					console.log("Произошла ошибка ", error);

				});
			},
			subscribe() {
				let form = this.profile.user;
				form.login = form.email;
				form.aff = PageController.aff;
				form.productTitle = "Курс 1";
				form.productId = 1;
				form.serviceId = 1;
				form.password = new Date().getMilliseconds();
				form.password2 = form.password;

				try {
					this.checkLogin(form);
				} catch (error) {
					return;
				}

				this.requestApi("user", "subscribe", form, (result) => {
					console.log("User api controller result: ", result);
					this.profile.user = result;
				}, (error) => {
					console.log("Произошла ошибка ", error);

				});
			},
			changeUserData() {
				this.requestApi("user", "edit", this.profile.user, (result) => {
					console.log("User api controller result: ", result);
					this.profile.user = result;
				}, (error) => {
					console.log("Произошла ошибка ", error);
				});
			}

		},
		created() {
			this.setupProject();
			this.setupUser();
		}
	}


	PageController.setVueConfig(vueAppConfig);
</script>