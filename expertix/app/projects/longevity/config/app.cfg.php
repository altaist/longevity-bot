<?php

$appParams = [
	"debug_mode" => true,
	"app_id" => "expertix." . PROJECT_KEY,
	"app_controller" => "Expertix\Core\App\AppBase", 
	"app_base_template" => "default/template.php",

	"modules_autoload" => false,
	"modules" => [
		"app" => [],
		"user" => [],
		"test"=>[],
		"catalog"=>[]

	],
	"email"=>[
		
		"signup"=>[
			"subject"=> "Welcom to Longevity Hub",
			"body"=> <<<EOT
			<h4>Dear friend, thank you for knocking on our door!</h4><p>In the near future we will send you a short questionnaire to get started</p><p><a href="#LINK#">Your auth link</a></p>
			EOT
		],
		"signup_eng" => [
			"subject" => "Welcom to Longevity Hub",
			"body" => <<<EOT
			<p>Dear friend, thank you for knocking on our door! In the near future we will send you a short questionnaire to get started</p>
			EOT
		],


		"login_notify" => [
			"subject" => "longevity hub profile link",
			"body" => <<<EOT
			<p><a href="#LINK#">Your auth link</a></p>
			EOT
		],
		"signup_admin" => [
			"to" => "apechersky@ya.ru",
			"subject" => "#APP_ID - регистрация пользователя",
			"body" => "<div>На сайте зарегистрирован новый пользователь</div>"

		],
		"form_submit_admin" => [
			"to" => "apechersky@ya.ru",
			"subject" => "#APP_ID - новая заявка",
			"body" => <<<EOT
			EOT
		]
	]
];

return $appParams;