<?php

$viewConfig->setTemplatePath(__DIR__. "/");
$viewConfig->setParentTemplatePath(PATH_BASE_TEMPLATE);

echo $viewConfig->getParentTemplatePath() . "simple.php";
require_once $viewConfig->getParentTemplatePath() . "simple.php";
?>