<?php
$authParamsLogin = [
	"auth_min_level" => 0,
	"auth_by_session" => false,
	"auth_redirect_fail" => "access",
	"auth_redirect_success" => "lk",
	"auth_redirect_signout" => "/",
	//	"require" => ["companyKey"]
];

return [
	"404" => [
		"page" => "404.php",

		"view_vue_id" => null,
		"auth" => ""
	],
	"404_eng" => [
		"page" => "404_eng.php",


		"view_vue_id" => null,
		"auth" => ""
	],
	"access" => [
		"page" => "access.php",
		"view_vue_id" => null,
		"auth" => ""
	],
	"access_eng" => [
		"page" => "access_eng.php",
		"view_vue_id" => null,
		"auth" => ""
	],
	"apitest" => [
		"controller" => "Expertix\\Test\ApiTestController",
		"page" => "poems/poems.php",
		"js" => "poems/poems.js.php",
	],

	"login" => [
		"page" => "auth/login.php",
		"js" => "auth/loginjs.php",
	],
	"logout" => [
		"controller" => "Expertix\\Core\\Controller\\WebAuthSignOutController",
	],
	"phpcrud" => [
		"page" => "crud\phpcrud.php",
		"js" => "crud\phpcrudjs.php"
	],
	"upload" => [
		"page" => "upload/upload.php",
		"template" => "empty/template.php"		
	],
	"uploadtest" => [
		"page" => "upload/testupload.php",
		"js" => "upload/uploadjs.php",
		"template" => "quasar/simple.php"
	],
	"image"=>[
		"controller" => \Expertix\Core\Controller\File\GetFileController::class,
//		"param_mime" => "image/jpeg"
//		"template" => "empty/template.php",
//		"page" => "upload/upload_get.php"
	],
	"auth" => [
		"controller" => \Expertix\Core\Controller\WebAuthByLinkController::class,
		"auth" => $authParamsLogin
	],

	"api" => [
		"route" => [
			"auth" => [
				"controller" => Expertix\Core\Controller\Api\ApiAuthByLoginController::class,
				"auth" => "none"
			],
			"user"=>[
				"controller" => Expertix\Core\Controller\Api\ApiUserController::class,
			],
			"up"=>[
				"controller" => Expertix\Core\Controller\Api\ApiUploadController::class,
			],
			"email" => [
				"controller" => Expertix\Core\Controller\Api\ApiEmailController::class,
			],
			"form"=>[
				"controller" => Expertix\Core\Controller\Api\DefaultFormController::class
			]
		]
	],

];
