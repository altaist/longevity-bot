				<div class="w-100 py-3 p-1">
					<div class="row">
						<div class="col-6 col-md-6 text-left">
							<q-btn label="<?= $params->get("btn_cancel_label", "Отмена") ?>" @click="onDialogClose('<?= $params->get("vue_model", "dialogEdit") ?>')" size="lg" color="<?= $params->get("btn_cancel_color", "orange") ?>" class="<?= $params->get("btn_cancel_class", "") ?>"></q-btn>
						</div>
						<div class="col-6 col-md-6 text-right" v-if="<?= $params->check("btn_ok_action") ?>">
							<q-btn label="<?= $params->get("btn_ok_label", "Сохранить") ?>" @click="<?= $params->get("btn_ok_action") ?>(<?= $params->get("js_obj_name", "formData") ?>) || onDialogClose('<?= $params->get('vue_model', 'dialogEdit') ?>')" size="lg" color="<?= $params->get("btn_ok_color", "orange") ?>" class="<?= $params->get("btn_ok_class", "") ?>"></q-btn>
						</div>
					</div>
				</div>