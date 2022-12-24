<?php

$jsonDataObject =  null;
if ($pageData->getDataObject()) {
	$jsonDataObject = json_encode($pageData->getDataObject()->getArray());
}
$jsonDataCollection = json_encode($pageData->getDataCollection());
//print_r($pageData);
?>
<script>
	// Data
	PageController.APP_ID = "<?= $pageData->getAppId() ?>";
	PageController.setRequestObjectId("<?= $pageData->getObjectId() ?>");
	PageController.isDataAssync = <?= $pageData->get("data_is_assync", 1) ?>;
	PageController.crudMode = "<?= $viewConfig->get("view_crud_mode", "list") ?>";
	PageController.crudFilter = <?= json_encode($viewConfig->get("view_crud_filter", [])) ?>;
	PageController.objectId = "<?= $pageData->getObjectId() ?>";
	PageController.dataObject = <?= empty($jsonDataObject) ? 'null' : $jsonDataObject ?>;
	PageController.dataCollection = <?= empty($jsonDataCollection) ? 'null' : $jsonDataCollection ?>;
	PageController.startupFunc = "<?= $viewConfig->get("js_startup", "") ?>";
	

	PageController.aff = "<?= $pageData->getAffKey() ?>";
	PageController.userData = <?= empty($pageData->getUser()) ? 'null' : json_encode($pageData->getUser()->getArray()) ?>;
	PageController.api = <?= empty($viewConfig->getApiEndpoints()) ? '[]' : json_encode($viewConfig->getApiEndpoints()) ?>;

	//	PageController.adminMode = "<?= empty($adminMode) ? '' : $adminMode ?>";
</script>