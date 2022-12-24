<q-layout view="lhh LpR lff" class="shadow-2 rounded-borders">
	<!-- Menu Top -->
	<?php
	require $viewConfig->getTemplateIncPath("view_menu_top");
	?>
	<!-- /Menu Top-->

	<!--q-footer class="bg-purple">
		<q-toolbar class="text-center">
			<q-toolbar-title>Цифровой ГАГУ &copy; 2022</q-toolbar-title>
		</q-toolbar>
	</q-footer-->
	<!-- Menu Footer -->
	<?php
	require $viewConfig->getTemplateIncPath("view_menu_footer");
	?>
	<!-- //Menu Footer -->


	<!-- Menu Sidebar Left -->
	<?php
	require $viewConfig->getTemplateIncPath("view_menu_sidebar_left");
	?>

	<!-- Menu Sidebar Right -->
	<?php
	require $viewConfig->getTemplateIncPath("view_menu_sidebar_right");
	?>
	<q-page-container>

		<div class="<?= $viewConfig->getParam("view_page_container_css_class", "") ?>">
			<!-- Page header -->
			<?php
			require $viewConfig->getTemplateIncPath("view_page_header");
			?>
			<!-- /Page Header -->
			<!-- == Page Content == -->
			<?php
			// including page
			if ($viewConfig->checkParam("page")) {
				$pagePath = $viewConfig->getPagePath("page");
				require $pagePath;
			}

			?>
			<!-- /Page Content -->
			<!-- Page Footer -->
			<?php
			require $viewConfig->getTemplateIncPath("view_page_footer");
			?>
			<!-- /Page Footer -->
		</div>
		<q-page-scroller position="bottom">
			<q-btn fab icon="keyboard_arrow_up" color="red" />
		</q-page-scroller>
	</q-page-container>
</q-layout>