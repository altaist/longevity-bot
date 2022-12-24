	<q-layout view="lHh lpr lFf" container class="bg-white">
		<q-header elevated class="<?= $params->get("header-bg-color", "bg-deep-orange") ?>">
			<q-toolbar>
				<!--q-btn flat round dense icon="menu" class="q-mr-sm"></q-btn-->
				<q-toolbar-title><?= $props->get("title", "") ?></q-toolbar-title>

				<q-btn icon="close" flat round dense v-close-popup></q-btn>
			</q-toolbar>
		</q-header>

		<?php if (!$props->get("no_actions")) { ?>
			<q-footer class="bg-white">
				<q-toolbar class="w-100">
					<?php $view->component($props->get("actions", "@app/form/actions"), $props) ?>
				</q-toolbar>
			</q-footer>
		<?php } ?>

		<q-page-container>
			<q-page class="q-pa-md">
				<?php
				$view->component($props->get("component"), $props);
				?>
				<q-inner-loading :showing="isLoading">
					<q-spinner-gears size="50px" color="primary"></q-spinner-gears>
				</q-inner-loading>
			</q-page>
		</q-page-container>

	</q-layout>