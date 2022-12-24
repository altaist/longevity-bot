	<q-header reveal class="bg-purple">
		<q-toolbar>
			<q-btn flat @click="onHomeClick" round dense :icon="homeIcon"></q-btn>
			<q-toolbar-title><?= $view->getTitle()?></q-toolbar-title>
			<q-btn flat @click="drawerRight = !drawerRight" round dense icon="more_vert"></q-btn>
		</q-toolbar>
	</q-header>