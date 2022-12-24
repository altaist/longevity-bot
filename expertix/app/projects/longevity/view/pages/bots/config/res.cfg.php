<?php
return [
	"text" => [
		"en" => [
			"about" => "About bot...",
			"help" => "Use this commands: \n*start - to register in the service\n*key - to recieve auth key",
			"wrong_command" => "Have a nice day!",
			"error_not_registered" => "You should register. Send this command: start",
			"app_error" => "Internal error",
			"select_lang" => "Select your language",
			"langs" => ["English", "Русский"],
			"chat_created" => "Your chat was activated! I will send you a password for connecting to another bot",
			"chat_created_child" => "Your chat was activated!",
			"chat_created_already" => "Welcome! Glad to see you again",
			"chat_stopped" => "This chat was stopped",
			"chat_link_created" => "",
			"chat_link_error" => "Internal error. Wrong generated link",
			"chat_link_wrong_param" => "Wrong chat link param",
			"chat_link_established" => "New chat relation established",
			"chat_link_established_error" => "Chat was already connected",
			"chat_unlink_result" => "Your link was removed",
			"chat_unlink_error" => "Can't disconnect. Chat was already disconnected",
			"content_question" => "Do you like such pictures?",
			"answer_please" => "Please select right options",
			"alarm_message1" => "Your linked user '#USER_NAME' didn't answer for more then 12 hours!",
			"alarm_message2" => "Your linked user '#USER_NAME' didn't answer for more then 24 hours!",
			"not" => "Thanks for the answer!",
			"nicely" => "Thanks for the answer!",
			"perfectly" => "Thanks for the answer!",
			"kb_default" => [
				'remove_keyboard' => true
			],
			"kb_remove" => [
				'remove_keyboard' => true
			],
			"kb_default_1" => [
				'resize_keyboard' => true,
				'inline_keyboard' => [
					[
						['text' => 'Staart', "callback_data" => "ok"],
						['text' => 'Stoop', "callback_data" => "not"],
						['text' => 'Password', "callback_data" => "Password"],
					]
				]
			],
			"kb_content_answer" => [
				'remove_keyboard' => true
			],
			"kb_content_answer_1" => [
				'inline_keyboard' => [
					[
						['text' => 'Not bad', "callback_data" => "not"],
						['text' => 'Nicely', "callback_data" => "nice"],
						['text' => 'Perfectly', "callback_data" => "perfect"],
					],
					[
						['text' => 'Stop', "callback_data" => "help"],
					]
				]
			]
		],
		"ru" => [
			"about" => "Информация о боте...",
			"help" => "Список команд:",
			"wrong_command" => "Не могу распознать вашу команду",
			"error_not_registered" => "Вы должны сначала зарегистрироваться. Отправьте команду start",
			"app_error" => "Произошла внутренняя ошибка",
			"select_lang" => "Выберите ваш язык",
			"langs" => ["English", "Русский"],
			"chat_created" => "Добро пожаловать! Сервис активирован. В следующем сообщении вы получите пароль для связи с другим ботом. Чтобы остановить получение сообщений, отправьте команду stop",
			"chat_created_child" => "Добро пожаловать! Сервис активирован. Чтобы остановить получение сообщений, отправьте команду stop",
			"chat_created_already" => "Рады видеть вас снова",
			"chat_stopped" => "Рассылка сообщений приостановлена. Чтобы возобновить, отправьте start",
			"chat_link_created" => "",
			"chat_link_error" => "При создании пароля возникла внутрення ошибка",
			"chat_link_wrong_param" => "Неверный параметр. Нужно указать секретный код через пробел",
			"chat_link_established" => "Новая связь с пользователем установлена",
			"chat_link_established_error" => "Вы уже были связаны с этим пользователем",
			"chat_unlink_result" => "Связь с пользователем разорвана. Вы больше не будете получать уведомления о его активности",
			"chat_unlink_error" => "Связь с пользователем уже была разорвана",
			"content_question" => "Нравятся ли вам эти изображения?",
			"answer_please" => "Понравилось ли вам сообщение?",
			"alarm_message1" => "Пользователь '#USER_NAME', за которым вы наблюдаете, не отвечал уже более 30 минут!",
			"alarm_message2" => "Пользователь '#USER_NAME', за которым вы наблюдаете, не отвечал уже более 1 часа!",
			"not" => "Спасибо за ответ! Мы учтем и не будем вам больше показывать подобный контент дальше",
			"nicely" => "Спасибо за ответ! Мы учтем и не будем вам больше показывать подобный контент дальше",
			"perfectly" => "Спасибо за ответ! Мы учтем и не будем вам больше показывать подобный контент дальше",
			"kb_content_answer" => [
				'inline_keyboard' => [
					[
						['text' => 'Нравится!', "callback_data" => "like"],
						['text' => 'Не нравится!', "callback_data" => "dislike"],
					]
				]
			],
			"kb_remove" => [
				'remove_keyboard' => true
			],
			"kb_content_answer_1" => [
				'keyboard' => [
					[
						['text' => 'Not bad', "callback_data" => "not"],
						['text' => 'Nicely', "callback_data" => "nice"],
						['text' => 'Perfectly', "callback_data" => "perfect"],
					],
					[
						['text' => 'Stop', "callback_data" => "help"],
					]
				]
			]
		]

	],
	"img" => [
		"https://longevity-hub.world/img/avatar1.png",
		"https://longevity-hub.world/img/tourism/raft.jpg",
		"https://longevity-hub.world/img/avatar4.png",
		"https://longevity-hub.world/img/intellect/nauka1.jpg",
		"https://longevity-hub.world/img/tourism/tel.jpg",
		"https://longevity-hub.world/img/intellect/books1.jpg",
	],
	"content" => [
		"1" => [
			"type" => "1",
			"ru" => [
				"text" => "Доброе утро! Как самочувствие?",
				"text_after_answer" => "Спасибо за ответ!",
				"text_after_like" => "Спасибо за ответ! Хорошего вам дня!",
				"text_after_dislike" => "Вот увидите, день будет прекрасным!",
				"kb" => [
					'inline_keyboard' => [
						[
							['text' => 'Хорошее', "callback_data" => "like"],
							['text' => 'Плохое', "callback_data" => "dislike"],
						]
					]
				]
			],
			"en" => [
				"text" => "Good morning!",
				"text_after_answer" => "Спасибо за ответ!",
				"text_after_like" => "Спасибо за ответ! Хорошего вам дня!",
				"text_after_dislike" => "Вот увидите, день будет прекрасным!",
				"kb" => [
					'inline_keyboard' => [
						[
							['text' => 'Нравится!', "callback_data" => "like"],
							['text' => 'Не нравится!', "callback_data" => "dislike"],
						]
					]
				]
			],
		],
		"2" => [
			"type" => "1",
			"ru" => [
				"text" => "Добрый вечер! Как прошел день?",
				"text_after_answer" => "Спасибо за ответ!",
				"text_after_like" => "Спасибо за ответ! Хорошего вам вечера!",
				"text_after_dislike" => "Вот увидите, день будет прекрасным!",
				"kb" => [
					'inline_keyboard' => [
						[
							['text' => 'Замечательно!', "callback_data" => "like"],
							['text' => 'Плохо', "callback_data" => "dislike"],
						]
					]
				]
			],
			"en" => [
				"text" => "Good evening!",
				"kb" => [
					'inline_keyboard' => [
						[
							['text' => 'Нравится!', "callback_data" => "like"],
							['text' => 'Не нравится!', "callback_data" => "dislike"],
						]
					]
				]
			],
		],
		"10" => [
			"type" => "2",
			"ru" => [
				"text" => "Нравится ли вам это изображение?",
				"text_after_answer" => "Спасибо за ответ!",
				"text_after_like" => "Спасибо за ответ! Ждите новых интересных материалов!",
				"text_after_dislike" => "Спасибо за ответ! Мы постараемся присылать вам меньше подобного контента",
				"kb" => [
					'inline_keyboard' => [
						[
							['text' => 'Нравится!', "callback_data" => "like"],
							['text' => 'Не нравится!', "callback_data" => "dislike"],
						]
					]
				]
			],
			"en" => [
				"text" => "Нравятся ли вам эти изображения?",
				"kb" => [
					'inline_keyboard' => [
						[
							['text' => 'Нравится!', "callback_data" => "like"],
							['text' => 'Не нравится!', "callback_data" => "dislike"],
						]
					]
				]
			],
			"img" => [
				["https://longevity-hub.world/img/bot/cats/cats-1.jpg", "cats"],
				["https://longevity-hub.world/img/bot/love/love-1.jpg", "love"],
				["https://longevity-hub.world/img/bot/flowers/flowers-1.jpg", "flowers"],
				["https://longevity-hub.world/img/bot/nature/nature-1.jpg", "nature"],
				["https://longevity-hub.world/img/bot/wisdom/wisdom-1.jpg", "wisdom"],
				["https://longevity-hub.world/img/bot/cats/cats-2.jpg", "cats"],
				["https://longevity-hub.world/img/bot/dogs/dogs-2.jpg", "dogs"],
				["https://longevity-hub.world/img/bot/flowers/flowers-2.jpg", "flowers"],
				["https://longevity-hub.world/img/bot/love/love-2.jpg", "love"],
				["https://longevity-hub.world/img/bot/nature/nature-2.jpg", "nature"],
				["https://longevity-hub.world/img/bot/cats/cats-3.jpg", "cats"],
				["https://longevity-hub.world/img/bot/dogs/dogs-3.jpg", "dogs"],
				["https://longevity-hub.world/img/bot/flowers/flowers-3.jpg", "flowers"],
				["https://longevity-hub.world/img/bot/love/love-3.jpg", "love"],
				["https://longevity-hub.world/img/bot/wisdom/wisdom-2.jpg", "wisdom"],
				["https://longevity-hub.world/img/bot/nature/nature-3.jpg", "nature"],
				["https://longevity-hub.world/img/bot/wisdom/wisdom-3.jpg", "wisdom"],
			],
			"img-old" => [
				["https://longevity-hub.world/img/avatar1.png"],
				["https://longevity-hub.world/img/tourism/raft.jpg"],
				["https://longevity-hub.world/img/avatar4.png"],
				["https://longevity-hub.world/img/intellect/nauka1.jpg"],
				["https://longevity-hub.world/img/tourism/tel.jpg"],
				["https://longevity-hub.world/img/intellect/books1.jpg"],
			]
		],
		"11" => [
			"img" => [
				"https://longevity-hub.world/img/avatar1.png",
				"https://longevity-hub.world/img/tourism/raft.jpg",
				"https://longevity-hub.world/img/avatar4.png",
				"https://longevity-hub.world/img/intellect/nauka1.jpg",
				"https://longevity-hub.world/img/tourism/tel.jpg",
				"https://longevity-hub.world/img/intellect/books1.jpg",
			]
		]
	]

];