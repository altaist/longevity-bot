<?php

return [[
    "1" => [
        "type" => "1",
        "ru" => [
            "items" => [
                ["text" => "Доброе утро!\nА знаете ли вы, что в мире существуют минимум 6 людей которые на вас похожи, и вероятность того, что вы когда-то на протяжении вашей жизни встретите своего двойника 9%.Хотели бы ли вы однажды встретить своего двойника?", "actions"=>["Да", "Нет", "Сомневаюсь ответить"],  ],
                ["text" => "Доброе утро!\nНа случай, если вы сегодня куда-то собираетесь, помните, что первое, на что люди обращают внимание при встрече с вами - это ваши туфли. Так оденьте же хорошую пару туфлей при выходе из дома!", "actions"=>"Я и так всегда\n в приличных туфлях; Мне все это не важно", ],
                ["text" => "Доброе утро!\nСреда - середина недели, а вы уже занимались каким-то спортом?\nСуществует 50% вероятность того, что люди, проводящие 11 часов в сидячем положении рискуют умереть в следующие 3 года.\nПрогуляйтесь, поприседайте, наслаждайтесь движением!", "actions"=>"Я уже сделал зарядку!; Спасибо, обязательно!;Я и так весь день на ногах" ],
                ["text" => "Доброе утро!\nУтренний завтрак придает нам сил. А знали ли вы, что праворукие люди так же и жуют в основном правой стороной. А вы правша или левша?", "actions"=>"Правша; Левша; Не хочу отвечать", ],
                ["text" => "Доброе утро!\nВот и подходит к концу рабочая неделя.\nСогласно исследованиям, создание намерения какого-то действия увеличивает вероятность того, что вы его выполните на 30%.\nА вы уже спланировали свои выходные?", "actions"=>"Да;Нет;Есть идеи", ],
                ["text" => "Доброе утро!\nЗнали ли вы, что ваш рост зависить от роста вашего отца, а ваш вес - от веса вашей матери?Совпадает ли это в вашем случае?", "actions"=>"Да;Нет", ],
                ["text" => "Доброе утро!\nНу вот и воскресенье - день отдыха! Наверняка вы замечали, что именно после отдыха у вас могут появляться новые идеи, ответы на заботящие вас вопросы, лучшее осмысление ситуации. \nВсе это потому что, когда мы отдыхаем, и отдыхает наш мозг, наше подсознательное продолжает перерабатывать полученую информацию.\nОтдыхая намеренно мы лучше думаем.\nА вы используете отдых намеренно?", "actions"=>"Да;Нет", ],

            ],
            "default" => [
                "text_after_answer" => "Спасибо за ответ! Хорошего вам дня!",
                "1text_after_1" => "Вы выбрали like",
                "1text_after_2" => "Вы выбрали dislike",
                "1text_after_3" => "Вы выбрали dont know",
                "text_after_dislike" => "Вот увидите, день будет прекрасным!",
                "kb" => [
                    'inline_keyboard' => [
                        [
                            ['text' => 'Все хорошо', "callback_data" => "like"],
                            ['text' => 'Все неважно', "callback_data" => "dislike"],
                        ]
                    ]
                ]
            ]
        ],
        "en" => [],
    ],
    "2" => [
        "type" => "1",
        "ru" => [
            "items" => [
                ["text" => "Добрый вечер! Как прошел день?"]
            ], 
            "default" => [
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
            ]
        ],
        "en" => [],
    ],
    "g10" => [
        "type" => "2",
        "ru" => [
            "items" => [
                ["img" => "https://longevity-hub.world/img/bot/love/love-1.jpg", "text" => "Нравится ли вам это изображение?", "tags" => "love"],
                ["img" => "https://longevity-hub.world/img/bot/cats/cats-1.jpg", "text" => "Нравится ли вам это изображение?", "tags" => "cats"],
                ["img" => "https://longevity-hub.world/img/bot/flowers/flowers-1.jpg", "text" => "Нравится ли вам это изображение?", "tags" => "flowers"],
                ["img" => "https://longevity-hub.world/img/bot/nature/nature-1.jpg", "text" => "Нравится ли вам это изображение?", "tags" => "nature"],
                ["img" => "https://longevity-hub.world/img/bot/wisdom/wisdom-1.jpg", "text" => "Нравится ли вам это изображение?", "tags" => "wisdom"],
                ["img" => "https://longevity-hub.world/img/bot/cats/cats-2.jpg", "text" => "Нравится ли вам это изображение?", "tags" => "cats"],
                ["img" => "https://longevity-hub.world/img/bot/dogs/dogs-2.jpg", "text" => "Нравится ли вам это изображение?", "tags" => "dogs"],
                ["img" => "https://longevity-hub.world/img/bot/flowers/flowers-2.jpg", "text" => "Нравится ли вам это изображение?", "tags" => "flowers"],
                ["img" => "https://longevity-hub.world/img/bot/love/love-2.jpg", "text" => "Нравится ли вам это изображение?", "tags" => "love"],
                ["img" => "https://longevity-hub.world/img/bot/nature/nature-2.jpg", "text" => "Нравится ли вам это изображение?", "tags" => "nature"],
                ["img" => "https://longevity-hub.world/img/bot/cats/cats-3.jpg", "text" => "Нравится ли вам это изображение?", "tags" => "cats"],
                ["img" => "https://longevity-hub.world/img/bot/dogs/dogs-3.jpg", "text" => "Нравится ли вам это изображение?", "tags" => "dogs"],
                ["img" => "https://longevity-hub.world/img/bot/flowers/flowers-3.jpg", "text" => "Нравится ли вам это изображение?", "tags" => "flowers"],
                ["img" => "https://longevity-hub.world/img/bot/love/love-3.jpg", "text" => "Нравится ли вам это изображение?", "tags" => "love"],
                ["img" => "https://longevity-hub.world/img/bot/wisdom/wisdom-2.jpg", "text" => "Нравится ли вам это изображение?", "tags" => "wisdom"],
                ["img" => "https://longevity-hub.world/img/bot/nature/nature-3.jpg", "text" => "Нравится ли вам это изображение?", "tags" => "nature"],
                ["img" => "https://longevity-hub.world/img/bot/wisdom/wisdom-3.jpg", "text" => "Нравится ли вам это изображение?", "tags" => "wisdom"],
            ],

            "default"=>[
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
            ]
        ],
        "en" => [],
        "img" => [
            ["https://longevity-hub.world/img/bot/love/love-1.jpg", "love"],
            ["https://longevity-hub.world/img/bot/cats/cats-1.jpg", "cats"],
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
]];
