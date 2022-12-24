<div>
	<div class="title4 mb-2">
		<b-button href="projects/">К списку проектов</b-button>
	</div>
	<div class="my-3">
		<div class="title4">Проект:</div>
		<div class="title2">
			"{{item.title}}"
		</div>
		<div class="subTitle my-3">
			{{item.subTitle}}
		</div>
		<div class="my-3" v-if="canEdit(item)">
			<b-button :href="'project-edit/'+item.key">Редактировать</b-button>
		</div>

		<div class="my-3">
			{{item.description}}
		</div>

		<div class="my-3" v-if="item.siteUrl">Ссылка на сайт: {{item.siteUrl}}</div>
		<div><?php include __DIR__ . " /../_actions.php" ?></div>

	</div>
		<hr>

	<div class="my-4">
		<div class="title3">Отклики на этот проект:</div>

		<div class="my-2">
			<div v-for="item in storage.list">
				<div class="card my-3">
					<div class="card-body">
						<div class="row">
							<div class="col-6">
								{{(item.lastName || "") + (" " +(item.firstName || "")).trim() || "Аноним"}}
							</div>
							<div class="col-6 text-right">
								{{item.created}}
							</div>
						</div>
						<hr>
						<div class="title4 my-2">
							<b-badge variant="primary" v-if="item.fav>0">Добавил в избранное</b-badge>
							<b-badge variant="success" v-if="item.helpMoney>0">Помогу с деньгами</b-badge>
							<b-badge variant="success" v-if="item.helpInfo>0">Помогу продвигать</b-badge>
							<b-badge variant="success" v-if="item.helpEdu>0">Готов научить</b-badge>
						</div>
						<div class="my-2" v-if="item.actionComments"><b>Комментарий</b>:<br>{{item.actionComments}}</div>

					</div>
				</div>
			</div>
		</div>
	</div>

</div>