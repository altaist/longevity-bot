<?php
//include PATH_APP_LIB . "/web/js/mixins/vue_mixins_crud_2.php";
?>
<script>
	<?php
	$productId = $pageData->get("productId");
	if ($productId) {
		echo "PageController.productId = '$productId';";
	}
	?>

	let vueAppConfig = {
		el: '#jsApp',
		mixins: [projectMixin, crudMixin],
		data: () => {
			return {
				productId: "",
				serviceId: "",
			}
		},
		computed: {
			slugComputed() {
				const item = this.storage.item;
				return this.translit(("" + item.title).trim());
			}
		},
		methods: {
			generateSlug() {
				const item = this.storage.item;
				item.slugAuto = this.slugComputed;
				item.slug = item.slugAuto;
			},
			prepareSlug() {
				const item = this.storage.item;
				item.slugAuto = item.slug;
				this.onSlugChanged();
			},

			onTitleChanged(value) {
				const item = this.storage.item;
				if (!item.slug) {
					item.allowAutoSlug = true;
				}

				if (!item.allowAutoSlug) return;

				item.slugAuto = this.slugComputed;
				item.slug = item.slugAuto;
			},
			onSlugChanged() {
				const item = this.storage.item;
				if (!item.slug) {
					item.allowAutoSlug = true;
					return;
				}
				if (item.slug.trim() == this.slugComputed) {
					item.allowAutoSlug = true;
				} else {
					item.allowAutoSlug = false;
				}
			},

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

			// Create
			onCreateForm() {
				let item = this.storage.item;
				this.crudCreate(item, this.beforeCreateCrud, null);
			},


			onCreateEmpty(_title) {
				const title = (_title || this.getNewItemTitle() || "Новый продукт") + 1 * ((this.storage.list.length || 0) + 1);
				let item = this.storage.newItem;
				item.title = title;
				this.storage.newItem.title = title;
				this.crudCreate(item, this.beforeCreateCrud, null);
			},

			onCreateModal() {
				this.storage.newItem = {
					title: "",
					state: null
				};
				this.$root.$emit('bv::show::modal', this.gui.modals.modalNewItem.id);
			},

			onNewItemModalOk(bvModalEvt) {
				bvModalEvt.preventDefault();
				this.handleModalSubmit(this.beforeCreateCrudModal);
			},
			onNewItemModalCancel() {
				this.storage.newItem = {
					state: null
				}
			},
			handleModalSubmit(verifyCallback) {
				let newItem = this.storage.newItem;
				item = verifyCallback(newItem);
				if (!item) {
					return;
				}

				this.crudCreate(item, null, null);

				// Hide the modal manually
				this.$nextTick(() => {
					this.$bvModal.hide('modal-new-item')
				})
			},
			beforeCreateCrud(data) {
				let valid = true;
				valid = this.$refs.formNewItem.checkValidity();
				this.storage.newItem.state = valid;

				if (!valid) {
					return null;
				}

				return data;
			},
			beforeCreateCrudModal(data) {
				let valid = true;
				valid = this.$refs.formNewItem.checkValidity();
				this.storage.newItem.state = valid;

				if (!data.title) {
					valid = false;
				}

				if (!valid) {
					return null;
				}
				return data;
			},
			// Update
			onUpdate() {
				let item = this.getDataItem();
				this.crudUpdate(item, this.beforeUpdateCrud, null);
			},
			beforeUpdateCrud(data) {
				if (!data.title) {
					this.showError("Необходимо заполнить название");
					return null;
				}
				if (!data.slug) {
					data.slug = data.key;
				}
				return data;
			},
			checkFields(data) {


				//data.productKey = data.slug;
				return data;
			},

			// Delete
			onDelete(key) {
				this.crudDelete(key, null, null);
			},

			// For child
			onDeleteChild(key) {
				this.crudDelete(key, null, null);
			},





		},
		created() {
			this.setupProject();
			//this.setupUser();
			this.setupCrud("product", {
				api: "catalog",
				keyField: "productKey",
				detailsLink: "store-admin/product/#KEY",
				autoLoad: true,
				autoLoadAsync: true
			});
			this.autoLoadData();

			if (PageController.crudMode == "details" && PageController.objectId) {
				// Load product services
				this.crudApi("product_get_services", {
					key: PageController.objectId
				}, (result) => {
					this.storage.list = result;
				})
			}

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