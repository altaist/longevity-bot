				<div class="w-100 py-3 p-1">
					<div class="row">
						<div class="col-6 col-md-6 text-left">
						</div>
						<div class="col-6 col-md-6 text-right" v-if="<?= $params->check("btn_ok_action") ?>">
							<q-btn label="<?= $params->get("btn_ok_label", "Сохранить") ?>" v-close-popup size="lg" color="<?= $params->get("btn_ok_color", "orange") ?>" class="<?= $params->get("btn_ok_class", "") ?>"></q-btn>
						</div>
					</div>
				</div>