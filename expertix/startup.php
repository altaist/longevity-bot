<?php

defined("PATH_APP") or define("PATH_APP", __DIR__ . "/");
//defined("PATH_APP_LIB") or define("PATH_APP_LIB", PATH_APP . "../../applib/v0802/");
defined("PATH_APP_LIB") or define("PATH_APP_LIB", __DIR__ . "/framework/v0802/");

defined("PATH_VENDORS") or define("PATH_VENDORS", PATH_APP . "../../vendors/");

require_once PATH_APP_LIB . "startup.php";
require __DIR__ . "/apploader.php";

// Start app
if(defined("MODE_SIMPLE")){
	$app = (new ThisAppLoader())->buildSimpleApp();
}else{
	$app = (new ThisAppLoader())->buildApp();
}
$app->process(false);

?>