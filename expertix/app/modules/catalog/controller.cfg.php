<?php

return [
	"api"=>[
		"route"=>[
			"product"=>[
				"controller"=> Expertix\Module\Catalog\Product\ApiProductController::class
			],
			"meeting" => [
				"controller" => Expertix\Module\Catalog\Product\ApiMeetingController::class
			]
			
		]
	]
];