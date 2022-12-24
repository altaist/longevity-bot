<q-layout view="lhh LpR lff" class="shadow-2 rounded-borders">
	<!-- Menu Top -->
	<?php
	if ($view->checkParam("view_menu_top")) {
		$path = $view->getIncludePath("view_menu_top");
		require $path;
	}
	?>
	<!-- /Menu Top-->

	<!--q-footer class="bg-purple">
		<q-toolbar class="text-center">
			<q-toolbar-title>Цифровой ГАГУ &copy; 2022</q-toolbar-title>
		</q-toolbar>
	</q-footer-->
	<!-- Menu Footer -->
	<?php
	if ($view->checkParam("view_menu_footer")) {
		$path = $view->getIncludePath("view_menu_footer");
		require $path;
	}
	?>
	<!-- //Menu Footer -->


	<!-- Menu Sidebar Left -->
	<?php
	if ($view->checkParam("view_menu_sidebar_left")) {
		$path = $view->getIncludePath("view_menu_sidebar_left");
		require $path;
	}
	?>

	<!-- Menu Sidebar Right -->
	<?php
	if ($view->checkParam("view_menu_sidebar_right")) {
		$path = $view->getIncludePath("view_menu_sidebar_right");
		require $path;
	}
	?>
	<q-page-container>

		<div class="<?= $viewConfig->getParam("view_page_container_class", "") ?>">
			<!-- Page header -->
			<?php
			if ($view->checkParam("view_page_header")) {
				require	$view->getIncludePath("view_page_header", "page/page_header.php");
			}
			?>
			<!-- /Page Header -->
			<!-- == Page Content == -->
			<?php
			// including page
			if ($view->checkParam("page")) {
				$pagePath = $viewConfig->getPagePath("page");
				require $pagePath;
			}

			?>
			<!-- /Page Content -->
			<!-- Page Footer -->
			<?php
			if ($view->checkParam("view_page_footer")) {
				require	$view->getIncludePath("view_page_footer", "page/page_footer.php");
			}
			?>
			<!-- /Page Footer -->
		</div>
		<q-page-scroller position="bottom">
			<q-btn fab icon="keyboard_arrow_up" color="red" />
		</q-page-scroller>
	</q-page-container>
</q-layout>