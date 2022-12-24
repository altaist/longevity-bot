<?php
/*
routes:

edu/
edu/course
edu/lesson

edu-a/
edu-a/teacher/course
edu-a/teacher/lesson
edu-a/method/course
edu-a/method/lesson
edu-a/admin/course
edu-a/admin/lesson
edu-a/admin/lesson

api/edu/0/
api/edu/0/course
api/edu/0/lesson



*/

use Expertix\Module\Store\ApiCatalogController;
use Expertix\Module\Store\Order\OrderApiController;
use Expertix\Module\Services\Service\ApiServiceController;
use Expertix\Module\Services\Meeting\ApiMeetingController;
use Expertix\Module\Services\Activity\ApiActivityController;

return [
	"123" =>[
		"page" => "product.php",
		"js" => "storejs.php"
		
	],

	"product" => [
		//"page" => "product/details.php",
		"js" => "storejs.php",
		"model"=> \Expertix\Module\Store\Product\ProductModel::class,
		"view_menu_top" => "menu/product/menu_top_product.php"],
	"podgotovka-ege-oge" => [
		"controller" => \Expertix\Core\Controller\WebListDetailsController::class,
		"model" => \Expertix\Module\Store\Product\ProductModel::class,
		"page_root" => "product/",
		"js" => "productjs.php",
		"view_menu_top" => "menu/product/menu_top_product.php"
	],
	"category" => [
		"page" => "product/list.php",
		"js" => "storejs.php"
	],
	"ser" => [
		"page" => "service/service.php",
		"js" => "storejs.php",
		"model" => \Expertix\Module\Service\ServiceModel::class,

		"view_menu_top"=>"menu/product/menu_top_service.php"
	],
	"service"=>[
		"controller" => \Expertix\Core\Controller\WebListDetailsController::class,
		"model" => \Expertix\Module\Services\Service\ServiceModel::class,
		"page_root" => "service/",
	],
	"quiz" => [
		"page" => "quiz/quiz.php",
		"js" => "quiz/quizjs.php",
		
	],
	"store" => [
		"route" => [
		]
	],
	"store-admin" => [
		"defaults" => [],
		"route" => [
			"product"=>[
				"title"=>"Редактирование продукта",
				"page_root" => "product/admin/",
				"controller" => \Expertix\Core\Controller\WebListDetailsController::class,
				"model" => \Expertix\Module\Store\Product\ProductModel::class,
				"js" => "productjs.php",
				
				"page_for_list"=>"table"
			],
			"service" => [
				"title" => "Редактирование продукта",
				"page_root" => "service/admin/",
				"controller" => \Expertix\Core\Controller\WebListDetailsController::class,
				"model" => \Expertix\Module\Services\Service\ServiceModel::class,
				"js" => "servicejs.php",

				"page_for_list" => "table"
			],
			"meeting" => [
				"title" => "Редактирование продукта",
				"page_root" => "meeting/admin/",
				"controller" => \Expertix\Core\Controller\WebListDetailsController::class,
				"model" => \Expertix\Module\Services\Meeting\MeetingModel::class,
				"js" => "meetingjs.php",
				"page_for_list" => "table",
				"api" => [
					"meeting" => "api/meeting/"
				]
			],
			"activity" => [
				"title" => "Редактирование продукта",
				"page_root" => "activity/admin/",
				"controller" => \Expertix\Core\Controller\WebListDetailsController::class,
				"model" => \Expertix\Module\Services\Activity\ActivityModel::class,
				"js" => "activityjs.php",
				"page_for_list" => "table",
				"api" => [
					"activity" => "api/activity/"
				]
			]
		]
	],	
	"a" => [
		"defaults" => [],
		"route" => [
			"quiz" => [
				"page" => "activity/quiz.php",
				"js" => "activity/quizjs.php",
			],
			"present" => [
				"page" => "activity/present.php",
				"js" => "activity/quizjs.php",
			],
			"gallery" => [
				"page" => "active/gallery.php",
				"js" => "activity/galleryjs.php",
			],
		]
	],	
	"api" => [
		"defaults" => [],
		"route" => [
			"order" => [
				"controller" => OrderApiController::class
				
			],
			"catalog" => [
				"controller" => ApiCatalogController::class
			],
			"service" => [
				"controller" => ApiServiceController::class
			],
			"meeting" => [
				"controller" => ApiMeetingController::class
			],
			"activity" => [
				"controller" => ApiActivityController::class
			],
			"action" => [
				"controller" => ApiServiceController::class
			],		
		]
	]

];
