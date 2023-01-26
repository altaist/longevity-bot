<script>
	let vueAppConfig = {
		el: '#jsApp',
		mixins: [projectMixin, authMixin],
		data: () => {
			return {

			}
		},
		computed: {


		},
		methods: {

			getColorByLevel(level) {
				if (level < 10) {
					return "deep-orange";
				} else if (level < 20) {
					return "orange";
				} else if (level < 50) {
					return "secondary";
				} else if (level < 70) {
					return "primary";
				} else if (level <= 100) {
					return "positive";
				}
			},

			updateCalculator() {
				const user = this.user;
				const jsonData = user.jsonData;
				if (!jsonData) {
					user.jsonData = {};
				}
				if (!user.jsonData.calculator) {
					user.jsonData.calculator = this.calculator;
				}

				this.requestApi("user", "user_update_extra", user, () => {}, () => {
					alert("Error occured while saving data")
				});
			}
		},
		created() {
			this.setupProject();

			this.startupFromConfig(this.getObjectId());
		},
	};
	PageController.setVueConfig(vueAppConfig);
</script>