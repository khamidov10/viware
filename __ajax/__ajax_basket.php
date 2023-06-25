<?php
date_default_timezone_set('Asia/Tashkent');

session_start();
include $_SERVER['DOCUMENT_ROOT']."/__conn_db_config_file_.php";

if(isset($_POST['addCard'])){

    $disc = 0;
    $prod = $_POST['prod'];
    $count = $_POST['count'];
    $diller = $_POST['diller'];
    $user = $_POST['user'];

    $product = $db->query("SELECT * FROM products WHERE id=$prod")->fetch_assoc();
    $price = $product['price'];
    if($product['discount_type']==2){
        $disc = $product['discount'];
    }
$firstTime = $db->query("SELECT * FROM basket WHERE user='$user' AND diller='$diller'")->num_rows;
if($firstTime>0){

} else {
    $nagruzka = $db->query("SELECT * FROM load_prod WHERE diller='$diller'");
    while($nag = $nagruzka->fetch_assoc()){
    $load_price = $db->query("SELECT * FROM products WHERE id='{$nag['add_prod']}'")->fetch_assoc()['price'];

        $addLoad = $db->query("INSERT INTO basket (diller,user,product,count,price,disc,load_prod) VALUES ('$diller','$user','{$nag['add_prod']}','{$nag['count']}','$load_price','0',1)");
    }
}

$fromBas = $db->query("SELECT* FROM basket WHERE user='$user' AND product='$prod'");
if($fromBas->num_rows>0){

   $thisItem = $fromBas->fetch_assoc();
    $count = $thisItem['count']+$count;

    if($product['discount_type']==1){
        if(($count*$price)>=$product['discount_price']){
            $disc = $product['discount'];
        }
    }
    $result = $db->query("UPDATE basket SET count='$count', price='$price', disc='$disc' WHERE id='{$thisItem['id']}'");
} else {

      if($product['discount_type']==1){
        if(($count*$price)>=$product['discount_price']){
            $disc = $product['discount'];
        }
    }
    $result = $db->query("INSERT INTO basket (diller,user,product,count,price,disc) VALUES ('$diller','$user','$prod','$count','$price','$disc')");

}





  include $_SERVER['DOCUMENT_ROOT']."/_app/_3/_basket.php";
}
elseif(isset($_POST['delCard'])){
    $detect = $db->query("SELECT * FROM basket WHERE id={$_POST['id']}")->fetch_assoc();
    $del = $db->query("DELETE FROM basket WHERE id='{$_POST['id']}'");
    $check = $db->query("SELECT * FROM basket WHERE diller={$detect['diller']} AND user={$detect['user']} AND load_prod!=1")->num_rows;
    if($check<1){
        $del = $db->query("DELETE FROM basket WHERE user='{$detect['user']}' AND diller='{$detect['diller']}' AND load_prod=1");
    }

    include $_SERVER['DOCUMENT_ROOT']."/_app/_3/_basket.php";
}
elseif(isset($_POST['ordering'])){
    $diller = $_POST['diller'];
    $chat_id = $db->query("SELECT * FROM users WHERE id=$diller")->fetch_assoc()['telegram'];
       $zakazchik = $db->query("SELECT * FROM users WHERE id={$_SESSION['userId']}")->fetch_assoc()['name'];
    $user = $_SESSION['userId'];
    $disc = $_POST['disc'];
    $date = date("Y-m-d H:i:s");
    $order = $db->query("INSERT INTO orders (client,date,status,discount,diller) VALUES ('$user','$date',1,'$disc','$diller')");
    $order_id = $db->insert_id;

    $items = $db->query("SELECT * FROM basket WHERE user='$user' AND diller='$diller'");
    while($item = $items->fetch_assoc()){
        $price = $item['price']*((100-$item['disc'])/100);
        $count = $count + 1;
        $order_item = $db -> query("INSERT INTO order_items (order_id,product,count,price,load_prod) VALUES ('$order_id','{$item['product']}','{$item['count']}','$price','{$item['load_prod']}')");
        if($order_item){
            $del = $db->query("DELETE FROM basket WHERE id='{$item['id']}'");
        }
}
    if($order){
        $content = array('chat_id' => $chat_id, 'text' => "Sizda $zakazchik tomonidan $count ta maxsulotga yangi buyurtma mavjud.");
$telegram->sendMessage($content);
 echo "<script>alert('Buyurtma jo`natildi.')</script>";
 }


    include $_SERVER['DOCUMENT_ROOT']."/_app/_3/_basket.php";
}
else {
    echo "Fuck You Bitch";
}


?>
