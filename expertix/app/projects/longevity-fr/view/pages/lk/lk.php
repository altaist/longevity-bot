<?php $view->component("header", ["title" => "Личный кабинет",  "home_href" => "'home'", "class" => "menu-top1"]); ?>


<div class="mt-2 mb-5">
	<div class="row q-col-gutter-sm">
		<div class="col-6 col-md-6">

		</div>
		<div class="col-6 col-md-6">

		</div>
	</div>
	<div class="row justify-between q-gutter-sm">
		<q-chip color="orange" size="lg" title="Click to edit" dark @click="defaultAction()" clickable style="max-width: 200px">
			<q-avatar>
				<img src="https://cdn.quasar.dev/img/avatar5.jpg">
			</q-avatar>
			Avatar
		</q-chip>
		<div>
			<q-chip>
				<q-avatar color="red" text-color="white">{{user.rating1}}</q-avatar>
				Баллов
			</q-chip>
			<!--q-chip>
				<q-avatar color="orange" text-color="white">+1</q-avatar>
				Years
			</q-chip-->

		</div>
	</div>
</div>

<div class="my-5">
	<q-card flat bordered class="bg-secondary text-white">
		<q-card-section align="between">
			<!--div class="title3">Профиль</div-->
			<div class="row justify-between">
				<div class="title3">Профиль</div>
					<q-btn href="logout" label="Выйти" flat color="white" icon="logout"></q-btn>

			</div>

		</q-card-section>
		<q-separator inset dark></q-separator>
		<q-card-section>
			<div class="title4">{{user.firstName}}</div>

		</q-card-section>

		<q-card-actions align="between">
			<q-btn @click="showDialogEdit(user)" href123="lk/profile" label="Изменить" flat color="white" icon="edit_note"></q-btn>
			<!--q-btn @click="showDialogPwd(user)" label="Пароль" flat color="white" icon="password"></q-btn-->
		</q-card-actions>
	</q-card>
	<div class="row q-col-gutter-sm my-3">
		<div class="my-3 my-md-0">
			<div class="my-3 title2">Энергия</div>
			<q-linear-progress size="25px" :value="energy/100" color="accent">
				<div class="absolute-full flex flex-center">
					<q-badge color="white" text-color="accent" :label="energy"></q-badge>
				</div>
			</q-linear-progress>
			<div class="my-2 text-subtitle1">
				* Энергия тратится на выполнение заданий, для каждого задания - свое значение. Пополняется каждые 8 часов на 25%. Максимальное значние энергии 100, если вы не успели ее израсходовать, энергия теряется.
			</div>
		</div>

		<div class="col-12 col-md-6">
			<?php $view->component("med/missions", []) ?>
		</div>

		<!--div class="col-12 col-md-6">
			<div class="my-3 my-md-0">
				<div class="mb-3 title2">Services</div>
				<hr>
			</div>
			<div>
				<div class="rounded border shadow text-red p-3">
					<div class="row q-gutter-sm justify-between">
						<div> <img src="img/med/heart.png" width="100">
						</div>
						<div class="text-center justify-center">
							<div class="title4">Health Tracker</div>
							<div class="my-3">
								<span @click="defaultAction" class="text-black">Трекер активности и здоровья</span>
						</div>
						</div>
					</div>
				</div>
			</div>

		</div-->
	</div>
	<div class="text-center">
		<q-img src="img/med/ekg.png" width="100%">
	</div>
	<div>
		<a href="home">На главную страницу</a>
	</div>


</div>
<?php
$view->componentDialog("med/activity-dialog-text", "dialogActivity_text", ["title" => "Почитаем", "btn_ok_action" => "activityTextUpdate", "btn_ok_label" => "Завершить", "obj_type" => "activity"]);
$view->componentDialog("med/activity-dialog-video", "dialogActivity_video", ["title" => "Посмотрим", "btn_ok_action" => "activityVideoUpdate", "btn_ok_label" => "Завершить", "obj_type" => "activity"]);
$view->componentDialog("med/activity-dialog-form", "dialogActivity_form", ["title" => "Измерим", "btn_ok_action" => "activityFormUpdate", "btn_ok_label" => "Сохранить", "obj_type" => "activity"]);

$view->componentDialog("user/profile-dialog-pwd", "dialogPwd", ["title" => "Profile", "btn_ok_label" => "Save", "btn_ok_action" => "userUpdatePwd", "obj_type" => "user"]);

$view->componentDialogEdit("user/profile-dialog", "userUpdate", ["title" => "Profile", "btn_ok_label" => "Save", "obj_type" => "user"]);
$view->componentDialogNew("user/profile-dialog", "", ["title" => "Health calculator", "btn_ok_label" => "Update"]);
?>
<?php $view->component("footer", ["title" => "", "class" => "menu-footer1"]); ?>