<?php
$dill = $db->query("SELECT * FROM users WHERE id={$_SESSION['userId']}")->fetch_assoc();
$prods = $db->query("SELECT id FROM products WHERE diller={$_SESSION['userId']}");
while($prod = $prods->fetch_assoc()){
    $products[]=$prod['id'];
}
$products = implode(",",$products);
$order = $db->query("SELECT * FROM order_items WHERE order_id={$_GET['id']} AND product IN ($products)");

$orderinfo = $db->query("SELECT * FROM orders WHERE id={$_GET['id']}")->fetch_assoc();
$client = $db->query("SELECT * FROM users WHERE id={$orderinfo['client']}")->fetch_assoc();
$region = $db->query("SELECT name FROM districts WHERE id={$client['tuman']}")->fetch_assoc();
$status = [
  1=>"<b class='text-info'>Yangi</b>",
    2=>"<b class='text-primary'>Yetkazilgan</b>",
    3=>"<b class='text-danger'>Bekor qilingan</b>"
];
?>
<div class="row bg-white rounded p-3">
  <p class="text-end"><a class="btn btn-primary text-white" onClick="javascript:CallPrint('print-content');" title="Распечатать проект"><i class="la la-print"></i></a>
  </p>
  <print id="print-content">
    <style>
        @media print {
            .comment {
                height: 50px;
            }

            table {
                border-collapse: collapse;
                width: 95%;
                margin: 0 auto;
            }

            table,td,tr,thead,tbody,th {
                border: 1px solid #000;
            }
            .nag{
                display:inline-block;padding:0 2px !important;margin-right:5px;background:#ccc;color:#fff;border-radius:5px;
            }
        }
    </style>
   <h2 class="text-center text-primary">
        Buyurtma haqida
    </h2>

   <table class="table table-bordered w-50 mx-auto">
       <tr>
           <td class="w-50">Buyurtma kodi</td>
           <td><b><?php echo  $orderinfo['id'];?></b></td>
       </tr>
       <tr>
           <td>Buyurtma holati</td>
           <td><?php echo $status[$orderinfo['status']];?></td>
       </tr>
       <tr>
           <td>Buyurtma sanasi</td>
           <td><b><?php echo  $orderinfo['date'];?></b></td>
       </tr>
       <tr>
           <td>Yetkazib beruvchi</td>
           <td><b><?php echo $dill['name'];?></b></td>
       </tr>
       
       <tr>
           <td>Buyurtmachi</td>
           <td><b><?php echo $client['name'];?></b></td>
       </tr>
       <tr>
           <td>Buyurtmachi STIR (INN) raqami</td>
           <td><b><?php echo $client['inn'];?></b></td>
       </tr>
       <tr>
           <td>Telefon raqami</td>
           <td><b><a href="tel:+998<?php echo $client['phone'];?>">+998<?php echo $client['phone'];?></a></b></td>
       </tr>
       <tr>
           <td>Manzil</td>
           <td><b><?php echo $region['name'].", ".$client['adress'];?></b></td>
       </tr>
        <tr>
           <td>Mo'ljal</td>
           <td><b><?php echo $client['orientr'];?></b></td>
       </tr>
       <tr class="comment">
           <td class="">Izoh</td>
           <td><?php echo $orderinfo['reason']?></td>
       </tr>
   </table>


    <h2 class="text-center text-primary">
        Buyurtma cheki
    </h2>
    <table class="table table-bordered mx-auto" style="width:90% !important">
        <thead>
          <tr class="bg-primary text-white">
                <th>Mahsulot</th>
                <th>O'lchov birligii</th>
                <th>narx</th>
                <th>Jami</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while($item = $order->fetch_assoc()){
          $old_price = "";
        $old_all_price = "";
      $product = $db->query("SELECT name,unit,price FROM products WHERE id='{$item['product']}'")->fetch_assoc();

    $unit = $db->query("SELECT name_uz FROM units WHERE id='{$product['unit']}'")->fetch_assoc();
                $price = $item['price']*$item['count'];
                if($product['price']!=$item['price']){
                   $old_price =  number_format($product['price'], 0, '', ' ');
                    $old_all_price = number_format($product['price']*$item['count'], 0, '', ' ');
                }
                $nagruzka = "";
                if($item['load_prod']==1){
                    $nagruzka = "<span class='nag' style='display:inline-block;padding:0 2px !important;margin-right:5px;background:red;color:#fff;border-radius:5px;'><small>нагрузка</small></span>";
                }
                echo "
                <tr>
                <td>$nagruzka {$product['name']}</td>
                <td><b>{$item['count']}</b> {$unit['name_uz']}</td>
                <td><del class='text-danger'>$old_price</del> ".number_format($item['price'], 0, '', ' ')."</td>
                <td><del class='text-danger'>$old_all_price </del> ".number_format($price, 0, '', ' ')." </td>
                </tr>";
            $itogo = $price+$itogo;
            }

            ?>
        <tr class="bg-info">
            <th>Jami</th>
            <th colspan="3" class="text-end"><?php
            $itog_disc = $itogo*((100-$orderinfo['discount'])/100);
            if($itogo!=$itog_disc){

                echo 'Chegirmasiz: <small><del class="text-danger me-4">';
                echo number_format($itogo, 0, '', ' ')." </del> </small> ";
            }
                ?>To'lov uchun jami: <?php echo  number_format($itog_disc, 0, '', ' ');?></th>
        </tr>
        </tbody>
    </table>
    </print>
</div>
<script>
function CallPrint(strid) {
  var prtContent = document.getElementById(strid);
  var WinPrint = window.open('','','left=50,top=50,width=800,height=640,toolbar=0,scrollbars=1,status=0');
  WinPrint.document.write('');
  WinPrint.document.write(prtContent.innerHTML);
  WinPrint.document.write('');
  WinPrint.document.close();
  WinPrint.focus();
  WinPrint.print();
  WinPrint.close();
  prtContent.innerHTML=strOldOne;
}
</script>
