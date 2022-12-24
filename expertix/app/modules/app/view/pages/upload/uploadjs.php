<script>
	let vueAppConfig = {
		el: '#jsApp',
		data: () => {
			return {
				uploadedKeys: [],
			}
		},
		methods: {
			onUploadCompleted(info) {
				console.log("Upload completed");
				console.log(info);

				this.uploadedKeys = JSON.parse(info.xhr.response).keys;

			},
			onUploadFailed(info) {
				try {
					console.log("Upload failed");
					console.log(info);
					console.log("Result:", JSON.parse(info.xhr.response));

				} catch (error) {

				}


			},

		},
		created() {
			//this.setupProject();
		},
	};
	PageController.setVueConfig(vueAppConfig);
</script>