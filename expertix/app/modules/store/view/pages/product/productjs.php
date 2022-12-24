<?php

?>
<script>


	let vueAppConfig = {
		el: '#jsApp',
		mixins: [projectMixin],
		data: () => {
			return {
				productId: "",
				serviceId: "",

				profile123: {
					user: {
						firstName: "Имя",
						middleName: "",
						lastName: "",
						login: "",
						email: "",
						tel: "",
						socials: "",
					}

				},
				data: {
					form: {

					},
					items: {

					}
				}
			}
		},
		computed: {},
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
			
			
			this.requestApi("catalog", "product_get", {
				key: "kursy-ege-altay"
			}, (result) => {
				console.log("Product api controller result: ", result);
				//this.form = result;
			}, (error) => {
				console.log("Произошла ошибка ", error);
			});



			if (PageController.dataObject) {
				this.product = PageController.dataObject;
				this.data.form = this.product;

				let services = this.product.services;
				if (services && Array.isArray(services)) {
					if (services.length == 1) {
						this.serviceId = services[0].serviceKey;
					}
				}
				console.log("Product services:", services);
			}
		}
	}

	PageController.setVueConfig(vueAppConfig);
</script>