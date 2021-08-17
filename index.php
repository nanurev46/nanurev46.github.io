<?php

    /*
    https://api.telegram.org/bot1980256085:AAEG-tCXdEuDD_wZF9JFVAZ0LRZlmgE-1ts/setWebhook?url=https://nanurev46.github.io/
    */

    const TOKEN = '1980256085:AAEG-tCXdEuDD_wZF9JFVAZ0LRZlmgE-1ts';
    const PATH = "https://api.telegram.org/bot" . TOKEN;

    $data = json_decode(file_get_contents("php://input"), TRUE);
    file_put_contents('file.txt', 'data: ' . print_r($data, 1) . "\n", FILE_APPEND);

    $data = $data['callback_query'] ? $data['callback_query'] : $data['message'];
    $message = mb_strtolower(($data['text'] ? $data['text'] : $data['data']), 'utf-8');

    switch ($message){
        case '/hello':
            $method = 'sendMessage';
            $send_data = [
                'text' => 'Hello_0'
            ];
            break;
        default:
            $method = 'sendMessage';
            $send_data = [
                'text' => '?'
            ];
    }

    $send_data['chat_id'] = $data['chat']['id'];

    $res = sendTelegram($method, $send_data);

    function sendTelegram($method, $data, $headers = []){
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => PATH . "/$method",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array_merge(array("Content-Type: application/json"), $headers),
        ]);

        $result = curl_exec($curl);
        curl_close($curl);

        return
            (json_decode($result, 1) ? json_decode($result, 1) : $result);
    }
?>