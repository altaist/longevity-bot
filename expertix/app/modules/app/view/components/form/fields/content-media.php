		<div class="col-12 col-md-6 <?= $ctrlClassOptions ?>">
			<div class="row q-col-gutter-sm">
				<div class="col-12 col-md-12 <?= $ctrlClassOptions ?>">
					<q-input v-model="<?= $jsObjName ?>.img" label="Изображение" <?= $ctrlTagOptions ?>>
					</q-input>
				</div>
				<div class="col-12 col-md-12 <?= $ctrlClassOptions ?>">
					<div v-if="<?= $jsObjName ?>.img">
						<div>
							<q-img :src="imgSrc(<?= $jsObjName ?>.img)"></q-img>
						</div>
						<div class="my-2">
							<q-btn label="Удалить" icon="delete" @click="<?= $jsObjType ?>RemoveImg(<?= $jsObjName ?>)"></q-btn>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-12 " v-if="!<?= $jsObjName ?>.img">
					<div class="title4 my-3">Загрузка изображения</div>
					<div class="col-12 col-md-6 my-1">
						<q-uploader url="api/up/" method="post" auto-upload :headers="[{name: 'X-Custom-OBJECT-ID', value: <?= $jsObjName ?>.<?= $jsObjIdField ?>}, {name: 'X-Custom-ACTION', value: 'upload_<?= $jsObjType ?>_img'}]" multiple=false :filter="checkFiles" style="width: 100%" @uploaded="<?= $jsObjType ?>OnUploadImgCompleted" @failed="<?= $jsObjType ?>OnUploadFailed"></q-uploader>
					</div>
				</div>

			</div>
		</div>
		<div class="col-12 col-md-6 <?= $ctrlClassOptions ?>">
			<div class="col-12 col-md-12 <?= $ctrlClassOptions ?>">
				<q-input v-model="<?= $jsObjName ?>.video" label="Видео" <?= $ctrlTagOptions ?>>
				</q-input>
			</div>
			<div class="col-12 col-md-12 <?= $ctrlClassOptions ?>">
			</div>
		</div>