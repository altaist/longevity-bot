		<div class="col-12 col-md-6 <?= $ctrlClassOptions ?>">
			<q-input v-model="<?= $jsObjName ?>.title" label="Название" <?= $ctrlTagOptions ?>>
			</q-input>
		</div>
		<div class="col-12 col-md-6 <?= $ctrlClassOptions ?>">
			<q-input v-model="<?= $jsObjName ?>.subTitle" label="Краткое описание" <?= $ctrlTagOptions ?>>
			</q-input>
		</div>
		<div class="col-12 col-md-12 <?= $ctrlClassOptions ?>">
			<q-input v-model="<?= $jsObjName ?>.description" label="Полное описание" <?= $ctrlTagOptions ?> type="textarea">
			</q-input>
		</div>