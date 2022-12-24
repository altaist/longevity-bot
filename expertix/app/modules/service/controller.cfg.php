<?php
return [
	"api" => [
		"route" => [
			"service" => [
				"controller" => \Module\Service\ApiServiceController::class
			],
			"subscribe" => [
				"controller" => \Module\Service\ApiSubscribeController::class
			],
			"afisha" => [
				"controller" => \Module\Service\ApiSubscribeController::class
			],

		]
	]
];
