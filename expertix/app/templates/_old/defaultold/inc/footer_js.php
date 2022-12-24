	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script>
		window.jQuery || document.write('<script src="assets/js/vendor/jquery.slim.min.js"><\/script>')
	</script>
	<script src="js/vendor/bootstrap.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
	<script src="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.js"></script>
	<script src="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue-icons.min.js"></script>
	<script src="js/my.js"></script>

	<?php

	require __DIR__ . "/footer_js_php_inject.php";

	//require PATH_VIEW . "vue/vue_mixins_project.php";
	//require PATH_VIEW . "vue/vue_mixins_edu.php";

	if (file_exists($viewConfig->getPageJsPath())) {
		require_once $viewConfig->getPageJsPath();
	}
	
	?>
	
	

	<script>
		PageController.autoVue = false;

		let autoVueAppConfig = PageController.getVueConfig();
		//let autoVueAppConfig = PageController.constructVueApp ? PageController.constructVueApp() : null;
		if (autoVueAppConfig) {
			var app = new Vue(autoVueAppConfig);
		}

		function onDocumentReady() {

			if (document.getElementById("vueApp")) {
				document.getElementById("vueApp").classList.remove("d-none");
			}
			if (document.getElementById("footer")) {
				document.getElementById("footer").classList.remove("d-none");
			}
		}
		window.addEventListener("load", onDocumentReady);
	</script>

	</body>

	</html>