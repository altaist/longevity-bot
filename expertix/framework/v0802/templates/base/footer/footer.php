<?php

use Expertix\Core\App\AppContext;
// Inject PHP
$config = AppContext::getConfig();
$app_id = $config->getAppId();
//$pageData = AppContext::getPageData();
//$jsonDataObject = json_encode($pageData->getDataObject());
//$jsonDataCollection = json_encode($pageData->getDataCollection());
?>

<?php
// Include custom code (before all)
require $viewConfig->getTemplateIncPath("view_footer_custom_start");
?>

<script src="js/expertix.js"></script>
<script>
	PageController.APP_ID = "<?= $app_id ?>";
	PageController.path = {
		"site": "<?= $config->getUrl("site") ?>",
		"api": "<?= $config->getUrl("api") ?>",
		"client": "<?= $config->getUrl("client") ?>",
		"base": "<?= $config->getBaseSiteUrl() ?>"
	};
</script>
<?php



// Include framework's libs
require $viewConfig->getTemplateFrameworkPath("view_framework", "none", "footer");

/*
if ($viewConfig->checkParam("view_framework_footer")) {
	require $viewConfig->getIncludePathWithParent("view_framework_footer");
}else{
	if ($viewConfig->checkParam("view_framework")) {
		require __DIR__ . "/../framework/" . $viewConfig->getParam("view_framework") . "_footer.php";
	}
}
*/
?>

<?php
// Include custom code (project libs)
//require $viewConfig->getTemplateIncPath("view_footer_js_libs");
require $viewConfig->prepareIncludePath(PATH_JS . "libs/libs.php");
// PHP inject
require $viewConfig->getTemplateIncPath("view_js_php_inject",  "js/footer_js_php_inject.php");
?>

<?php
// Include Page JS!
if ($viewConfig->checkParam("js")) {
	$path = $viewConfig->getPageJsPath("js");
	require $path;
}
?>

<?php
// Run Js App
require $viewConfig->getTemplateFrameworkPath("view_framework", "none", "run");

/*
if ($viewConfig->checkParam("view_framework_footer_run")) {
	require $viewConfig->getIncludePathWithParent("view_framework_footer_run");
} else {
	if ($viewConfig->checkParam("view_framework")) {
		require __DIR__ . "/../framework/" . $viewConfig->getParam("view_framework") . "_run.php";
	}
}*/

// Include final custom code
if ($viewConfig->checkParam("view_footer_custom_end")) {
	require $viewConfig->getTemplateIncPath("view_footer_custom_end", "");
}

?>