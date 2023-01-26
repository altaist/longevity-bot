<script>
	let vueThis = null;
	let vueAppConfig = {
		el: '#jsApp',
		mixins: [projectMixin, authMixin],
		data: () => {
			return {
				tableColumns: [{
						label: 'Дата',
						field: row => {
							if(!row.created) return "";
							//return vueThis.formatDate(row.created);
							return row.created;
						},
						sortable: true
					},
					{
						label: 'Температура',
						field: "temperature",
						sortable: true

					},
					{
						label: 'Давление',
						field: row=>{
							return row.pressure1 + " x " + row.pressure2
						}
					},
					{
						label: 'Глюкоза',
						field: "glucose",
						sortable: true
					},
					{
						label: 'Сатурация',
						field: "saturation",
						sortable: true
					}
				]
			}
		},
		computed: {},
		methods: {
			loadData() {
				this.loadStorageList("game", "user_report", {});
			}

		},
		created() {
			vueThis = this;
			this.setupProject();
			//this.startupFromConfig(this.getObjectId());
			this.loadData();

		},
	};
	PageController.setVueConfig(vueAppConfig);
</script>