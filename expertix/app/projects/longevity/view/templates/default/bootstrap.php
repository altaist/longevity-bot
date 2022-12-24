<?php

$viewConfig->set("view_framework", "bootstrap");
$viewConfig->setIfEmpty("view_theme_class", Expertix\Core\View\Theme\ThemeBootstrap::class);

include __DIR__ . "/template.php";
