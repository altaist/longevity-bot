
	<!-- == Page Content == -->
	<?php
	// including page
	if ($view->checkParam("page")) {
		$pagePath = $viewConfig->getPagePath("page");
		require $pagePath;
	}

	?>