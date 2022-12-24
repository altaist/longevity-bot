<script>
	let vueAppConfig = {
		el: '#jsApp',
		mixins: [projectMixin, crudMixin],
		data: () => {
			return {
				productId: "",
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


			checkLogin(login) {
				if (("" + login.login || "").length < 3) {
					throw new Error("Неверный email");
				}
				if (("" + login.firstName || "").length < 3) {
					throw new Error("Неверное имя пользователя");
				}
			},
			subscribe() {
				let form = this.profile.user;
				form.login = form.email;
				form.aff = PageController.aff;
				form.productTitle = "Курс 1";
				form.productId = this.productId;
				form.serviceId = this.serviceId;
				form.password = new Date().getMilliseconds();
				form.password2 = form.password;

				try {
					this.checkLogin(form);
				} catch (error) {
					alert(error.message);
					return;
				}

				this.requestApi("user", "subscribe", form, (result) => {
					console.log("User api controller result: ", result);
					this.profile.user = result;
				}, (error) => {
					console.log("Произошла ошибка ", error);

				});
			},





		},
		created() {
			this.setupProject();
			//this.setupUser();
			this.setupCrud("product", {
				api: "catalog",
				keyField: "productKey",
				detailsLink: "store-admin/product/#KEY",
				childDetailsLink: "store-admin/service/#KEY",
				autoLoad: true,
				autoLoadAsync: true,

				autoLoadChilds: true,
				childType: "product_service",

				tableConfig: this.table
			});
			this.autoLoadData();


			return;

			this.requestApi("catalog", "product_get", {
				key: "kursy-ege-altay"
			}, (result) => {
				console.log("Product api controller result: ", result);
				//this.form = result;
			}, (error) => {
				console.log("Произошла ошибка ", error);
			});




		}
	}

	PageController.setVueConfig(vueAppConfig);
</script>