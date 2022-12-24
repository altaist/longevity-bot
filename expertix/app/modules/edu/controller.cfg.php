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
return [
	"edu" => [
		"defaults" => [],
		"route" => [
			"/" => [
				"page" => "public/home.php",
				"js" => "public/homejs.php",
			],
			"quiz"=>[
				"defaults" => [],
				"route" => [
					"math" => [
						"page" => "quiz/math.php",
						"js" => "quiz/mathjs.php"
					]
				]			
			]
		]
	],
	"student" => [
		"defaults" => [],
		"route" => [
			"course" => [],
			"lesson" => [],
			""
		]
	],
	"api" => [
		"edu" => []
	]

];
