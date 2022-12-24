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
	"content" => include(__DIR__ . "./content.cfg.php")
];