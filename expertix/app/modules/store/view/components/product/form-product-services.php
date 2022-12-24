<div id="form_services" class="row">
	<?php
	foreach ($productServices as $key => $service) {
	?>
		<div class="col-sm-12 col-md-6">
			<b-form-group label="<?= $service['title'] ?>" label-for="service<?= $service['serviceId'] ?>" invalid-feedback="">
				<b-radio id="service<?= $service['serviceId'] ?>" v-model="profile.user.service" size="lg">
					</b-input><br>
			</b-form-group>
		</div>
	<?php

	}
	?>

	<div class="col-sm-12 col-md-12">
		<b-button @click="subscribe" variant="success" size="lg">Записаться</b-button>
	</div>
</div>