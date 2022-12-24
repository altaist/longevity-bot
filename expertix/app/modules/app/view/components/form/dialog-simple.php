<div class="bg-white p-3">
	<div class="row q-col-gutter-sm">
		<div class="col-10">
			<div class="<?= $params->get('css_title', 'text-h6') ?>"><?= $props->get("title", "") ?></div>
		</div>
		<div class="col-2 text-right">
			<q-btn icon="close" flat round dense v-close-popup></q-btn>
		</div>
		<div class="col-12 scroll" style="max-height: 80vh">
				<div class="w-100">
				<?php
				$componentName = $props->get("component");
				$view->component($componentName, $props);
				?>

				</div>
		</div>
		<div class="col-12"></div>

	</div>



	<q-card v-if="false">
		<q-card-section class="row items-center q-pb-none">
			<div class="<?= $params->get('css_title', 'text-h6') ?>"><?= $props->get("title", "") ?></div>
			<q-space></q-space>
			<q-btn icon="close" flat round dense v-close-popup></q-btn>
		</q-card-section>

		<q-card-section class="scroll" style="max-height: 80vh">
			<?php
			$componentName = $props->get("component");
			$view->component($componentName, $props);
			/*				
				$module = $props->get("module");
				$component = $props->get("component");
				if (!$component) {
					$module = "app";
					$component = "message";
				}
				if ($module) {
					$view->moduleComponent($props->get("module"), $component, $props);
				} else {
					$view->component($component, $props, $props->get("module"));
								}
*/
			?>
		</q-card-section>
	</q-card>
	<q-inner-loading :showing="isLoading">
		<q-spinner-gears size="50px" color="primary"></q-spinner-gears>
	</q-inner-loading>

</div>