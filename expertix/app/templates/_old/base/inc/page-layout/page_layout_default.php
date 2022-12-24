<!-- Menu Top -->
<?php
if ($view->checkParam("menu_top")) {
	$path = $view->getIncludePath("menu_top");
	require $path;
}
?>
<!-- /Menu Top-->
<!-- Page container -->

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

<!-- /Page container -->
<!-- Menu Footer -->
<?php
if ($view->checkParam("menu_footer")) {
	$path = $view->getIncludePath("menu_footer");
	require $path;
}
?>
<!-- //Menu Footer -->