<?php
include __DIR__ . "/../_jsmixins.php";
?>
<script>
	let vueAppConfig = {
		el: '#jsApp',
		mixins: [projectMixin, crudMixin, moduleMixin],
		data: () => {
			return {
				projectId: "",
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
			item() {
				return this.storage.item;
			}
		},
		methods: {

			checkForm(data) {
				if (!this.form.title) {
					this.alert("Необходимо ввести название проекта");
					return null;
				}
				return data;
			},
			onBtnSaveClick() {
				this.crudCreate(this.form, this.checkForm);
			},


		},
		created() {
			this.setupProject();
			this.setupProfile();
			if (!this.profile.data.projects) {
				this.profile.data.projects = {};
			}


			this.setupCrud("project", {
				api: "project",
				keyField: "projectKey",
				detailsLink: "projects/#KEY",
				childDetailsLink: "projects/#KEY",
				autoLoadPhp: true,
				autoLoadAsync: true,
				crudFilter: {
					type: 0
				},

				autoLoadChilds: true,
				childType: "project_action",

				tableConfig: this.table
			});

			this.autoLoadData((item) => {

				item.canHelp = false;
				item.helpTypes = this.convertHelpValuesToArr(item);
				//console.log("Autoload item result: ", item);
				this.storage.item = item;
			}, (result) => {
				//console.log("Autoload list result: ", result);
				this.storage.list = result.map((item) => {
					item.canHelp = false;
					item.helpTypes = this.convertHelpValuesToArr(item);
					//item.actionComments = "";

					return item;
				});
			});
			return;


			this.requestApi("project", "project_get_list", {
				type: 0
			}, (result) => {
				console.log("Product api controller result: ", result);
				this.storage.list = result.map((item) => {
					item.canHelp = false;
					item.helpTypes = this.convertHelpValuesToArr(item);
					return item;
				});
			}, (error) => {
				console.log("Произошла ошибка ", error);
			});
		}
	}

	PageController.setVueConfig(vueAppConfig);
</script>