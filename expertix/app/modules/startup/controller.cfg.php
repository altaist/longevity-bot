<?php

use Expertix\Module\Startup\Project\ApiProjectController;
use Expertix\Module\Startup\ApiOrgController;

return [
	"startup" => [
		"page" => "home.php",
		"js" => "homejs.php"	
	],
	"checkin" => [
		"page" => "checkin.php",
		"js" => "checkinjs.php"
	],
	"projects" => [
		"controller" => \Expertix\Core\Controller\WebListDetailsController::class,
		"js" => "projectjs.php",
		"page_root" => "project/"
	],
	"project-edit" => [
		"page" => "edit.php",
		"js" => "editjs.php",
		"page_root" => "project/edit/"
	],
	"helper" => [
		"controller" => \Expertix\Core\Controller\WebListDetailsController::class,
		"js" => "projectjs.php",
		"page_root" => "project/"
	],
	
	"api" => [
		"defaults" => [],
		"route" => [
			"project" => [
				"controller" => ApiProjectController::class
			],
			"helper" => [
				"controller" => ApiOrgController::class
			],
			"checkin" => [
				"controller" => ApiProjectController::class
			]
		]
	]

];
