
	<!-- == Page Content == -->
	<?php
	// including page
	if ($viewConfig->checkParam("page")) {
		$pagePath = $viewConfig->getPagePath("page");
		require $pagePath;
	}

	?>