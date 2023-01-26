<?php
$_siteNameDev = "localhost/longevity/";
$_siteName = "longevity-hub.world";
$_appId = "longevity-hub.world";
$configArr = [


	"dev" => [
		"APP_ID" => $_appId,
		"APP_TITLE" => "Проект",
		"BASE_URL" => "/$_siteNameDev/web/",
		"DEBUG_MODE" => true,
		"SESSION_NAME" => $_siteNameDev,
		"url" => [
			"site" => "http://$_siteNameDev/web/",
			"api" => "http://$_siteNameDev/web/api/",
			"admin" => "http://$_siteNameDev/admin/",
			"client" => "http://$_siteNameDev/client/",
		],
		"db" => [
			"type" => "Mysql",     // Database type: "Mysql", "Postgres", "Sqlserver", "Sqlite" or "Oracle"
			"user" => "root",      // Database user name
			"pass" => "",          // Database password
			"dsn"  => "mysql:dbname=expertix_3;host=localhost;charset=utf8;",          // PHP DSN extra information. Set as `charset=utf8mb4` if you are using MySQL
			"pdoAttr" => [
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES   => false,
			]
		],
		"email" => [
			"email_from" => "localhost",
			"email_from_name" => "admin",
			"email_dump" => true,
		]


	],
	"prod" => [
		"APP_ID" => $_appId,
		"APP_TITLE" => "Longinity Hub",

		"BASE_URL" => "/",
		"DEBUG_MODE" => false,
		"SESSION_NAME" => $_siteName,
		"url" => [
			"site" => "https://$_siteName/",
			"api" => "https://$_siteName/api/",
			"admin" => "https://$_siteName/admin/",
			"client" => "https://$_siteName/lk/client/",
		],
		"db" => [
			"type" => "Mysql",     // Database type: "Mysql", "Postgres", "Sqlserver", "Sqlite" or "Oracle"
			"user" => "a0001640_expertix_3",          // Database user name
			"pass" => "Qwerty120868",          // Database password
			"dsn"  => "mysql:dbname=a0001640_expertix_3;host=localhost;charset=utf8;",          // PHP DSN extra information. Set as `charset=utf8mb4` if you are using MySQL
			"pdoAttr" => [
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES   => false,
			]
		],
		"email" => [
			"email_from" => "office@longevity-hub.world",
			"email_from_name" => "Longevity Hub",
			"email_dump" => false,
		]


	]


];

return $configArr;
