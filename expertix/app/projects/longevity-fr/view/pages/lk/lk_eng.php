	<?php $view->component("header", ["title" => "Longevity Profile",  "home_href" => "'home'", "class" => "bg-deep-orange text-white"]); ?>

	<!--div class="my-3">
	<div class="text-h6"><a href="home" class="text-black">Home</a></div>
</div-->


	<div class="my-3 p-3 border shadow rounded bg-deep-orange text-white" @click="goto('lk/profile/')">
		<div class="row q-col-gutter-sm justify-between items-center no-wrap">
			<div class="p-3 justify-center border-right">
				<q-avatar>
					<img src="https://cdn.quasar.dev/img/avatar3.jpg">
				</q-avatar>
			</div>
			<div class="p-3 justify-center"><span class="text-h4">My Longevity Profile</span></div>
			<div class="p-3 justify-center"><span class="title4 ml-3">
					<q-icon name="edit"></q-icon>
				</span>
			</div>
		</div>
	</div>
	<div class="my-3 p-3 border rounede text-h6">
		Welcome to Longevity Hub - place where <i>our slogan</i>! If you already have a registration on our service, you can enter your username and password here
	</div>
	<div class="my-5">
		<div class="text-h4">Longevity Hubs</div>
		<hr>
		<div class="my-3">
			<div class="row q-col-gutter-sm">
				<div class="col-12 col-md-6" v-for="item, index in hubMenuEng">
					<div :class="'row justify-between items-center no-wrap border shadow rounded ' + item.cssClass" @click="goto('lk/hub')">
						<div class="p-3 justify-center">
							<div class="text-h5 my-2">{{item.title}}</div>
							<div class="text-h6">{{item.subTitle}}</div>
						</div>
						<div class="p-3 justify-center border-left">
							<q-avatar>
								<q-icon :name="item.icon || 'print'" size="lg"></q-icon>
							</q-avatar>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="my-5">
		<div class="text-h4">Activities</div>
		<hr>
		<div class="my-3 ">
			<div class="row q-col-gutter-sm">
				<div class="col-12 col-md-6" v-for="item, index in eventsEng">
					<q-img :src="'img/'+(item.img || 'intellect/map.jpg')" spinner-color="deep-orange" spinner-size="42px">
						<div class="absolute-bottom text-subtitle1 ">
							<div class="my-2 text-h5">{{item.title}}</div>
							<div class="row justify-between">
								<div>
									<q-icon flat round name="event" size="sm"></q-icon>
									<q-btn flat>
										{{item.date}}
									</q-btn>

								</div>
								<q-btn color="white" outline @click="goto('lk/activity')">
									Details
								</q-btn>
							</div>
						</div>
					</q-img>
				</div>
			</div>
		</div>
	</div>
	<div class="my-5">
		<div class="title2">About Longevity Hub</div>
		<hr>
		<div class="my-3">{{lorem}}</div>
		<div>{{lorem}}</duv>
		</div>

		<?php
		$view->componentDialogEdit("user/profile-dialog", "userUpdate", ["title" => "Profile", "btn_ok_label" => "Save", "obj_type" => "user"]);
		$view->componentDialogNew("user/profile-dialog", "", ["title" => "Health calculator", "btn_ok_label" => "Update"]);
		?>
		<?php $view->component("footer", ["title" => "", "class" => "menu-footer1"]); ?>