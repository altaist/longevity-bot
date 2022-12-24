<div>
	<div class="my-3">
		<div class="title2">Список проектов</div>
		<hr>
	</div>
	<div class="my-3">
		<div class="row">
			<div class="col-12 col-md-6 my-1">
				<b-form-group label="Выбрать:" label-size="lg" v-slot="{ ariaDescribedby }">
					<b-form-radio-group id="form-project-types" v-model="table.filter.projectType" :options="table.filter.filterProjectTypes" :aria-describedby="ariaDescribedby" button-variant="outline-primary" name="projectTypes" buttons></b-form-radio-group>
				</b-form-group>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12 col-md-6 my-1" v-for="item in filteredList">
			<?php include __DIR__ . " /../_item.php" ?>
		</div>
	</div>
	<div class="my-3">
		<div class="row">

			<div class="col-12 col-md-6 p-3">
				<b-button title="Новый проект" href="project-edit" variant="info" size="lg" class="mr-auto">
					Новый проект
				</b-button>
			</div>
		</div>
	</div>

</div>