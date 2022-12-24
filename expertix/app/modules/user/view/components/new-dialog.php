	<q-dialog v-model="dialogNew" persistent full-width transition-show="scale" transition-hide="scale">
		<div class="" style="z-index:0">
			<q-card>
				<q-card-section class="row items-center q-pb-none">
					<div class="title2">Профиль</div>
					<q-space></q-space>
					<q-btn icon="close" flat round dense v-close-popup></q-btn>
				</q-card-section>

				<q-card-section>
					<?php $view->moduleComponent("user", "new", $props) ?>
				</q-card-section>
			</q-card>
		</div>
	</q-dialog>