<?php

$jsonDataObject = json_encode($pageData->getDataObject());
$jsonDataCollection = json_encode($pageData->getDataCollection());

?>
<script>
	// Data
	PageController.setRequestObjectId("<?= $pageData->getObjectId() ?>");
	PageController.objectId = "<?= $pageData->getObjectId() ?>";
	PageController.dataObject = <?= empty($jsonDataObject) ? 'null' : $jsonDataObject ?>;
	PageController.dataCollection = <?= empty($jsonDataCollection) ? 'null' : $jsonDataCollection ?>;

	PageController.userData = <?= empty($pageData->getUser()) ? 'null' : json_encode($pageData->getUser()) ?>;

	PageController.adminMode = "<?= empty($adminMode) ? '' : $adminMode ?>";
</script>