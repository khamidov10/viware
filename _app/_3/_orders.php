<?php
if(isset($_GET['action'])){
    if($_GET['action']==3){$icon = "❌"; $st = "bekor qilindi";}
    $zakaz = $db-> query("SELECT * FROM orders WHERE id={$_GET['id']}")->fetch_assoc();
$zakazchik = $db-> query("SELECT * FROM users WHERE id={$zakaz['client']}")->fetch_assoc();
$seller = $db-> query("SELECT * FROM users WHERE id={$zakaz['diller']}")->fetch_assoc();
    $update = $db->query("UPDATE orders SET status='{$_GET['action']}' WHERE id='{$_GET['id']}'");


    $update = $db->query("UPDATE orders SET status='{$_GET['action']}' WHERE id='{$_GET['id']}'");
    $content = array('chat_id' => $zakazchik['telegram'], 'text' => "$icon {$zakaz['date']} dagi №{$zakaz['id']} sonli buyurtma $st.");
$telegram->sendMessage($content);
$content = array('chat_id' => $seller['telegram'], 'text' => "$icon {$zakaz['date']} dagi №{$zakaz['id']} sonli buyurtma buyurtmachi tomonidan $st");
$telegram->sendMessage($content);
}

$status = [
  1=>"<b class='text-info'>Yangi</b>",
    2=>"<b class='text-primary'>Yetkazilgan</b>",
    3=>"<b class='text-danger'>Bekor qilingan</b>"
];
?>
<div class="row bg-white p-3 rounded">
   <div class="table-responsive">
    <table class="table table-bordered table-striped mb-0">
    <thead>
        <tr>
            <th>Id</th>
            <th>Mijoz</th>
            <th>Sana</th>
            <th>Holati</th>
            <th width="20%">O'zgartirish</th>
            <th>Batafsil</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $orderlar = $db->query("SELECT * FROM orders WHERE client={$_SESSION['userId']} ORDER BY id DESC");
        while($order=$orderlar->fetch_assoc()){
            $cancelDisabled ="";
           $client = $db->query("SELECT * FROM users WHERE id={$order['diller']}")->fetch_assoc();
        if($order['status']==2){
            $cancelDisabled = "disabled";
        }
        if($order['status']==3){
            $cancelDisabled = "disabled";
        }
            echo "
            <tr>
                <td>{$order['id']}</td>
                <td>{$client['name']}</td>
                <td>{$order['date']}</td>
                <td>{$status[$order['status']]}</td>
                <td>
                <div class='row'>

                    <div class='d-grid'>
                    <a onclick='return confirm(\"Haqiqatdan ham buyurtma bekor qilinsinmi?\")' class='btn btn-danger $cancelDisabled' href='/?go=$go&action=3&id={$order['id']}'><i class='la la-close'></i> Bekor qilish</a>
                   </div>

                </div>
                </td>
                <td><a class='btn btn-primary' href='/?go=orderview&id={$order['id']}'><i class='la la-eye'></i> Buyurtmani ko'rish</a></td>
            </tr>
            ";
        }

        ?>
    </tbody>
</table>
</div>
</div>
