<?php $view->component("header", ["title" => "Личный кабинет",  "home_href" => "'home'", "class" => "menu-top1"]); ?>
<div class="my-3">
	<q-btn href="lk" label="< Личный кабинет"></q-btn>
</div>

<div class="my-5">
	<div class="my-3">
		<div class="title3 my-3">Результаты измерений</div>
		<hr>
	</div>
	<div class="my-5">
		<q-table :rows="storage.list" flat :columns="tableColumns" row-key="userId" :pagination="{rowsPerPage: 20}" :loading="isLoading">
			<template v-slot:loading>
				<q-inner-loading showing color="primary"></q-inner-loading>
			</template>
		</q-table>
	</div>
</div>

<?php $view->component("footer", ["title" => "", "class" => "menu-footer1"]); ?>