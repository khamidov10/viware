
<div class="row p-3 bg-white rounded">

     
      <div class="table-responsive">
       <table class="table table-bordered">
        <thead>
            <tr>
               <th width="5%">Logo</th>
                <th>Nomi</th>
                <th>STIR (INN)</th>
<th>Aylanma</th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            $dillers = $db->query("SELECT * FROM users WHERE type=2");
                            $today = date("Y-m-01 00:00:00");
                $end = date("Y-m-").cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"))." 23:59:59";
                echo "$today - $end <hr>";
            while($diller=$dillers->fetch_assoc()){
                $total = 0;
              $orders = $db->query("SELECT * FROM orders WHERE date BETWEEN '$today' AND '$end' AND diller={$diller['id']}");
            while($order = $orders->fetch_assoc()){
                $totalSumm = $db->query("SELECT SUM(count*price) as total FROM order_items WHERE order_id={$order['id']}");
                $totalSumm = $totalSumm->fetch_assoc();
                $total = $totalSumm['total'];
            }
                echo "
                <tr>
                <td><img class='d-block w-100' src='{$diller['logo']}'></td>
                    <td>{$diller['name']}</td>
                    <td>{$diller['inn']}</td>
                    <td>".number_format($total, 0, '', ' ')."</td>

                </tr>
                ";
            }
            ?>
        </tbody>
    </table>
    </div>
</div>