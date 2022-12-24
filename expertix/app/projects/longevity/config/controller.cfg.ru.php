<?php
$appRoles = [
	"0" => "",
	"1" => "student/course",
	"2" => "teacher/",
	"3" => "manager/",
	"4" => "admin/"

];

$authParamsDefault = [
	"auth_min_level" => 0,
	"auth_by_session" => true,
	"auth_redirect_fail" => "no",
	//"auth_redirect_fail_no" => true,
];
$authParams = [
	"auth_min_level" => 0,
	"auth_by_session" => true,
	"auth_redirect_fail" => "access",
	"auth_redirect_signout" => "/",
	//	"require" => ["companyKey"]
];
$authParamsUser = [
	"auth_min_level" => 1,
	"auth_by_session" => true,
	"auth_redirect_success" => "lk",
	"auth_redirect_fail" => "access",
	"auth_redirect_signout" => "/",
	//	"require" => ["companyKey"]
];
$authParamTeacher = [
	"auth_min_level" => 5,
	"auth_by_session" => true,
	"auth_redirect_success" => "lk",
	"auth_redirect_fail" => "access",
	"auth_redirect_signout" => "/",
	//	"require" => ["companyKey"]
];
$authParamsManager = [
	"auth_min_level" => 10,
	"auth_by_session" => true,
	"auth_redirect_success" => "lk",
	"auth_redirect_fail" => "access",
	"auth_redirect_signout" => "/",
	//	"require" => ["companyKey"]
];
$authParamsLogin = [
	"auth_min_level" => 0,
	"auth_by_session" => false,
	"auth_redirect_fail" => "access",
	"auth_redirect_success" => "lk",
	"auth_redirect_signout" => "lk",
	//	"require" => ["companyKey"]
];

$routerConfig = [
	"defaults" => [

		"auth" => $authParamsDefault,
		"roles" => $appRoles,
		"lang" => "rus",

		"user_factory" => \Project\User\UserFactory::class,
		"template" => "default/quasar.php",
		"view_theme_class" => Expertix\Core\View\Theme\ThemeQuasar::class,
		//"view_framework" => "quasar",
		"view_css_path" => "projects/intellect04/style.css",
		"view_page_container_class" => "container",

		"email_from" => "",
		"email_from_name" => "",
		"email_to_test" => "",


	],
	"route" => [
		"/" => "home",
		"/" => "home",
		"home" => [
			"title" => "Digital companion",
			"description" => "A digital service that helps longevity through big data collection and AI",
			"page" => "home.php",
			"js" => "homejs.php",
			"view_page_container_class" => "",
			"view_menu_top" => "menu_top_home.php",
			"view_menu_footer" => "menu_footer_home.php"
		],

		"wizard" => [
			"title" => "Digital companion",
			"description" => "Calculator",
			"page" => "calculator.php",
			"js" => "calculatorjs.php",
		],

		"lk" => [
			"defaults" => [
				"auth" => $authParamsUser
			],
			"route" => [
				"/" => "home",
				"home" => [
					"title" => "Profile",
					"page" => "lk/lk.php",
					"js" => "lk/lkjs.php"
				],
				"report" => [
					"title" => "Report",
					"page" => "lk/report.php",
					"js" => "lk/reportjs.php"
				]
			]
		],



		"api" => [
			"route" => [
				"activity" => [
					"controller" => Expertix\Activity\ApiActivityController::class,
					"auth" => "none"
				],
				"subscribe" => [
					"controller" => Expertix\Activity\ApiSubscribeController::class,
				],
				"product" => [
					"controller" => Expertix\Activity\ApiActivityController::class,
				],
				"email"=>[
					"controller" => Project\ApiEmail::class
				],
				"game" => [
					"controller" => Project\Game\GameController::class,
				],


			]
		],



	]

];

return $routerConfig;
