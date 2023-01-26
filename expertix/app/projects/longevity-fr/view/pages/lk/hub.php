	<?php $view->component("header", ["title" => "Longevity Profile",  "home_href" => "'home'", "class" => "bg-deep-orange text-white"]); ?>

	<div class="my-3">
		<div class="text-h6"><a href="lk/" class="text-black">Back</a></div>
	</div>


	<div class="my-3 p-3 border shadow rounded bg-deep-orange text-white">
		<div class="row q-col-gutter-sm justify-between items-center no-wrap">
			<div class="p-3 justify-center border-right">
				<q-icon name="hub" size="md"></q-icon>
			</div>
			<div class="p-3 justify-center"><span class="title2">Hub Template</span></div>

		</div>
	</div>



	<div class="my-3" v-for="section in hubSections">
		<div class="text-h4">{{section.title}}</div>
		<hr>

		<div class="my-3">
			<div class="row q-col-gutter-sm">
				<div class="col-12 col-md-4" v-for="index in 5">
					<div :class="'p-3 border rounded shadow-sm'+section.cssClass">
						<div :class="'text-h5 ' + section.cssClassTitle">{{section.key}}{{index}}</div>
						<div>Small, but very important description</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<?php
	$view->componentDialogEdit("user/profile-dialog", "userUpdate", ["title" => "Profile", "btn_ok_label" => "Save", "obj_type" => "user"]);
	$view->componentDialogNew("user/profile-dialog", "", ["title" => "Health calculator", "btn_ok_label" => "Update"]);
	?>
	<?php $view->component("footer", ["title" => "", "class" => "menu-footer1"]); ?>