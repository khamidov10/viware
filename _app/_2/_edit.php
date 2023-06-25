<?php
$product = $db->query("SELECT * FROM products WHERE id={$_GET['id']} AND diller={$_SESSION['userId']}");
if($product->num_rows>0){
    $prod = $product->fetch_assoc();

    $discount = [
        0=>"Chegirmasiz",
        1=>"Shartli",
        2=>"Shartsiz"
    ];
    $unit_prod = $db->query("SELECT * FROM units WHERE id={$prod['unit']}")->fetch_assoc();
    $cat_prod = $db->query("SELECT * FROM category WHERE id={$prod['category']}")->fetch_assoc();
    ?>

   <form class="row bg-white p-3 rounded" action="/?go=main&p=<?php echo $_GET['pn'];?>" method="POST" enctype="multipart/form-data">
   <input type="hidden" name="old_photo" value="<?php echo $prod['photo'];?>">
    <div class="col-lg-4">
      <label for="name">Tovar nomi</label>
       <input class="form-control form-control-lg" type="text" placeholder="Tovar nomi" aria-label="Tovar nomi" name="name" id="name" required autocomplete="off" value="<?php echo $prod['name'];?>">
    </div>
       <div class="col-lg-3 mb-3">
      <label for="cat">Bo'lim</label>
       <select class="form-select form-select-lg"  aria-label="Tovar nomi" name="cat" id="cat" autocomplete="off" required>
         <option value="<?php echo $cat_prod['id'];?>"><?php echo $cat_prod['name_uz'];?></option>
        <?php
        $cats = $db -> query("SELECT * FROM category");
        while($cat = $cats->fetch_assoc()){
            if($cat['id']!=$prod['category']){
                echo "
            <option value='{$cat['id']}'>{$cat['name_uz']}</option>
            ";
            }
        }

        ?>

        </select>

    </div>
    <div class="col-lg-3 mb-3">
      <label for="unit">O'lchov birligi</label>
       <select class="form-select form-select-lg"  aria-label="Tovar nomi" name="unit" id="unit" autocomplete="off" required>
        <option value="<?php echo $unit_prod['id'];?>"><?php echo $unit_prod['name_uz'];?></option>
        <?php

        $units = $db -> query("SELECT * FROM units");
        while($unit = $units->fetch_assoc()){
            if($unit['id']!=$prod['unit']){
                echo "
            <option value='{$unit['id']}'>{$unit['name_uz']}</option>
            ";
            }
        }

        ?>

        </select>

    </div>
    <div class="col-lg-2">
      <label for="stock">Omborda</label>
       <input class="form-control form-control-lg" type="number" placeholder="Mavjud"name="stock" id="stock" required autocomplete="off" value="<?php echo $prod['stock'];?>">
    </div>
    <div class="col-lg-3 mb-3">
      <label for="min">Minimal buyurtma</label>
       <div class="input-group">
  <input type="number" class="form-control form-control-lg" placeholder="Minimal" aria-label="Minimal" min="1" value="<?php echo $prod['min'];?>" name="min" id="min" aria-describedby="min_unit">
  <span class="input-group-text" id="min_unit"><?php echo $unit_prod['name_uz'];?></span>
</div>

    </div>



        <div class="col-lg-4 mb-3">
      <label for="price">Narxi</label>
     <div class="input-group">
     <span class="input-group-text" id="price_areapre"><?php echo $unit_prod['name_uz'];?></span>
      <input type="number" class="form-control form-control-lg" placeholder="Narxi" aria-label="Narxi" min="100" name="price" id="price" aria-describedby="price_area" autocomplete="off" value="<?php echo $prod['price'];?>">
      <span class="input-group-text" id="price_area">so'm</span>
    </div>

    </div>
 <div class="col-lg-5 mb-3">
 <div class="row">
     <div class="col-3">

   <img src="<?php echo $prod['photo']?>" width="100%">
     </div>
     <div class="col-9">
        <label for="photo">Rasmni O'zgartirish</label>
         <input id="photo" name="photo" type="file" class="form-control "  accept="image/*">
     </div>
 </div>


</div>

 <div class="col-lg-3 mb-3">
<label for="discount_type">Chegirma</label>
<select name="discount_type" id="discount_type" class="form-select form-select-lg">
   <?php
    echo "<option value='{$prod['discount_type']}'>{$discount[$prod['discount_type']]}</option>";
    foreach($discount as $num=>$disc){
        if($num!=$prod['discount_type']){
            echo "<option value='$num'>$disc</option>";
        }
    }
    ?>

</select>

</div>
<div class="col-lg-3 mb-3">
   <label for="discount_price">narx</label>
    <div class="input-group">
     <?php
    $disabled = "disabled";
    if($prod['discount_price']>0){
        $disabled = "";
    }
        ?>
      <input type="number" class="form-control form-control-lg" placeholder="0" aria-label="0" name="discount_price" id="discount_price" aria-describedby="discount_price_area" <?php echo $disabled;?>  required value="<?php echo $prod['discount_price'];?>">
      <span class="input-group-text" id="discount_price_area">dan oshsa</span>
    </div>
</div>

<div class="col-lg-2 mb-3">
   <label for="discount">Chegirma O'lchov birligi</label>

    <div class="input-group">
     <?php
    $disabled = "disabled";
    if($prod['discount']>0){
        $disabled = "";
    }
        ?>
      <input type="number" class="form-control form-control-lg" placeholder="Chegirma" aria-label="Chegirma" name="discount" id="discount" aria-describedby="discount_area" <?php echo $disabled;?> required value="<?php echo $prod['discount'];?>">
      <span class="input-group-text" id="discount_area" >%</span>
    </div>
</div>
<div class="col-lg-2 mb-3">
   <label for="new">NEW belgisi</label>
<?php
$onoff = [
    0=>"O'chirilgan",
    1=>"Yoqilgan"
    ];
?>
    <div class="input-group">
    <select name="new" class="form-select form-select-lg">
        <option value="<?Php echo $prod['new'];?>"><?php echo $onoff[$prod['new']];?></option>
        <?php

        if($prod['new']==0){
            echo '<option value="1">Yoqilgan</option>';
            } else {
           echo '<option value="0">O\'chirilgan</option>';
            }

        ?>
    </select>
    </div>

</div>
<div class="col-lg-2 mb-3">
   <label for="rec">Tavsiya belgisi</label>
<?php
$onoff = [
    0=>"O'chirilgan",
    1=>"Yoqilgan"
    ];
?>
    <div class="input-group">
    <select name="rec" class="form-select form-select-lg">
        <option value="<?Php echo $prod['rec'];?>"><?php echo $onoff[$prod['rec']];?></option>
        <?php

        if($prod['rec']==0){
            echo '<option value="1">Yoqilgan</option>';
            } else {
           echo '<option value="0">O\'chirilgan</option>';
            }

        ?>
    </select>
    </div>
     </div>
<div class="col-lg-12">
   <hr>
    <div class="d-grid">
        <button class="btn btn-primary btn-lg" name="edit" value="<?php echo $prod['id'];?>">Saqlash</button>
    </div>
</div>
</form>
    <?
}
else {
  include __DIR__."/_main.php";
}
?>
