<script>
	<?php
	$productId = $pageData->get("productId");
	if($productId){
		echo "PageController.productId = '$productId';";
	}
	?>
	
	let vueAppConfig = {
		el: '#jsApp',
		mixins: [projectMixin],
		data: () => {
			return {
				profile: {
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
				form: {

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
				form.productId = PageController.productId;
				form.serviceId = PageController.serviceId;
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
			this.baseInitApi();
			this.requestApi("catalog", "product_get", {
				key: "kursy-ege-altay"
			}, (result) => {
				console.log("Product api controller result: ", result);
				//this.form = result;
			}, (error) => {
				console.log("Произошла ошибка ", error);
			});
			
			this.profile.user = PageController.userData;
		}
	}


	PageController.setVueConfig(vueAppConfig);
</script>