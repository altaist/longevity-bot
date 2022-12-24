<script>
	let vueAppConfig = {
		el: '#jsApp',
		mixins: [projectMixin, crudMixin],
		data: () => {
			return {
				meetingId: "",


				table: {
					fields: [{
						key: "title",
						label: "Название"
					}, {
						key: "subTitle",
						label: "Описание"
					}, {
						key: "slug",
						label: "Ссылка"
					}, {
						key: "created",
						label: "Дата"
					}],
					filter: {}     
				}
			}
		},
		computed: {

		},
		methods: {

		},
		created() {
			this.setupProject();
			//this.setupUser();
			this.setupCrud("meeting", {
				api: "meeting",
				keyField: "meetingKey",
				detailsLink: "store-admin/meeting/#KEY",
				childDetailsLink: "store-admin/activity/#KEY",
				autoLoad: true,
				autoLoadAsync: true,

				autoLoadChilds: true,
				childType: "meeting_activity",

				tableConfig: this.table
			});
			this.autoLoadData();


			return;

			this.requestApi("catalog", "meeting_get", {
				key: "kursy-ege-altay"
			}, (result) => {
				console.log("meeting api controller result: ", result);
				//this.form = result;
			}, (error) => {
				console.log("Произошла ошибка ", error);
			});




		}
	}

	PageController.setVueConfig(vueAppConfig);
</script>