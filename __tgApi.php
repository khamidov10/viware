<?php
include "__conn_db_config_file_.php";

$result = $telegram->getData();
$text = $result['message'] ['text'];
$chat_id = $result['message'] ['chat']['id'];
if($text = "/start"){
    $content = array('chat_id' => $chat_id, 'text' => "Sizning telegram id:");
$telegram->sendMessage($content);
    $content = array('chat_id' => $chat_id, 'text' => "$chat_id");
$telegram->sendMessage($content);
$content = array('chat_id' => $chat_id, 'text' => "Ushbu ID raqam ro'yxatdan o'tish davomida ko'rsatib o'tiladi.");
$telegram->sendMessage($content);
}

?>
