<script>
	let vueAppConfig = {
		el: '#jsApp',
		mixins: [projectMixin, crudMixin],
		data: () => {
			return {
				serviceId: "",
				serviceId: "",

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
			this.setupCrud("service", {
				api: "service",
				keyField: "serviceKey",
				detailsLink: "store-admin/service/#KEY",
				childDetailsLink: "store-admin/meeting/#KEY",
				autoLoad: true,
				autoLoadAsync: true,

				autoLoadChilds: true,
				childType: "service_meeting",

				tableConfig: this.table
			});
			this.autoLoadData();


			return;

			this.requestApi("catalog", "service_get", {
				key: "kursy-ege-altay"
			}, (result) => {
				console.log("service api controller result: ", result);
				//this.form = result;
			}, (error) => {
				console.log("Произошла ошибка ", error);
			});




		}
	}

	PageController.setVueConfig(vueAppConfig);
</script>