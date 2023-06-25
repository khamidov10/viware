  <div style="padding:1rem;" >
<?php
$basket = $db->query("SELECT * FROM basket WHERE user={$_SESSION['userId']} GROUP BY diller");
while($card = $basket->fetch_assoc()){
    
    $dName = $db->query("SELECT * FROM users WHERE id={$card['diller']}")->fetch_assoc();
    echo "   <ul class=\"row list-unstyled py-2 px-2  text-white rounded position-relative border border-white\" style='background:rgb(111, 138, 213,0.5)' >
    
     <li class=\"text-center bg-primary text-white rounded shadow-sm\"><h4>{$dName['name']}</h4></li>
    ";
    
    $items = $db->query("SELECT * FROM basket WHERE diller={$card['diller']} AND user={$_SESSION['userId']} ORDER BY load_prod ASC,id DESC");
    $allWithOutDis = 0;
$allWithDis = 0;
    while($item=$items->fetch_assoc()){
        $nagruzka = "";
        $color = "";
        if($item['load_prod']>0){
           $nagruzka = "<div class='text-center text-white'><small>Нагрузка</small></div>"; 
            $color = "background:#dc354591;";
        }
        $prod = $db->query("SELECT * FROM products WHERE id={$item['product']}")->fetch_assoc();
        $unit = $db->query("SELECT * FROM units WHERE id={$prod['unit']}")->fetch_assoc();
        echo "
              <li style='$color' class=\"col-12 my-2 border-bottom border-white rounded my-1 position-relative\">
           ";
        echo $nagruzka;
         if($item['load_prod']!=1){
             echo "<span delete=\"{$item['id']}\" class=\"position-absolute text-light\" style=\"font-size:2em;top:1%;right:1%;cursor:pointer\"><i class=\"la la-trash\"></i></span>";
         }   
            
        
        echo"
        	<div class=\"row\">
        		<!-- <div class=\"col-md-3 d-flex align-items-center\">
        		<a><img src=\"{$prod['photo']}\" width=\"100%\"></a>
        	</div> -->
        	<div class=\"col-md-12\">
        	<div class=\"row\">
        		<div class=\"col-12\"><p class=\"m-0\"><b> {$prod['name']} </b></p></div>
        		<div class=\"col-12\"><b>{$item['count']}</b>(<small><i>{$unit['name_uz']}</i></small>) x <b>".number_format($item['price'], 0, '', ' ')."</b> so'm</div>
                <div></div>
               <div class=\"col-12\">Jami: <b>";
        echo number_format($item['count']*$item['price'], 0, '', ' ');
        echo "</b></div> 
        		<div class=\"col-12\">Chegirma: <b>{$item['disc']}</b>%</div>
               <div class=\"col-12\">Jami: ";
        $wiThoutDis = $item['count']*$item['price'];
       $widthDis = $wiThoutDis*((100-$item['disc'])/100);
        echo number_format($widthDis, 0, '', ' '); echo " so'm</div>
                
        	</div>
        	</div>
        	

        	</div>
        </li>
        ";
       $allWithOutDis =  $wiThoutDis + $allWithOutDis;
    $allWithDis = $widthDis + $allWithDis;
    }
    
    
    
    
    
    
    
    $dis = $db->query("SELECT * FROM discounts WHERE diller={$card['diller']}")->fetch_assoc();
    $skidka = false;
    $dis_text = "";
    $discount = 0;
    if($dis['id']>0){
        $skidka = true;
    }
    if($skidka){
        $dis_type = $dis['dis_type'];
    $dis_min = $dis['dis_min'];
    if($dis_type == 1){
        $count = $db->query("SELECT * FROM basket WHERE user={$_SESSION['userId']} AND diller={$card['diller']} AND load_prod!=1 GROUP BY product");
        $now = $count->num_rows;
    }
    if($dis_type == 2){
        $count = $db->query("SELECT * FROM basket WHERE user={$_SESSION['userId']} AND diller={$card['diller']} GROUP BY product");
        $now = $allWithDis;
    }
    if($now>=$dis_min){
        $allWithDis = $allWithDis * ((100-$dis['dis'])/100);
        $discount = $dis['dis'];
    }
      $foiz = $now/$dis_min*100;
        if($foiz > 100){
            $foiz = 100;
        }
        $p_color = "danger";
        if($foiz == 100){
            $p_color = "success";
        }
        $dis_text = "
        <li class=\"text-center\"><b><b>$foiz</b> % to'ldi</b></li>
            <li class=\"text-center\">
    <div class=\"progress bg-white\">
  <div class=\"progress-bar progress-bar-striped progress-bar-animated bg-$p_color\" role=\"progressbar\" aria-valuenow=\"75\" aria-valuemin=\"0\" aria-valuemax=\"$foiz\" style=\"width: $foiz%\"></div>
</div>
<li class=\"text-center\"><b>Umumiy chegirma:<b>{$dis['dis']}</b> %</b></li>
        ";
    
    }
    if($allWithOutDis!=$allWithDis){
        echo "<li class=\"text-center\"><b>Chegirmasiz:<b> <del>".number_format($allWithOutDis, 0, '', ' ')
." </del></b> so'm</b></li>";
    }
    echo "
    $dis_text
    </li>
    
    <li class=\"text-center\"><b>Jami to'lov uchun: <b> ".number_format($allWithDis, 0, '', ' ')." </b> so'm</b></li>
      <li>";
    $orderDisabled = "";
    $minText = "";  
    if($allWithDis<$dName['minimal']){
        $orderDisabled = "disabled";
        $minText = "<p class='text-white text-center'><b>Minimal summa {$dName['minimal']} so'm</b></p>";
    }
    
        echo "<div class=\"d-grid\">
              <button $orderDisabled ordering='{$card['diller']}' disc='$discount' class=\"btn btn-light\">Buyurtma qilish</button>
              $minText
          </div>
      </li>
</ul>";
$orderAll = $allWithDis+$orderAll;
$orderAllWithoutDis = $allWithOutDis +  $orderAllWithoutDis;
}
?>


		     
		 </div>   
           <?php 
if($orderAll>0){
?><h3 class="bg-white text-center" style="position:sticky;bottom:0;left:0; width:100%">Jami: <?php echo number_format($orderAll, 0, '', ' ');?> so'm</h3>
    <?} else {
    echo '<h3 class="bg-white text-center" style="position:sticky;bottom:0;left:0; width:100%">Savatcha bo\'sh</h3>';
}?>
<script>
$("[delete]").click(function(){
    $id = $(this).attr("delete")
    $.ajax({
        url:"/__ajax/__ajax_basket.php",
        type:"POST",
        data:{delCard:1,id:$id},
        cache:false,
        success:function($basket){
         $("#basketBody").html($basket)   
        }
    })
})
</script>    
<script>
$("[ordering]").click(function(){
    $diller = $(this).attr("ordering")
    $disc = $(this).attr("disc")
    $.ajax({
        url:"/__ajax/__ajax_basket.php",
        type:"POST",
        data:{ordering:1,diller:$diller,disc:$disc},
        cache:false,
        success:function($basket){
         $("#basketBody").html($basket)   
        }
    })
})
</script>   
<!-- Button trigger modal -->


<!-- Modal -->

