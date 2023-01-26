<?php
$viewConfig->setTemplatePath(__DIR__ . "/");
$viewConfig->setParentTemplatePath(PATH_BASE_TEMPLATE);

$viewConfig->setIfEmpty("view_header_custom", "header/header_custom.php");

$viewConfig->setIfEmpty("view_footer_custom_start", "footer/footer_custom_start.php");
$viewConfig->setIfEmpty("view_footer_custom_end", "footer/footer_custom_end.php");
//$viewConfig->setIfEmpty("view_footer_js_libs", PATH_JS . "/libs/libs.php");


$viewConfig->setIfEmpty("view_menu_top", "menu_top.php");
$viewConfig->setIfEmpty("view_menu_sidebar_left", "menu_sidebar_left.php");
$viewConfig->setIfEmpty("view_menu_sidebar_right", "menu_sidebar_right.php");
$viewConfig->setIfEmpty("view_menu_footer", "menu_footer.php");

$viewConfig->setIfEmpty("view_page_header", "page/page_header.php");
$viewConfig->setIfEmpty("view_page_footer", "page/page_footer.php");

require_once $viewConfig->getParentTemplatePath() . "template.php";
?>