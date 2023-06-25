<?php
date_default_timezone_set('Asia/Tashkent');

session_start();
function shifr($data){
    $pass = base64_encode(md5("orderline_".md5("@key_$data")));
    return $pass;
}
include "__conn_db_config_file_.php";
if(isset($_POST)){
    foreach($_POST as $key=>$value){
        if(is_array($_POST[$key])){
            foreach($_POST[$key] as $key1=>$value1){
                $_POST[$key][$key1] = $db->real_escape_string($value1);
            }
        } else {
            $_POST[$key] = $db->real_escape_string($value);
        }
    }
}
if(isset($_GET['out'])){
    unset($_SESSION['userId']);
    unset($_SESSION['type']);
}

if($_POST['sign']=="in"){
    $pass =$_POST['pass'];
$pass = shifr($pass);

    $user = $db -> query("SELECT * FROM users WHERE inn='{$_POST['login']}' AND password='$pass'");
    if($user->num_rows>0){
        $user = $user->fetch_assoc();
        $_SESSION['userId'] = $user['id'];
        $_SESSION['type'] = $user['type'];
    } else {
        $message = "error";
    }
}
if($_SESSION['userId']>0){
    $type = $_SESSION['type'];
    $app = __DIR__."/_app/_type_$type";
}
else {
    $app = "login";
}

if(isset($_POST['reg'])){
$check = $db->query("SELECT * FROM users WHERE inn={$_POST['form']['inn']} OR phone={$_POST['form']['phone']}");
if($check->num_rows>0){$message="double"; /*$app="register"*/;}
else {
    foreach($_POST['form'] as $key=>$value){
        if($key == 'password'){
            $parol = $_POST['form']['password'];
            $value = shifr($value);
        }
        $keys[] = $key;
        $values[] = "'$value'";
    }

    $keys = implode(",",$keys);
    $values = implode(",",$values);

      $result = $db->query("INSERT INTO users ($keys) VALUES ($values)");
        if($result){
            include "_send.php";
           $sms = [
                    "mobile_phone" => "998".$_POST['form']['phone'],
                    "message" => "Viware.uz:
Saytga kirish uchun parol: $parol"
            ];

    $response = $gateway->sendSMS($sms);
    

            $message="regTrue";
        } else {
                $message="regFalse";
                /*$app="register";*/
                }
    }

}







include "$app.php";
?>
