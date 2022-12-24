<!-- Menu Top -->
<?php
if ($viewConfig->checkParam("view_menu_top")) {
	$path = $viewConfig->getIncludePath("view_menu_top");
	require $path;
}
?>
<!-- /Menu Top-->
<!-- Page container -->

<div class="<?= $viewConfig->getParam("view_page_container_class", "") ?>">
	<!-- Page header -->
	<?php
	if ($viewConfig->checkParam("view_page_header")) {
		require	$viewConfig->getIncludePath("view_page_header", "page/page_header.php");
	}
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
	if ($viewConfig->checkParam("view_page_footer")) {
		require	$viewConfig->getIncludePath("view_page_footer", "page/page_footer.php");
	}
	?>
	<!-- /Page Footer -->
</div>

<!-- /Page container -->
<!-- Menu Footer -->
<?php
if ($viewConfig->checkParam("view_menu_footer")) {
	$path = $viewConfig->getIncludePath("view_menu_footer");
	require $path;
}
?>
<!-- //Menu Footer -->