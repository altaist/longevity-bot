<?php

$viewConfig->set("view_framework", "bvue");
$viewConfig->setIfEmpty("view_theme_class", Expertix\Core\View\Theme\ThemeBVue::class);

include __DIR__ . "/template.php";
