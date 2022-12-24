<?php
if ($view->checkParam("view_footer_custom")) {
	require $view->getIncludePath("view_footer_custom");
}
?>

<?php
// Include Page JS!
if ($view->checkParam("js")) {
	$path = $viewConfig->getPageJsPath("js");
	require $path;
}
?>