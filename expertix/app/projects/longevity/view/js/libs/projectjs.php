<?php
$viewConfig->includeJsMixin("core");
$viewConfig->includeJsMixin("app");

$viewConfig->includeJsMixin("auth");
$viewConfig->includeJsMixin("user");
$viewConfig->includeJsMixin("cart");
$viewConfig->includeJsMixin("crud_3");

?>

<script>
	var activityId = 2;
	let projectMixin = {
		mixins: [appMixin, userMixin, authMixin],
		data() {
			return {
				currentLang: 0,
				defaultImg: "img/eco/logo-school.png",
				langs: [{
					update_completed: "Изменения сохранены",
					create_completed: "Информация сохранена",
					delete_completed: "Данные удалены",
					delete_error: "Ошибка в процессе удаления данных",

					delete_product_question: "Вы уверены, что хотите удалить этот курс?",
					delete_meeting_question: "Вы уверены, что хотите удалить это занятие?",
					delete_img_question: "Вы уверены, что хотите удалить изображение?",
					wrong_name: "Нужно ввести имя",
					wrong_email: "Нужно ввести email",
					wrong_pwd: "Вы не ввели пароль или введенные пароли не совпадают. Попробуйте еще раз",

					update_pwd_success: "Пароль успешно изменен",
					update_pwd_error: "Ошибка в процесса изменения пароля",

					email_sent: "Данные отправлены на указанный email",

					user_duplicated: "В системе уже есть пользователь с такой электронной почтой",

				}, {
					update_completed: "Updated successfully",
					create_completed: "Created successfully",
					delete_completed: "Deleted successfully",
					delete_error: "Error deleting data",

					delete_product_question: "Confirm your action, please",
					delete_meeting_question: "Confirm your action, please",
					delete_img_question: "Confirm your action, please",

					wrong_name: "Enter your name",
					wrong_email: "Enter your email",
					wrong_pwd: "Wrong passwords. Please try again",
					update_pwd_success: "Password changed successfully",
					update_pwd_error: "Wrong passwords. Please try again",

					email_sent: "Auth link was successfully sent",
					user_duplicated: "Duplicated email address",

				}],
				energy: 0,
				missions: [],
				missionsEng: [],

				lorem: `Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.`,
				lorem2: `Мы собираем биомедицинские и жизненные данные пользователя, анализируем активности в социальных сетях, собираем иную информацию и даем рекомендации и советы.`,
				lorem3: `Мы разрабатываем цифрового альтер-эго (двойника, аватара, помощника, ассистента, компаньона - выбрать) человека, который будет собирать биомедицинские и жизненные данные пользователя с целью продления его здоровой и качественной жизни. Данные будут собираться с различных носимых устройств, диалога с двойником через чат-бот (на первом этапе), анализа активности в социальных сетях, анализа голоса и лица через смартфон. Задача собирать максимальное количество информации о пользователе, сравнивать ее с "идеальной моделью здоровья" и давать рекомендации. Метриками для измерения будут двигательная активность, сердечный ритм, насыщение крови кислородом, качество сна, биомаркеры биологического возраста, ожидаемая расчетная вероятностная продолжительность жизни, диета, эмоциональное и физическое самооценка пользователя, наличие антител к инфекции и тп. `,

				calculator: {
					age: "",
					gender: "",
					region: "",
					weight: 0,
					length: 0,
					activityLevel: 0,
					socialLevel: 0,
					mentalLevel: 0,
					changeActivityLevel: 10,
					changeSocialLevel: 20,
					changeMentalLevel: 10,
					changeDiet: 50,


					result: 0
				},



				regions: [{
					title: "",
				}],

				// Energy
				dialogActivity_text: false,
				dialogActivity_video: false,
				dialogActivity_form: false,
				dialogPwd: false,

				timerStart: 0,
				timerDelaySec: 20,
				timer: 0

			}
		},
		computed: {
			lang123() {
				return this.langs[this.currentLang];
			},
			userList() {
				return this.storage.list;
			},
			user() {
				return this.storage.item;
			},

			calculatedResult() {
				calc = this.calculator;
				let result = Math.floor(calc.changeActivityLevel * 0.04 + calc.changeSocialLevel * 0.09 + calc.changeMentalLevel * 0.3 + +calc.changeDiet * 0.04);
				return result;
			},
			calculatedResultStr() {
				const result = this.calculatedResult;
				if (!result) return "0";
				return (result > 0 ? '+' : '-') + result;
			},
			calculatedResultStrExtra() {
				const result = this.calculatedResultStr;
				return result + " years";
			},

			computedTimerString() {
				if (!this.timer) return "";
				return this.timer; //(Date.now() - this.timerStart) / 60;
			}


		},
		methods: {
			defaultAction(message = null) {
				this.alert(message || "Coming soon...");
			},

			getUserRoleDescription(user) {

				return "";
			},

			//
			showDialog(id, obj) {
				this.debug("Openning dialog with data: ", obj);
				this.formData = obj;
				this[id] = true;
			},
			showDialogEdit(obj) {
				this.debug("Openning dialog for edit with data: ", obj);
				this.formData = obj;
				this.dialogEdit = true;
			},
			showDialogNew() {
				this.debug("Openning dialog for new: ");
				this.formDataNew = {};
				this.dialogNew = true;
			},
			showDialogPwd() {
				this.debug("Openning pwd dialog: ");
				this.formData = this.user;
				this.dialogPwd = true;
			},

			onDialogClose(dialogId) {
				this.closeDialog(dialogId);
			},

			closeDialog(id) {
				this[id] = false;
			},




			// Users
			showUserEditDialog(user) {
				this.formData = user;
				this.dialogEdit = true;
			},
			showUserAddDialog() {
				this.formDataNew = {};
				this.dialogNew = true;
			},


			userLoad(userId) {
				this.loadStorageItem("product", "user_get", {
					userId
				});
			},
			userLoadAll() {
				this.loadStorageList("user", "user_get_all", {});

			},
			userLoadForProduct(productId) {
				this.loadStorageList("product", "product_get_users", {
					key: productId
				});
			},
			userCreate(user, onSuccess) {
				//if (!this.validateLoginForm(user)) return;
				if (!user.firstName) {
					this.showError(this.lang.wrong_name);
					return;
				}
				if (!user.email) {
					this.showError(this.lang.wrong_email);
					return;
				}

				this.requestApi("user", "user_create", user, (result) => {
					this.alert("User added");
					this.userLoadAll();
					this.dialogNew = false;
				});
			},
			userSubscribe(user) {
				//if (!this.validateLoginForm(user)) return;
				if (!user.firstName) {
					this.showError(this.lang.wrong_name);
					return;
				}
				if (!user.email) {
					this.showError(this.lang.wrong_email);
					return;
				}

				this.requestApi("auth", "signup", user, (result) => {
					this.setUser(user);
					this.subscribe();
				});
			},
			/** Callback after registration */
			onSubscribe(result) {
				//console.log("onSubscribe", result);
				this.requestApi("email", "email_signup", result, () => {}, (error) => {
					console.log(error)
				});
				this.goto("lk");
			},
			userUpdate(user) {
				this.requestApiAlert("user", "user_update", user, this.lang.update_completed);
			},
			userUpdatePwd(user) {
				if (!user.password || user.password2 != user.password) {
					this.alert(this.lang.wrong_pwd);
					return;
				}
				this.requestApiAlertCallback("user", "user_update_pwd", {
					password: user
						.password
				}, this.lang.update_pwd_success, this.lang.update_pwd_error, () => {
					this.closeDialog("dialogPwd");
				});
			},
			userDelete(user) {
				if (!confirm(lang.delete_product_question)) {
					return false;
				}
				const userId = user.userId;
				this.requestApi("user", "user_hide", user, (result) => {
					this.alert(lang.delete_completed);
					this.deleteArrItem(this.userList, userId, "userId");
				});
			},
			userUpdatePriv(user) {
				const userId = user.userId;
				data = {
					userId,
					level: user.level,
					role: user.role
				};
				this.requestApiAlert("user", "user_update_priv", data, this.lang.update_completed, null, null);
			},
			userRemoveImg(userId) {
				if (!confirm(lang.delete_img_question)) {
					return false;
				}

				this.requestApi("user", "user_remove_img", {
					userId: userId
				}, (result) => {
					this.user.img = "";
					this.alert(lang.delete_completed, "");
				});
			},
			onUploadCompleted(info) {
				console.log("Upload completed");
				console.log(info);

				this.uploadedKeys = JSON.parse(info.xhr.response).keys;
				this.user.img = this.uploadedKeys[0];
			},

			onUploadFailed(info) {
				try {
					console.log("Upload failed");
					console.log(info);
					console.log("Result:", JSON.parse(info.xhr.response));
				} catch (error) {}
			},

			//Game
			showMissionActivity(item) {
				if (!item.type) {
					this.alert("Данное задание будет доступно позже", "Подождите немного");
					return;

				}

				const energy = item.energy;
				if (this.energy < energy) {
					this.alert("Вы не можете выполнить это задание, у вас нет необходимого уровня энергии", "Ошибка");
					return;
				}

				this.timerStart = Date.now();
				this.showDialog('dialogActivity_' + (item.type || 'text'), item);
				this.timer = 0;
				this.tick();
			},

			tick() {
				setTimeout(() => {
					this.timer++;
					this.tick();
				}, 1000);
			},


			activityTextUpdate(activity) {
				this.saveActivityResult(activity, "dialogActivity_text");
			},
			activityVideoUpdate(activity) {
				this.saveActivityResult(activity, "dialogActivity_video");
			},
			activityFormUpdate(activity) {
				this.saveActivityResult(activity, "dialogActivity_form");
			},
			saveActivityResult(activity, dialogId) {
				this.requestApi("game", "user_activity_update", activity, (result) => {
					console.log("Update activity result:", result);
					this.setRating(+result.rating1);
					this.setEnergy(+result.energy);
					this.alert("Ваш рейтинг: " + result.rating1 + ". Затрачено энергии: " + activity.energy, "Результат активности");
					this.closeDialog(dialogId);
				});
			},
			updateEnergy(energy) {
				if (this.energy < energy) {
					this.alert("Вы не можете выполнить это задание, у вас нет необходимого уровня энергии");
					return;
				}
				this.requestApi("game", "energy_change", {
					energy
				}, (result) => {
					this.setEnergy(value);
					//					this.alert("Updated energy" + energy);
					this.alert("Затрачено энергии: " + energy, "Результат активности");
				});
			},
			loadEnergy() {
				this.requestApi("game", "energy_get", {}, (value) => {
					this.setEnergy(value);
				}, );
			},
			setEnergy(val) {
				this.energy = val;
			},
			setRating(rating) {
				this.user.rating1 = rating;

			},

			// CRUD
			emptyFunc() {
				console.log("Empty func");
			},
			itemCreate(obj) {
				return (this[this.crud.create] || emptyFunc)(obj);
			},
			itemUpdate(obj) {
				return (this[this.crud.update] || emptyFunc)(obj);
			},
			itemGet(data) {
				return (this[this.crud.get] || emptyFunc)(data);
			},
			itemGetCollection(obj) {
				return (this[this.crud.getCollection] || emptyFunc)(obj);
			},

			setupCrud($config) {
				this.crud = $config;
			},

			// Interface
			alert(message, title = "Message") {
				const d = Quasar.Dialog;
				d.create({
					title,
					message
				});
			},




			setupProject() {
				this.setupApp();
				this.setupUser();
				this.currentLang = 1;


				this.calculator = (this.user.jsonData || {}).calculator || this.calculator;


				this.missions.push({
					title: "Дневник здоровья",
					subTitle: "Измеряйте давление, температуру, уровень сахара",
					type: "form",
					color: "primary",
					icon: "receipt_long",
					rating: 5,
					energy: 5,
					time: 10,
					medData: {
						temperature: 36.6,
						pressure1: 120,
						pressure2: 80,
						glucose: 0,
						saturation: 0
					}
				});
				this.missions.push({
					title: "Читаем",
					subTitle: "Читайте интересные и полезные тексты, получайте баллы за результат",
					type: "text",
					color: "secondary",
					icon: "receipt_long",
					rating: 4,
					energy: 20,
					time: 10,
					textTitle: "Люди стареют с разной скоростью",
					text: `Не секрет, что часто биологический и хронологический возраст не совпадают. Врачи чаще всего опираются именно на календарный возраст пациента, упуская из внимания то, что люди стареют с разной скоростью.

Одни люди спокойно доживают до 100 и не нуждаются в помощь. А другие уже в 60 имеют багаж серьёзных проблем со здоровьем, лишающих самостоятельности.

В новом исследовании ученые сравнили скорость хронологического и биологического старения примерно у 1000 человек, за которыми наблюдали в течение 20 лет. Все они родились в один год. 

Для контроля биологических изменений в организме в возрасте 16, 32, 38 и 45 лет им проводили анализы на 19 биомаркеров, характеризующих функции сердечнососудистой и дыхательной систем, иммунитета, почек, обмена веществ, зубов.

«Старение не происходит внезапно, когда люди достигают 60 лет, оно длится всю жизнь. У нас есть способ измерения того, как быстро человек стареет. Наши данные подчеркивают важность оценивания биологического возраста в середине жизни, когда еще возможна профилактика и не развились тяжелые поражения органов», — сказал Максвелл Эллиотт (Maxwell Elliott) из Университета Дюка, соавтор исследования.

Гипотеза ученых подтвердилась.   

Те, кто старел медленнее всех, за каждый из 20 лет исследования «получали» лишь 0,4 года биологического возраста. Они всегда выглядели моложе, ум оставался острым, сердечно-сосудистая система была в хорошем состоянии, скорость ходьбы была высокой.

А другая часть участников старела быстрее. За каждый год из 20 они биологически «взрослели» на 2,44 года. Выглядели они старше, у них чаще отмечалось ухудшение когнитивных функций. 

Уже в среднем возрасте некоторые показатели у них были как у старых людей. Биомаркеры указывали, что у них есть риск развития старческой астении (дряхлости) в будущем. То есть, существовала вероятность, что они утратят физическую и финансовую самостоятельность.

Вероятно, темп старения может стать адекватным индикатором постепенного ухудшения работы органов и систем. Отслеживание этого показателя позволит оперативно вмешаться  и помочь человеку. `
				});
				this.missions.push({
					title: "Смотрим",
					subTitle: "Смотрите полезные видео, получайте баллы за результат",
					type: "video",
					video: "https://www.youtube.com/embed/DTKCpfodrcE",
					videoTitle: "Китаец покорил подиум",
					color: "orange",
					icon: "receipt_long",
					rating: 2,
					energy: 40,
					time: 10
				});
				this.missions.push({
					title: "Ежедневные прогулки",
					subTitle: "Каждый день проходите не менее 1 км и прокачивайте персонаж",
					type: null,
					color: "accent",
					icon: "directions_run",
					rating: "10",
					energy: 30,
					time: 60
				});
				this.missions.push({
					title: "Логические игры",
					subTitle: "Играйте и прокачивайте персонаж",
					type: null,
					color: "secondary",
					icon: "psychology",
					rating: "4",
					energy: 20,
					time: 75
				});
				this.missions.push({
					title: "Упражнения дома",
					subTitle: "Занимайтесь дома и прокачивайте персонаж",
					type: "null",
					color: "orange",
					icon: "roofing",
					rating: "2",
					energy: 20,
					time: 120
				});

				/*				

								this.missions.push({
									title: "Упражнения в фитнесе",
									subTitle: "Вносите данные каждые 12 часов и прокачивайте персонаж",
									color: "positive",
									icon: "fitness_center",
									rating: "12",
									time: 100
								});
								this.missions.push({
									title: "Дневник здоровья",
									subTitle: "Вносите данные каждые 12 часов и прокачивайте персонаж",
									color: "primary",
									icon: "receipt_long",
									rating: "12",
									time: 10
								});
				*/
				// Eng
				this.missionsEng.push({
					title: "Home activity",
					subTitle: "Home physical activity",
					color: "orange",
					icon: "roofing",
					rating: "12",
					energy: 10,
					time: 120
				});
				this.missionsEng.push({
					title: "Everyday walking",
					subTitle: "Improve your avatar walking every day",
					color: "accent",
					icon: "directions_run",
					rating: "12",
					energy: 5,
					time: 60
				});

				this.missionsEng.push({
					title: "Fitness",
					subTitle: "Regular fitness exercises",
					color: "positive",
					icon: "fitness_center",
					rating: "12",
					energy: 40,

					time: 100
				});
				this.missionsEng.push({
					title: "Brain excercises",
					subTitle: "Logical games and mental gyms",
					color: "secondary",
					icon: "psychology",
					rating: "12",
					energy: 15,
					time: 75
				});
			}
		}
	}
</script>