		<q-card flat bordered class="bg-color2 text-white">
			<q-card-section>
				<!--div class="title3">Профиль</div-->
				<div class="title3">{{getUserFio(user)}}</div>
			</q-card-section>
			<q-separator inset dark></q-separator>
			<q-card-section>
				<div class="title4">{{getUserRoleDescription(user)}}</div>

			</q-card-section>

			<q-card-actions align="between">
				<q-btn href="logout" label="Выйти" flat color="white" icon="logout"></q-btn>
				<q-btn @click="showDialogEdit(user)" href123="lk/profile" label="Редактировать" flat color="white" icon="edit_note"></q-btn>
			</q-card-actions>
		</q-card>
		