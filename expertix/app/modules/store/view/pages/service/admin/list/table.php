<div>
	<div>
		<div class="my-3"><a href="#" @click.prevent="onCreateModal()">Добавить новый курс</a></div>
	</div>
	<div class="my-3">
		<b-table ref="mainTable" class="my-5" striped hover :items="storage.list" :fields="tables.main.fields" striped selectable stacked="sm" hover>
			<template #cell(title)="data"><a href="#" @click.prevent="data.toggleDetails()" class="table-toggle">{{data.value}}</a></template>

			<template #row-details="storage">
				<b-card>
					<?php
					$theme->moduleComponent("store", "product/form-product-edit-vh", [$theme]);
					$theme->startRow();
					$theme->startCol("col-6 col-md-3 text-bottom");
					$theme->button("onDeleteFromTable(storage.item.key)", "Удалить")->endCol();
					$theme->startCol("col-6 col-md-5 text-center text-bottom");
					$theme->html("<a :href=\"''+getItemDetailsLink(storage.item.key)\">Открыть карточку</a>")->endCol();
					$theme->startCol("col-6 col-md-3 text-right text-bottom");
					$theme->button("onUpdate(storage.item)", "Сохранить")->endCol();
					$theme->endRow();
					?>
				</b-card>
			</template>



		</b-table>
	</div>
</div>