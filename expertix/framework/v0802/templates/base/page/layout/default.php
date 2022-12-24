<!-- Menu Top -->
<?php
require $viewConfig->getTemplateIncPath("view_menu_top", "view_menu_top", "menu");
?>
<!-- /Menu Top-->
<!-- Page container -->

<div class="<?= $viewConfig->getParam("view_page_container_class", "container") ?>">
	<!-- Page header -->
	<?php
	require $viewConfig->getTemplateIncPath("view_page_header", "");
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
	require $viewConfig->getTemplateIncPath("view_page_footer", "");
	?>
	<!-- /Page Footer -->
</div>

<!-- /Page container -->
<!-- Menu Footer -->
<?php
require $viewConfig->getTemplateIncPath("view_menu_footer", "view_menu_footer", "menu");

?>
<!-- //Menu Footer -->