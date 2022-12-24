<?php
$obj = $params->get("obj", "client");
?>
<div>
	<div class="row q-col-gutter-sm">
		<div class="col-12 col-md-6">
			<q-input v-model="<?= $obj ?>.firstName" label="Имя" outlined size="lg">
			</q-input>
		</div>
		<div class="col-12 col-md-6">
			<q-input v-model="<?= $obj ?>.lastName" label="Фамилия" outlined size="lg">
			</q-input>
		</div>
		<div class="col-12 col-md-6">
			<q-input v-model="<?= $obj ?>.email" label="Email" outlined size="lg">
			</q-input>
		</div>
		<div class="col-12 col-md-6">
			<q-input v-model="<?= $obj ?>.tel" label="Телефон" outlined size="lg">
			</q-input>
		</div>
		<div class="col-12 col-md-6 my-1">
		</div>
		<div class="col-12 col-md-12 my-1 text-center">
			<div class="my-5">
				<q-btn label="<?= $params->get("btn-ok-label", "Сохранить") ?>" @click="<?= $params->get("btn-ok-action", "userCreate($obj)") ?>" size="lg" class="<?= $params->get("btn-ok-class", "button3") ?>"></q-btn>
			</div>
		</div>
	</div>
</div>