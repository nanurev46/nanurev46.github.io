<?php

    /*
    https://api.telegram.org/bot1980256085:AAEG-tCXdEuDD_wZF9JFVAZ0LRZlmgE-1ts/setWebhook?url=https://nanurev46.github.io/
    */

    $token = '1980256085:AAEG-tCXdEuDD_wZF9JFVAZ0LRZlmgE-1ts';
    $path = "https://api.telegram.org/bot" . $token;

    $data = json_decode(file_get_contents("php://input"), TRUE);
    file_put_contents('file.txt', 'data: ' . print_r($data, 1) . "\n", FILE_APPEND);

    $chatId = $data["message"]["chat"]["id"];
    $message = $data["message"]["text"];

    if (strpos($message, "/weather") === 0) {
        $location = substr($message, 9);
        $weather = json_decode(file_get_contents(
            "http://api.openweathermap.org/data/2.5/weather?q=".$location."&appid=16e981be3deee649b594353bad8256d9"), TRUE
        )["weather"][0]["main"];
        file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=Here's the weather in ".$location.": ". $weather);
    }

    if ($message == '/hello') {
        file_get_contents($path."/sendmessage?chat_id=".$chatId."&text= HELLLOOOOOO_o");
    }
?>