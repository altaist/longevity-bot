<?php require __DIR__ . "/inc/header.php"; ?>
<?php require __DIR__ . "/inc/header_page.php"; ?>

<?php

// Include routed page
if (file_exists($viewConfig->getPagePath())) {
	require_once $viewConfig->getPagePath();
}

?>

<?php require __DIR__ . "/inc/footer_page.php"; ?>
<?php require __DIR__ . "/inc/footer_js.php"; ?>