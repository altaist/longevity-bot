<?php

$viewConfig->set("view_framework", "quasar");
$viewConfig->setIfEmpty("view_theme_class", Expertix\Core\View\Theme\ThemeQuasar::class);
include __DIR__ . "/template.php";