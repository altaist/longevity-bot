<script>
	PageController.autoVue = false;
	if (PageController.getVueConfig()) {
		var app;

		if (typeof Quasar !== 'undefined') {
			app = Vue.createApp(PageController.getVueConfig());
			app.use(Quasar)
			Quasar.lang.set(Quasar.lang.ru)
			PageController.regComponents(app);

			app.mount('#jsApp');
		} else {
			app = new Vue(PageController.getVueConfig());
			PageController.regComponents(app);
		}



	}

	function onDocumentReady() {
		if (document.getElementById("jsApp")) {
			document.getElementById("jsApp").classList.remove("invisible");
		}
	}
	window.addEventListener("load", onDocumentReady);
</script>