<script>
	let vueAppConfig = {
		el: '#jsApp',
		mixins: [projectMixin, authMixin],
		data: () => {
			return {
				mainMenu: [],
				mainMenuEng: [],
				hubMenuEng: [],
				login: {
					name: "",
					email: "",
					comments: ""
				}
			}
		},
		computed: {},
		methods: {
			validateRequestForm(data) {
				if (!data.firstName) {
					this.showError(this.lang.wrong_name);
					return false;
				}
				if (!data.email) {
					this.showError(this.lang.wrong_email);
					return false;
				}
				return true;

			},
			onSubmitRequest() {
				if (!this.validateRequestForm(this.login)) {
					return false;
				}
				this.requestApiAlertCallback("form", "feedback", this.login, "Thank you! We have received your message and will respond as soon as possible", null, (result) => {
					this.login.screen = "submited";
				});
			},
		},
		created() {
			this.setupProject();
			this.currentLang = "en";
			this.startupFromConfig(this.getObjectId());
			this.mainMenu.push({
				title: "BigData",
				subTitle: "Собираем, анализируем данные, обучаем AI-модели и даем правильные рекомендации"
			});
			this.mainMenu.push({
				title: "NFT & blockchain",
				subTitle: "Цифровой двойник становится цифровым активом, на котором можно зарабатывать",
				color: "orange"
			});
			this.mainMenu.push({
				title: "Social",
				subTitle: "Практики социального взаимодействия повышают эффективность решений",
				color: "secondary"
			});

			this.mainMenuEng.push({
				title: "BigData",
				subTitle: "Using AI to analyze user data and manage a digital companion"
			});
			this.mainMenuEng.push({
				title: "NFT & blockchain",
				subTitle: "Storing user data on the blockchain",
				color: "orange"
			});
			this.mainMenuEng.push({
				title: "Social",
				subTitle: "Using behavioral sociological models and gamification (play@earn model) to increase motivation and involve users in data collection",
				color: "secondary"
			});






		},
	};
	PageController.setVueConfig(vueAppConfig);
</script>