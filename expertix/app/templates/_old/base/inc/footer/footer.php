<?php

use Expertix\Core\App\AppContext;
// Inject PHP
$config = AppContext::getConfig();
$app_id = $config->getAppId();
//$pageData = AppContext::getPageData();
//$jsonDataObject = json_encode($pageData->getDataObject());
//$jsonDataCollection = json_encode($pageData->getDataCollection());
?>
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


if ($view->checkParam("view_js_simple")) {
	require __DIR__ . "/footer_simple.php";
} else {
	require __DIR__ . "/footer_app.php";
}
