<script>
	let vueAppConfig = {
		el: '#jsApp',
		mixins: [projectMixin],
		data: () => {
			return {
				screen: 0,
				checkin: {
					activityIs: 1,
					name: "",
					org: "",
					presentationTitle: ""
				}
			}
		},
		methods: {
			checkForm(data) {
				if (!data.name) {
					this.alert("Необходимо указать ваше имя!");
					return null;
				}
				return data;
			},
			onBtnClickCheckin() {
				if (!this.checkForm(this.checkin)) {
					return;
				}

				let data = this.checkin;
				this.requestApi("project", "project_checkin", data, (result) => {
					this.storage.list = result;
					this.profile.data.checkin = data;
					this.saveLocalProfile();
					this.screen = 1;
				});
			},

			getCheckinList() {
				this.requestApi("project", "project_checkin_get_all", this.checkin, (result) => {
					this.storage.list = result;
				});
			}



		},
		created() {
			this.setupProject();
			this.setupProfile();
			this.getCheckinList();


			if (this.profile.data.checkin) {
				this.screen = 1;
			}
		},
	};
	PageController.setVueConfig(vueAppConfig);
</script>