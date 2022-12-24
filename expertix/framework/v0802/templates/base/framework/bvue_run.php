<script>
	PageController.autoVue = false;
	if (PageController.getVueConfig()) {
		var app;

		if (typeof Quasar !== 'undefined') {
			app = Vue.createApp(PageController.getVueConfig());
			app.use(Quasar)
			Quasar.lang.set(Quasar.lang.ru)
			app.mount('#jsApp');
		} else {
			app = new Vue(PageController.getVueConfig());

		}

	}

	function onDocumentReady() {
		if (document.getElementById("jsApp")) {
			document.getElementById("jsApp").classList.remove("invisible");
		}
	}
	window.addEventListener("load", onDocumentReady);
</script>