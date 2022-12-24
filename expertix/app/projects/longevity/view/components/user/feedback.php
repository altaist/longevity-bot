<?php
	$color = $params->get("color", "primary");
?>

<div class="my-md-5 ">

	<div class="row q-col-gutter-md" v-if="login.screen!='submited'">
		<!--div class="col-12">
			<div class="text-h4 text-<?= $color ?> text-center ">Feedback</div>
			<hr />
		</div-->

		<div class="col-12 col-md-6">
			<q-input v-model="login.firstName" label="Your name" color="<?= $color ?>" outlined size="lg">
			</q-input>
		</div>
		<div class="col-12 col-md-6">
			<q-input v-model="login.email" label="Email" color="<?= $color ?>" outlined size="lg">
			</q-input>
		</div>
		<div class="col-12 col-md-12">
			<q-input v-model="login.comments" label="Message" color="<?= $color ?>" outlined size="lg" type="textarea">
			</q-input>
		</div>

		<div class="col-12 col-md-12 text-center">
			<div class="my-3">
				<q-btn color="<?= $color ?>" icon="check" label="Send request" outline @click="onSubmitRequest" size="lg"></q-btn>

			</div>
		</div>
	</div>
	<div v-else>
		<div class="my-3 text-<?= $color ?> text-h5">Thank you! We have received your message and will respond as soon as possible</div>
	</div>
</div>