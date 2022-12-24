	<script>
		let projectMixin = {
			mixins: [coreMixin],
			data() {
				return {
					clientLink: null,
				}
			},
			methods: {
				getPageController() {
					// Global object to communicate with PHP 
					return PageController;
				},
				getAppId() {
					return this.getPageController().getAppId();
				},
				getApiPath() {
					return this.getPageController().getApiPath();
				},
				getRequestObjectId() {
					return this.getPageController().getRequestObjectId();
				},
				baseInitApi() {
					return this.baseInitNetwork();
				},
				baseInitNetwork() {
					let endpoints = {
						"test": this.getApiPath() + "test/",
						"catalog": this.getApiPath() + "catalog/",
						"order": this.getApiPath() + "order/",
						"user": this.getApiPath() + "order/",
						"upload": this.getApiPath() + "upload/",
						"company": this.getApiPath() + "company/",

					};
					this.prepareApiClientByEndpoints(endpoints);
				},
				baseInitCart(storageBaseKey, cartId = ".cart") {
					this.debug("baseInitCart", storageBaseKey + cartId);
					this.cartCollection = new CartCollection([], storageBaseKey + cartId);
					this.cartCollection.loadLocal();
					//this.cartCollection.resetCart(this.cartCollection.getCollection());
					this.cart = this.cartCollection;

					//this.orderCollection = new MyCollection([], storageBaseKey + ".orders");
				},
				baseInitApp() {
					this.baseInitNetwork();
					this.baseInitCart(this.getAppId());
				},
			}
		}

		let appCoreMixin = projectMixin;
	</script>