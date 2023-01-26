	<?php $view->component("header", ["title" => "Longevity Profile",  "home_href" => "'home'", "class" => "bg-deep-orange text-white"]); ?>

	<!--div class="my-3">
	<div class="text-h6"><a href="home" class="text-black">Home</a></div>
</div-->


	<div class="mt-2 mb-5">
		<div class="row q-col-gutter-sm">
			<div class="col-6 col-md-6">

			</div>
			<div class="col-6 col-md-6">

			</div>
		</div>
		<div class="row justify-between q-gutter-sm">
			<q-chip color="orange" size="lg" title="Click to edit" dark @click="goto('wizard')" clickable style="max-width: 200px">
				<q-avatar>
					<img src="https://cdn.quasar.dev/img/avatar5.jpg">
				</q-avatar>
				Avatar
			</q-chip>
			<div>
				<q-chip>
					<q-avatar color="red" text-color="white">+50</q-avatar>
					Bonus
				</q-chip>
				<q-chip @click="goto('wizard')" clickable>
					<q-avatar color="orange" text-color="white">{{calculatedResultStr}}</q-avatar>
					Years
				</q-chip>

			</div>
		</div>
	</div>

	<div class="my-5">
		<q-card flat bordered class="bg-secondary text-white">
			<q-card-section>
				<!--div class="title3">Профиль</div-->
				<div class="title3">Profile</div>
			</q-card-section>
			<q-separator inset dark></q-separator>
			<q-card-section>
				<div class="title4">{{user.firstName}}</div>

			</q-card-section>

			<q-card-actions align="between">
				<q-btn href="logout" label="Signout" flat color="white" icon="logout"></q-btn>
				<q-btn @click="showDialogEdit(user)" href123="lk/profile" label="Edit" flat color="white" icon="edit_note"></q-btn>
			</q-card-actions>
		</q-card>
		<div class="row q-col-gutter-sm my-5">
			<div class="col-12 col-md-6">
				<div class="my-3 my-md-0">
					<div class="mb-3 title2">Services</div>
					<hr>
				</div>
				<div>
					<q-btn href="wizard" color="deep-orange" icon="calculate" stack label="Health wizard" class="w100"></q-btn>
				</div>

			</div>
			<div class="col-12 col-md-6">
				<?php $view->component("med/missions_eng", []) ?>
			</div>

		</div>
		<div class="text-center">
			<q-img src="img/med/ekg.png" width="100%">
		</div>
		<div>
			<a href="home">Home page</a>
		</div>


	</div>
	<?php
	$view->componentDialogEdit("user/profile-dialog", "userUpdate", ["title" => "Profile", "btn_ok_label" => "Save", "obj_type" => "user"]);
	$view->componentDialogNew("user/profile-dialog", "", ["title" => "Health calculator", "btn_ok_label" => "Update"]);
	?>
	<?php $view->component("footer", ["title" => "", "class" => "menu-footer1"]); ?>