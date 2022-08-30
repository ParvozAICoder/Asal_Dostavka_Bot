<?php

include 'Telegram.php';
require_once 'user.php';
$telegram = new Telegram('5528951220:AAEav33Z4yOPUCQTDyUdOHreWm1DYpQgbBU');
$data = $telegram->getData();
$message = $data['message'];
$text = $telegram->Text();
$chat_id = $telegram->ChatID();
$veight = ["🍯 1kg - 35 000 som", "🍯 2 kg - 60 000 som"];
$firstName = $message['from']['first_name'];
$lastName = $message['from']['last_name'];
$ADMIN_CHAT_ID = 981882778;
if ($text == '/start') {
    showMain();
} else {
    switch (getPage($chat_id)) {
        case 'main':
            if ($text == "🍯 Batafsil ma'lumot") {
                showAbout();
            } elseif ($text == "🍯 Buyurtmani berish") {
                showMassa();
            } else {
                chooseButtons();
            }
            break;
        case 'mass':
            if (in_array($text, $veight)) {
                setMass($chat_id, $text);
                showPhone();
            } elseif ($text == "Orqaga") {
                showMain();
            } else {
                chooseButtons();
            }
            break;
        case "phone":
            if ($message['contact']['phone_number'] != "") {
                setPhone($chat_id, $message['contact']['phone_number']);
                showDeleviryType();
            } elseif ($text == 'Orqaga') {
                showMassa();
            } else {
                setPhone($chat_id, $text);
                showDeleviryType();
            }

            break;
        case "delivery":
            if ($text == "✈ Yetkazib berish ✈") {
                showInputLocation();
            } elseif ($text == "🍯 Borib olish 🍯") {
                showReady();
            } elseif ($text == "Orqaga") {
                showPhone();
            } else {
                chooseButtons();
            }

            break;
        case "location":
            if ($message['location']['latitude'] != "") {
                setLatitude($chat_id, $message['location']['latitude']);
                setLongitude($chat_id, $message['location']['longitude']);
                showReady();
            } elseif ($text == "Lokatsiya jo'nata olmayman") {
                showReady();
            } elseif ($text == "Orqaga") {
                showDeleviryType();
            } else {
                chooseButtons();
            }

            break;
        case "ready":
            if ($text == "Boshqa buyurtma berish") {
                showMain();
            } else {
                chooseButtons();
            }

            break;
        default :
            break;
    }
}

function showMain()
{
    global $telegram, $chat_id, $firstName, $lastName;
    setPage($chat_id, 'main');

    $option = array(
        //First row
        array($telegram->buildKeyboardButton("🍯 Batafsil ma'lumot")),
        //Second row
        array($telegram->buildKeyboardButton("🍯 Buyurtmani berish")),
    );
    $keyb = $telegram->buildKeyBoard($option, true, true);
    $content = array('chat_id' => $chat_id, 'text' => "Assalomu alaykum, $firstName $lastName! 
Ushbu bot orqali siz Beeo asal-arichilik firmasidan tabiiy asal va asal mahsulotlarini sotib olishingiz mumkin!");
    $telegram->sendMessage($content);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Mening ismim Jamshid, ko'p yillardan beri oilaviy arichilik bilan shug'ullamib kelamiz. BeeO-asalchilkik firmamiz mana 3 yildirki, Toshkent shahri aholisiga toza, tabiiy asal yetkazib bermoqda va ko'plab xaridorlarga ega bo'ldik, shukurki, shu yil ham arichiligimizni biroz kengaytirib siz azizlarning ham dasturxoningizga tabiiy toza asal yetkazib berishni niyat qildik");
    $telegram->sendMessage($content);
}

function showAbout()
{
    global $telegram, $chat_id;
    $option = array(
        //First row
        array($telegram->buildKeyboardButton("🍯 Batafsil ma'lumot")),
        //Second row
        array($telegram->buildKeyboardButton("🍯 Buyurtmani berish"))
    );
    $keyb = $telegram->buildKeyBoard($option, true, true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => 'Biza haqimzda quyidagi <a href="https://telegra.ph/Asal-08-05">Havola</a> orqali bilib olishingiz mumkin', 'parse_mode' => 'html');
    $telegram->sendMessage($content);
}

function showMassa()
{
    global $telegram, $chat_id;
    setPage($chat_id, 'mass');

    $option = array(
        //First row
        array($telegram->buildKeyboardButton("🍯 1kg - 35 000 som")),
        //Second row
        array($telegram->buildKeyboardButton("🍯 2 kg - 60 000 som")),
        ///Third row
        array($telegram->buildKeyboardButton("Orqaga"))
    );
    $keyb = $telegram->buildKeyBoard($option, true, true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => 'Kerakli vaznni tanlang');
    $telegram->sendMessage($content);
}

function showPhone()
{
    global $chat_id;
    setPage($chat_id, 'phone');
    global $telegram, $chat_id;
    $option = array(
        array($telegram->buildKeyboardButton("Raqamingizni jonating", true)),
        array($telegram->buildKeyboardButton("Orqaga"))
    );
    $keyb = $telegram->buildKeyBoard($option, true, true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => " Hajm tanlandi, endi bizga siz bilan bog'lanishimiz uchun raqamingizni jo'nating!");
    $telegram->sendMessage($content);
}

function showDeleviryType()
{
    global $telegram, $chat_id;
    setPage($chat_id, "delivery");
    $option = array(
        //First row
        array($telegram->buildKeyboardButton("✈ Yetkazib berish ✈")),
        //Second row
        array($telegram->buildKeyboardButton("🍯 Borib olish 🍯")),
        ///Third row
        array($telegram->buildKeyboardButton("Orqaga"))
    );
    $keyb = $telegram->buildKeyBoard($option, true, true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Bizda Toshkent shahri bo'ylab yetkazib berish hizmati mavjud!");
    $telegram->sendMessage($content);

}

function showInputLocation()
{
    global $telegram, $chat_id;
    setPage($chat_id, "location");

    $option = array(
        //First row
        array($telegram->buildKeyboardButton("Lokatsiya jo'natish", false, true)),
        //Second row
        array($telegram->buildKeyboardButton("Lokatsiya jo'nata olmayman")),
        ///Third row
        array($telegram->buildKeyboardButton("Orqaga"))
    );
    $keyb = $telegram->buildKeyBoard($option, true, true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Yaxshi, endi, lokatsiya jo'nating!");
    $telegram->sendMessage($content);

}

function showReady()
{
    global $telegram, $chat_id, $ADMIN_CHAT_ID;
    setPage($chat_id, "ready");
    $option = array(

        array($telegram->buildKeyboardButton("Boshqa buyurtma berish"))
    );
    $keyb = $telegram->buildKeyBoard($option, true, true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Sizning buyurtmangiz qabul qilindi. Marhamat boshqa buyurtma berishingiz mumkin!");
    $telegram->sendMessage($content);

    // SEND ADMIN
    $text = "Yangi buyurtma keldi:";
    $text .= "\n";
    $text .= "Hajm: " . getMass($chat_id);
    $text .= "\n";
    $text .= "Telefon raqam: " . getPhone($chat_id);
    $text .= "\n";


    $content = array('chat_id' => $ADMIN_CHAT_ID, 'reply_markup' => $keyb, 'text' => $text);
    $telegram->sendMessage($content);
    if (getLatitude($chat_id) != "") {
        $content = array('chat_id' => $ADMIN_CHAT_ID, 'latitude' => getLatitude($chat_id), 'longitude' => getLongitude($chat_id));
        $telegram->sendLocation($content);
    }
}

function chooseButtons()
{
    global $telegram, $chat_id;

    $content = array('chat_id' => $chat_id, 'text' => "Iltimos, quyidagi tugmalardan birini tanlang!");
    $telegram->sendMessage($content);

}

