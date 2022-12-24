<?php


// 1. Inject php data
// 2. Include framework's libs
// 3. Include custom
// 4. Include page js
// 5. Inject php-js
?>

<?php

// PHP inject
if ($viewConfig->getParam("view_js_php_inject")) {
//	require $view->getIncludePathWithParent("view_js_php_inject",  "inc/footer_js_php_inject.php");
}
require $view->getIncludePathWithParent("view_js_php_inject",  "inc/footer/footer_js_php_inject.php");

// Include framework's libs
if ($view->checkParam("view_framework")) {
	require __DIR__ . "/../framework/" . $viewConfig->getParam("view_framework") . "_footer.php";
}
?>

<?php
if ($view->checkParam("view_footer_custom")) {
	require $view->getIncludePath("view_footer_custom");
}
?>

<?php
// Include Page JS!
if ($view->checkParam("js")) {
	$path = $viewConfig->getPageJsPath("js");
	require $path;
}
?>

<?php
// Run Js App
?>
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