<?php
$params->setIfEmpty("jsObjName", "formData");
$jsObjName = $params->get("jsObjName");
$ctrlTagOptions = 'outlined size="lg"';

if (!$user) {
	return;
}
?>
<div class="my-3">
	<div class="title3 my-3">{{<?= $jsObjName ?>.textTitle}}</div>
	<div class="my-3" v-html="parseMarkdown(<?= $jsObjName ?>.text)"></div>
</div>
<div class="my-5" v-if="timer>timerDelaySec">
	<?php
	$view->moduleComponent("app", "form/actions", $params);
	?>
</div>
<div class="my-5" v-else">
	{{computedTimerString}} / {{timerDelaySec}} sec left
</div>