<?php
            $d = 0;
            $s = 0;
            if(isset($_POST['rate'])){
                $dillers = $db->query("SELECT * FROM users WHERE type=2");
                            $today = date("Y-m-01 00:00:00");
                $end = date("Y-m-").cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"))." 23:59:59";

            while($diller=$dillers->fetch_assoc()){
                $total = 0;
              $orders = $db->query("SELECT * FROM orders WHERE date BETWEEN '$today' AND '$end' AND diller={$diller['id']}");
            while($order = $orders->fetch_assoc()){
                $totalSumm = $db->query("SELECT SUM(count*price) as total FROM order_items WHERE order_id={$order['id']}");
                $totalSumm = $totalSumm->fetch_assoc();
                $total = $totalSumm['total'];
            }
               $percent = ($total/$_POST['rate_to'])*100;
                $updating = $db->query("UPDATE users SET rating='$percent' WHERE id='{$diller['id']}'");
                $d++;
                if($updating){
$s++;}
                
            }
            $message = "<div class='alert alert-info my-2'>$d ta dillerdan $s tasi reytingi yangilandi.</div>";
            }
            ?>
<div class="row p-3 bg-white rounded">
     
    <form class="col-12" method="POST">
        <div class="row">
           <div class="col-12">
               <?php
               if(isset($message)){
                   echo $message;
               }
               ?>
           </div>
            <div class="col-3 offset-3">
            <input name="rate_to" type="number" placeholder="5 reyting uchun minimal aylanma" class="form-control">
        </div>
        <div class="col-3">
            <div class="d-grid">
                <button name="rate" class="btn btn-success">Hisoblash</button>
            </div>
        </div>
        </div>
    </form>
            

</div>