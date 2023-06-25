<?php
$db = new mysqli("localhost","admin_vw","2rRBa*Qf","admin_vw");
$set = $db -> set_charset("utf8");
include 'Telegram.php';
$telegram = new Telegram('1713831536:AAHBS31_jvemcXQsZL7zGxjLKjPSpwq6tzw');
?>
