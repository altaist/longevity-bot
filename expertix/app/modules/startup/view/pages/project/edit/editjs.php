<?php
include __DIR__ . "/../../_jsmixins.php";
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

		},
		methods: {

			checkForm(data) {
				if (!this.storage.item.title) {
					this.alert("Необходимо ввести название проекта");
					return null;
				}
				return data;
			},
			sync onBtnSaveClick() {
				this.checkLogin(this.login)
				.then(login => this.requestLogin(login))
				.then(user => this.updateProject(user))
				.catch(error=>this.showError(error)),
			},
			
			sync checkLogin(login){
				if(!login.name){
					throw new Error("Необходимо указать ваше имя");
				}
				if(!login.email){
					throw new Error("Необходимо указать email");
				}
				return login;
			},
			
			sync requestLogin(login){
				this.requestApi("user", "login", login, (result)=>{
					if(result.userKey){
						return result;
					}else{
						return this.showConfirmLogin(result);
					}
					
				});
				
			},
			
			showConfirmLogin(login){
				if(!login.requestKey){
					throw new Error("Ошибка подтверждения логина - не найден код подтверждения");
				}
				this.login.requestKey = login.requestKey;
				this.loginScreen = 1;
				return null;
			}
			requestConfirmLogin(){
				if(!login.requestKey){
					throw new Error("Ошибка подтверждения логина - не найден код подтверждения");
				}
				return this.requestApi("user", "login_confirm", this.login);
			}
			
			updateProject(user){
				if(!user){
					throw new Error("Для выполнения операции вам необходимо авторизоваться");
				}
				if (this.storage.item.key) {
					this.crudUpdate(this.storage.item, this.checkForm);
				} else {
					this.crudCreate(this.storage.item, this.checkForm, (result) => {
						this.screen = 3;
					});
				}
			}


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
				autoLoad: true,
				autoLoadAsync: true,
				autoLoadChilds: true,
				childType: "project_item",

				tableConfig: this.table
			});

			if (this.getObjectId()) {
				this.requestApi("project", "project_get", {
					key: PageController.objectId
				}, (result) => {
					result.canHelp = false;
					result.helpTypes = this.convertHelpValuesToArr(result);
					this.storage.item = result;
					console.log("Product api controller result: ", result);
				}, (error) => {
					console.log("Произошла ошибка ", error);
				});
			}

		}
	}

	PageController.setVueConfig(vueAppConfig);
</script>