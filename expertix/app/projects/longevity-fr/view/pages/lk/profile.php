	<?php $view->component("header", ["title" => "Longevity Profile",  "home_href" => "'home'", "class" => "bg-deep-orange text-white"]); ?>

	<div class="my-3">
		<div class="text-h6"><a href="lk/" class="text-black">Back</a></div>
	</div>


	<div class="my-3 p-3 border shadow rounded bg-deep-orange text-white">
		<div class="row q-col-gutter-sm justify-between items-center no-wrap">
			<div class="p-3 justify-center border-right">
				<q-avatar>
					<img src="https://cdn.quasar.dev/img/avatar3.jpg">
				</q-avatar>
			</div>
			<div class="p-3 justify-center"><span class="title2">My Longevity Profile</span></div>

		</div>
	</div>
	<!--div class="my-3 p-3 border rouneded text-h6">
		Short page description..
	</div-->
	<div class="mb-3 p-3 row border rounded text-h6 bg-grey-2" style="position:sticky; top:0px; z-index:100;">
		<div class="text-subtitle1">Form completion statistics</div>

		<q-linear-progress size="25px" :value="formProgress" color="deep-orange">
			<div class="absolute-full flex flex-center">
				<q-badge color="white" text-color="accent" :label="formProgressLabel"></q-badge>
			</div>
		</q-linear-progress>

	</div>


	<div class="my-3" v-for="section in profileForm">
		<div class="my-3 p-3 border rounded shadow-sm">
			<div :class="'text-h4 ' + section.cssClass">{{section.title}}</div>
			<hr>
			<div class="my-3">
				<div class="row q-col-gutter-sm">
					<div class="col-12 col-md-4" v-for="item in section.fields">
						<q-input v-model="item.value" :type="item.type || 'text'" :label="item.label" v-if="item.type=='input' || !item.type"></q-input>
						<div v-if="item.type=='options'">
							<div class="trext-subtitle2">{{item.label}}</div>
							<q-option-group v-model="item.value" :options="item.options" :color="section.color" type="toggle"></q-option-group>
						</div>
					</div>

					<div class="col-12 text-right">
						<br>
						<q-btn :color="section.color || 'deep-orange'" icon="check" label="Update" @click="onClick" size="lg"></q-btn>
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