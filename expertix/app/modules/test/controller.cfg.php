<?php

return [
	"tests"=>[
		"route"=>[
			"/"=>[
				"controller" => Test\App\AppTestController::class
			],
			"user"=>[
				"controller"=> Test\User\UserTestController::class
			]
			
		]
	]
];