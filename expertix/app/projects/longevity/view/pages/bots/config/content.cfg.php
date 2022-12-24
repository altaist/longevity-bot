<?php

return [[
    "1" => [
        "type" => "1",
        "ru" => [
            "items" => [
                "text" => "Доброе утро! Как самочувствие?"
            ],
            "default" => [
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
            ]
        ],
        "en" => [],
    ],
    "2" => [
        "type" => "1",
        "ru" => [
            "items" => [
                "text" => "Добрый вечер! Как прошел день?"
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
    "10" => [
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
