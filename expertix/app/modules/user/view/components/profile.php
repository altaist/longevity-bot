<?php
$params->setIfEmpty("jsObjName", "formData");
$jsObjName = $params->get("jsObjName");
$ctrlTagOptions = 'outlined size="lg"';

if (!$user) {
	return;
}
?>
<div>
	<div class="row q-col-gutter-sm">
		<div class="col-12 col-md-12 <?= "" ?>">
			<div class="title4 my-3">Пользователь</div>
		</div>
		<div class="col-12 col-md-4 <?= "" ?>">
			<q-input v-model="<?= $jsObjName ?>.lastName" label="Фамилия" <?= $ctrlTagOptions ?>>
			</q-input>
		</div>
		<div class="col-12 col-md-4 <?= "" ?>">
			<q-input v-model="<?= $jsObjName ?>.firstName" label="Имя" <?= $ctrlTagOptions ?>>
			</q-input>
		</div>
		<div class="col-12 col-md-4 <?= "" ?>">
			<q-input v-model="<?= $jsObjName ?>.middleName" label="Отчество" <?= $ctrlTagOptions ?>>
			</q-input>
		</div>
		<div class="col-12 col-md-4 <?= "" ?>">
			<q-input v-model="<?= $jsObjName ?>.email" label="Email" <?= $ctrlTagOptions ?>>
			</q-input>
		</div>
		<div class="col-12 col-md-4 <?= "" ?>">
			<q-input v-model="<?= $jsObjName ?>.tel" label="Телефон" <?= $ctrlTagOptions ?>>
			</q-input>
		</div>
		<div class="col-12 col-md-4 <?= "" ?>">
			<q-input v-model="<?= $jsObjName ?>.vk" label="Ссылка VK" <?= $ctrlTagOptions ?>>
			</q-input>
		</div>

		<div class="col-12 col-md-12 <?= "" ?>">
			<q-input v-model="<?= $jsObjName ?>.address" label="Адрес" <?= $ctrlTagOptions ?>>
			</q-input>
		</div>
		<div class="col-12 col-md-12 my-1 ">
			<div class="title4 my-3">Родители</div>
		</div>

		<div class="col-12 col-md-4 my-1 <?= "" ?>">
			<q-input v-model="<?= $jsObjName ?>.parentsLastName" label="Фамилия родителя" <?= $ctrlTagOptions ?>>
			</q-input>
		</div>
		<div class="col-12 col-md-4 my-1 <?= "" ?>">
			<q-input v-model="<?= $jsObjName ?>.parentsFirstName" label="Имя родителя" <?= $ctrlTagOptions ?>>
			</q-input>
		</div>
		<div class="col-12 col-md-4 my-1 <?= "" ?>">
			<q-input v-model="<?= $jsObjName ?>.parentsMiddleName" label="Отчетство родителя" <?= $ctrlTagOptions ?>>
			</q-input>
		</div>
		<div class="col-12 col-md-4 my-1 <?= "" ?>">
			<q-input v-model="<?= $jsObjName ?>.parentsEmail" label="Email родителя" <?= $ctrlTagOptions ?>>
			</q-input>
		</div>
		<div class="col-12 col-md-4 my-1 <?= "" ?>">
			<q-input v-model="<?= $jsObjName ?>.parentsTel" label="Телефон родителя" <?= $ctrlTagOptions ?>>
			</q-input>
		</div>

		<div class="col-12 col-md-12 my-1 <?= "" ?>">
			<div class="title4 my-3">Организация</div>
		</div>

		<div class="col-12 col-md-4 my-1 <?= "" ?>">
			<q-input v-model="<?= $jsObjName ?>.org" label="Школа" <?= $ctrlTagOptions ?>>
			</q-input>
		</div>
		<div class="col-12 col-md-4 my-1 <?= "" ?>">
			<q-input v-model="<?= $jsObjName ?>.department" label="Класс (1-11)" <?= $ctrlTagOptions ?>>
			</q-input>
		</div>
		<?php //
		?>
		<!--div class="col-12 col-md-12 my-1 <?= "" ?>">
			<div class="title4 my-3">Аватар</div>
		</div>
		<div class="col-12 col-md-6 my-1">
			{{<?= $jsObjName ?>.img}}
			<div v-if="<?= $jsObjName ?>.img">
				<div>
					<q-img :src="'image/'+<?= $jsObjName ?>.img"></q-img>
				</div>
				<div class="my-2">
					<q-btn label="Удалить" icon="delete" @click="userRemoveImg(<?= $jsObjName ?>.userId)"></q-btn>
				</div>
			</div>
		</div>

		<div class="col-12 col-md-6 my-1">
			<q-uploader url="api/up/" method="post" :headers="[{name: 'X-Custom-OBJECT-ID', value: <?= $jsObjName ?>.userId}, {name: 'X-Custom-ACTION', value: 'upload_profile_img'}]" multiple=false :filter="checkFiles" style="width: 100%" @uploaded="onUploadCompleted" @failed="onUploadFailed"></q-uploader>
		</div-->
	</div>
	<!--div class="col-12 col-md-12 my-1">
			<q-uploader url="api/up/" method="post" multiple=false :filter="checkFiles" style="max-width: 500px" @uploaded="onUploadCompleted" @failed="onUploadFailed"></q-uploader>
		</div-->
	<?php if (false && $user->isAdmin()) { ?>
		<div class="col-12 col-md-12 my-1 <?= "" ?>">
			<div class="title4 my-3">Привелегии</div>
		</div>
		<div class="col-6 col-md-4 my-1 <?= "" ?>">
			<q-input v-model="<?= $jsObjName ?>.level" label="Level" <?= $ctrlTagOptions ?>>
			</q-input>
		</div>
		<div class="col-6 col-md-4 my-1 <?= "" ?>">
			<q-input v-model="<?= $jsObjName ?>.role" label="Role" <?= $ctrlTagOptions ?>>
			</q-input>
		</div>
		<div class="col-12 col-md-4 my-1">
			<q-btn label="Изменить" @click="userUpdatePriv(<?= $jsObjName ?>)"></q-btn>
		</div>
	<?php } //
	?>
	<div class="col-12 col-md-12 my-1">
	</div>
	<div class="col-12 col-md-12 my-1">
		<div class="my-5">
			<?php
			$view->moduleComponent("app", "form/actions", $params);
			?>
		</div>
	</div>
</div>
</div>