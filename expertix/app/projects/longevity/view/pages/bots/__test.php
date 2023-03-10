<?php
// https://api.telegram.org/bot5565233096:AAHNaZLiwvddQQZUkyYkoTJlUzT5AOfCVnQ/setwebhook?url=https://longevity-hub.ru/telegram_bot.php

$data = json_decode(file_get_contents('php://input'), TRUE);
//пишем в файл лог сообщений
file_put_contents(__DIR__.'/file.txt', '$dataIn: '.print_r($data, 1)."\n", FILE_APPEND);

//$res = sendTelegram($method, $data);

$data = $data['callback_query'] ? $data['callback_query'] : $data['message'];

//define('TOKEN', '5781044699:AAExq1aQ__u9wJpNLXXyQXfDc9J_6lZY9sQ');
define('TOKEN', '5488879546:AAEc-1Jrf9nk0GhJt0zVbX-TVXk0PmmTfnk');

$message = mb_strtolower(($data['text'] ? $data['text'] : $data['data']),'utf-8');

$dataSrc = $data;


switch ($message) {
    case 'да':
        $method = 'sendMessage';
		$send_data = [
			'text' => 'Что вы хотите заказать?',
			'reply_markup'  => [
				'resize_keyboard' => true,
				'keyboard' => [
						[
							['text' => 'Яблоки'],
							['text' => 'Груши'],
						],
						[
							['text' => 'Лук'],
							['text' => 'Чеснок'],
						]
					]
				]
			];
    break;
	case 'нет':
        $method = 'sendMessage';
		$send_data = ['text' => 'Приходите еще'];
    break;
	case 'яблоки':
        $method = 'sendMessage';
		$send_data = ['text' => 'заказ принят!'];
    break;
	case 'груши':
        $method = 'sendMessage';
		$send_data = ['text' => 'заказ принят!'];
    break;
	case 'лук':
        $method = 'sendMessage';
		$send_data = ['text' => 'заказ принят!'];
    break;
	case 'чеснок':
        $method = 'sendMessage';
		$send_data = ['text' => 'заказ принят!'];
    break;
	default:
		$method = 'sendMessage';
		$send_data = [
			'text' => 'Вы хотите сделать заказ?',
			'reply_markup'  => [
				'resize_keyboard' => true,
				'keyboard' => [
						[
							['text' => 'Да'],
							['text' => 'Нет'],
						]
					]
				]
			];
}

$send_data['chat_id'] = $data['chat'] ['id'];
$send_data['text'] = $dataSrc;
$res = sendTelegram($method, $send_data);




function sendTelegram($method, $data, $headers = [])
{
	$curl = curl_init();
	curl_setopt_array($curl, [
		CURLOPT_POST => 1,
		CURLOPT_HEADER => 0,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => 'https://api.telegram.org/bot' . TOKEN . '/' . $method,
		CURLOPT_POSTFIELDS => json_encode($data),
		CURLOPT_HTTPHEADER => array_merge(array("Content-Type: application/json"))
	]);
	$result = curl_exec($curl);
	file_put_contents(__DIR__.'/file.txt', '$dataOut: '.print_r($data, 1)."\n", FILE_APPEND);
	curl_close($curl);
	return (json_decode($result, 1) ? json_decode($result, 1) : $result);
}
