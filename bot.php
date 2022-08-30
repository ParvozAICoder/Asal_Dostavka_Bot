<?php
require_once "db_connect.php";

include 'Telegram.php';

$telegram = new Telegram('5528951220:AAEav33Z4yOPUCQTDyUdOHreWm1DYpQgbBU');
$chat_id = $telegram->ChatID();
$text = $telegram->Text();
$data = $telegram->getData();
$telNumber = $data['message']['contact']['phone_number'];
$veight = ["🍯 1kg - 35 000 som", "🍯 2 kg - 60 000 som"];
switch ($text) {
    case "/start":
        showStart();
        break;
    case "🍯 Batafsil ma'lumot" :
        showAbout();
        break;
    case "🍯 Buyurtmani berish":
        showOrder();
        break;
    default :
        if (in_array($text, $veight)) {
            file_put_contents('veihgt.txt', $text);
            $option = array(
                array($telegram->buildKeyboardButton("Raqamingizni jonating", $request_contact = true))
            );
            $keyb = $telegram->buildKeyBoard($option, $onetime = true, $resize = true);
            $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => 'Kerakli vaznni tanlang');
            $telegram->sendMessage($content);
        } else {
            file_put_contents('number.txt', $telNumber);
            $content = array('chat_id' => $chat_id, 'text' => 'Biz siz bn tez orada joatgan tel raqamingiz orqali boglanamiz');
            $telegram->sendMessage($content);
        }
        break;
}

function showStart()
{
    global $telegram, $chat_id, $stepFile;
    $content = array('chat_id' => $chat_id, 'text' => $stepFile);
    $telegram->sendMessage($content);
    $option = array(
        //First row
        array($telegram->buildKeyboardButton("🍯 Batafsil ma'lumot")),
        //Second row
        array($telegram->buildKeyboardButton("🍯 Buyurtmani berish")),
    );
    $keyb = $telegram->buildKeyBoard($option, true, true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Thisdasfbewugfewuhncdsjkfy8yewyrfhjgfuyewyfjhjsdgfwjkd is a Keyboard Test");
    $telegram->sendMessage($content);

}






function printRu()
{
    global $db;
    $result = $db->query("SELECT * FROM `psharipov_ bot`");

    while ($arr = $result->fetch_assoc()) {
        if (isset($arr["keyword"])) {
            var_dump($arr);
//            print $arr["keyword"];
            print "<br/>";
        }
    }
}

printRu();

echo  'salom';