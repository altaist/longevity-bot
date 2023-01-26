<?php
?>
<q-header reveal class="<?= $params->get("class", "menu-top1") ?>">
	<q-toolbar size="lg">
		<q-btn :href="<?= $params->get("home_href", "home") ?>" flat dense size="lg"  icon="<?= $params->get("home_icon", "arrow_back") ?>"></q-btn>
		<q-toolbar-title><?= $params->get("title") ?></q-toolbar-title>
		<?php if ($params->get("menu_icon")) { ?>
			<q-btn size="lg" <?= ($params->get("menu_href") ? ':href="' . $params->get("menu_href") . '"' : '') ?> @click="<?= $params->get("menu_click", "") ?>" flat round dense :label="<?= $params->get("menu_text", "") ?>" icon="<?= $params->get("menu_icon", "person") ?>"></q-btn>
		<?php } ?>
	</q-toolbar>
</q-header>