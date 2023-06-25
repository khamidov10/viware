<?php
if(isset($_GET['action'])){
    $sabab = "";
    $reason = "";
   if($_GET['action']==2){$icon = "✅"; $st = "yetkazildi";}
    if($_GET['action']==3){
        $reason = mysqli_real_escape_string($db,$_POST['reason']);
        $sabab = "Sabab: $reason";
        $icon = "❌"; $st = "bekor qilindi";
    }
    $zakaz = $db-> query("SELECT * FROM orders WHERE id={$_GET['id']}")->fetch_assoc();
if($zakaz['status']==1){
    $zakazchik = $db-> query("SELECT * FROM users WHERE id={$zakaz['client']}")->fetch_assoc();
$seller = $db-> query("SELECT * FROM users WHERE id={$zakaz['diller']}")->fetch_assoc();
    $update = $db->query("UPDATE orders SET status='{$_GET['action']}', reason='$reason' WHERE id='{$_GET['id']}'");
$zakazItems = $db->query("SELECT * FROM order_items WHERE order_id={$zakaz['id']}");
    while($zakazItem = $zakazItems->fetch_assoc()){
        $updating = $db->query("UPDATE products SET stock=(SELECT stock FROM (SELECT stock FROM products WHERE id={$zakazItem['product']}) as sklad)-{$zakazItem['count']} WHERE id={$zakazItem['product']}");
        echo $db->error;
    }

$content = array('chat_id' => $zakazchik['telegram'], 'text' => "$icon {$zakaz['date']} dagi №{$zakaz['id']} sonli buyurtma yetkazib beruvchi tomonidan $st.
$sabab");
$telegram->sendMessage($content);
$content = array('chat_id' => $seller['telegram'], 'text' => "$icon {$zakaz['date']} dagi №{$zakaz['id']} sonli buyurtma $st
$sabab");
$telegram->sendMessage($content);
}
}

$status = [
  1=>"<b class='text-info'>Yangi</b>",
    2=>"<b class='text-primary'>Yetkazilgan</b>",
    3=>"<b class='text-danger'>Bekor qilingan</b>"
];
?>

<div class="row bg-white p-3 rounded">
  <div class="col-12">
      <div class="alert alert-info">
          <?php
                $today = date("Y-m-01 00:00:00");
                $end = date("Y-m-").cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"))." 23:59:59";
                echo date("Y-m-01")." - ".date("Y-m-").cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"))." oralig'idagi aylanma: ";

              $jamis = $db->query("SELECT * FROM orders WHERE date BETWEEN '$today' AND '$end' AND diller='{$_SESSION['userId']}' AND status!=3");
            while($jami = $jamis->fetch_assoc()){
                $totalSumm = $db->query("SELECT * FROM order_items WHERE order_id={$jami['id']}");
                while($totalS = $totalSumm->fetch_assoc()){
                    $total = ($totalS['count']*$totalS['price'])+$total;
                    }

            }
                echo number_format($total, 0, '', ' ')." so'm";
                echo "<hr>";
                $today = date("Y-m-d 00:00:00");
                $end = date("Y-m-d")." 23:59:59";
                echo "Bugungi aylanma: ";
            $total = 0;
              $jamis = $db->query("SELECT * FROM orders WHERE date BETWEEN '$today' AND '$end' AND diller='{$_SESSION['userId']}' AND status!=3");
            while($jami = $jamis->fetch_assoc()){
                $totalSumm = $db->query("SELECT * FROM order_items WHERE order_id={$jami['id']}");
                while($totalS = $totalSumm->fetch_assoc()){
                    $total = ($totalS['count']*$totalS['price'])+$total;
                    }

            }
                echo number_format($total, 0, '', ' ')." so'm";

          ?>
      </div>
  </div>
   <div class="table-responsive">
    <table class="table table-bordered table-striped mb-0">
    <thead>
        <tr>
        <th>№</th>
            <th>Mijoz</th>
            <th>Sana</th>
            <th>Holati</th>
            <th width="35%">O'zgartirish</th>
            <th>Batafsil</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $orderlar = $db->query("SELECT * FROM orders WHERE diller={$_SESSION['userId']} ORDER BY id DESC");
        while($order=$orderlar->fetch_assoc()){
            $okDisabled = "";
            $cancelDisabled ="";
           $client = $db->query("SELECT * FROM users WHERE id={$order['client']}")->fetch_assoc();
        if($order['status']==2){
            $okDisabled = "disabled";
            $cancelDisabled = "disabled";
        }
        if($order['status']==3){
           $okDisabled = "disabled";
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
                    <div class='col-md-6'>
                   <div class='d-grid'>
                   <a class='btn btn-success $okDisabled' href='/?go=$go&action=2&id={$order['id']}'><i class='la la-check'></i> Yetkazildi</a>
                </div></div>
                    <div class='col-md-6'>
                    <div class='d-grid'>
                    <a cancelid='{$order['id']}' data-bs-toggle=\"modal\" data-bs-target=\"#cancelOrder\" class='btn btn-danger $cancelDisabled'><i class='la la-close'></i> Bekor qilish</a>
                   </div> </div>

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
<!-- Modal -->
<form class="modal fade" id="cancelOrder" tabindex="-1" aria-labelledby="cancelOrderLabel" aria-hidden="true" method="POST" action="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cancelOrderLabel">Bekor qilish</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <label for="reason">Bekor qilish sababini kiriting</label>
        <textarea name="reason" required id="reason" cols="30" rows="10" class="form-control" placeholder="Bekor qilish sababi"></textarea>
      </div>
      <div class="modal-footer">
        <a type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yopish</a>
        <button name="cancel" class="btn btn-danger">Bekor qilish</button>
      </div>
    </div>
  </div>
</form>