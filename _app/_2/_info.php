<?php
if(isset($_POST['photoChange'])){
     if($_FILES['logo']['size']>0){
      if($_FILES['logo']['size']<512000){
      $root = $_SERVER['DOCUMENT_ROOT'];
      if(!is_dir("$root/users")){
          mkdir("$root/users");
      }
      $format = end(explode(".",$_FILES['logo']['name']));
      $filename = md5(rand(1,9999).date("ymd_his-").rand(1,999999)).".$format";
      $upload = move_uploaded_file($_FILES['logo']['tmp_name'],"$root/users/$filename");
      $photo = "/users/$filename";

          if($upload){
              $result = $db->query("UPDATE users SET logo='$photo' WHERE id={$_SESSION['userId']}");
          }
      else{
          $message = [
          "type"=>"danger",
          "text"=>"Faylda xatolik"
      ];
      }
  }else {
      $message = [
          "type"=>"danger",
          "text"=>"Faylda xatolik"
      ];
  }
  }

}
if(isset($_POST['animate'])){
    $result = $db->query("UPDATE users SET aksiya='{$_POST['form']['aksiya']}', new='{$_POST['form']['new']}' WHERE id={$_SESSION['userId']}");
    }
if(isset($_POST['changepass'])){
    $old_pass = shifr($_POST['old_pass']);
    $new_pass = shifr($_POST['new_pass']);
    $check = $db->query("SELECT * FROM users WHERE password='$old_pass' AND id={$_SESSION['userId']}")->num_rows;
    if($check>0){
        $result = $db->query("UPDATE users SET password='$new_pass' WHERE id={$_SESSION['userId']}");
    } else {
        $message = [
            "type" => "danger",
            "text" => "Eski parol noto'g'ri kiritildi"
        ];
    }
}
if(isset($_POST['edit'])){
    foreach($_POST['form'] as $key=>$value){
        $query[] = "$key='$value'";
    }
    $query = implode(",",$query);
    $result = $db->query("UPDATE users SET $query WHERE id={$_SESSION['userId']}");
}
$dinfo = $db->query("SELECT * FROM users WHERE id={$_SESSION['userId']}")->fetch_assoc();
if(isset($_GET['del'])){
    $result = $db->query("DELETE FROM work_date WHERE id={$_GET['del']}");
}
if(isset($_POST['work_add'])){
        foreach($_POST['form'] as $key=>$value){
        $keys[] = $key;
        $values[] = "'$value'";
    }
     $keys = implode(",",$keys);

    $values = implode(",",$values);
    $result = $db->query("INSERT INTO work_date ($keys) VALUES ($values)");
}
if(isset($_POST['discount'])){
    $_POST['form']['diller'] = $_SESSION['userId'];
            foreach($_POST['form'] as $key=>$value){
        $keys[] = $key;
        $values[] = "'$value'";
    }
     $keys = implode(",",$keys);

    $values = implode(",",$values);
    $result = $db->query("INSERT INTO discounts ($keys) VALUES ($values)");
}
if(isset($_POST['saveDis'])){
   foreach($_POST['form'] as $key=>$value){
             $values[] = "$key='$value'";
    }

    $values = implode(",",$values);
    $result = $db->query("UPDATE discounts SET $values WHERE id={$_POST['saveDis']}");
}
if(isset($_GET['delDis'])){
    $result = $db->query("DELETE FROM discounts WHERE id={$_GET['delDis']}");
}
if(isset($result)){
    if($result){
        $message = [
          "type" => "success",
            "text" => "Ajoyib"
        ];
    } else {
        $message = [
          "type" => "danger",
            "text" => "Xatolik". $db->error
        ];
    }
}

$days = [
  1 => "Dushanba",
  2 => "Seshanba",
  3 => "Chorshanba",
  4 => "Payshanba",
  5 => "Juma",
  6 => "Shanba",
  7 => "Yakshanba"
  ];
?>
   <div class="row bg-white rounded p-3 mb-5 pb-5">
   <div class="col-6 offset-3">
            <?php
        if(isset($message)){
    echo "
    <div class='my-3  alert alert-{$message['type']} my-2' >{$message['text']}</div>
    ";
}
    ?>
   </div>
    <h2 class="text-center col-12">Hafta kunlari va ish vaqtlari</h2>
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Hafta kuni</th>
                        <th>Tuman</th>
                        <th>Ish vaqti (dan - gacha)</th>
                        <th width="5%"></th>
                    </tr>
                    <tr>
                       <form action="/?go=<?php echo $go;?>" method="POST">
                       <input type="hidden" name="form[diller]" value="<?php echo $_SESSION['userId'];?>">
                        <th>
                        <select name="form[day]" id="" class="form-select" required>
                            <?php
                            foreach($days as $key=>$value){
                                echo "<option value='$key'>$value</option>";
                            }
                            ?>
                        </select>
                        </th>
                        <th>
                        <select name="form[region]" id="" class="form-select" required>
                            <?php
                            $tumans = $db->query("SELECT* FROM districts WHERE region_id=13 ORDER BY name ASC");
                            while($tuman = $tumans->fetch_assoc()){
                                echo "<option value='{$tuman['id']}'>{$tuman['name']}</option>";
                            }
                            ?>
                        </select></th>

                        <th>
                        <div class="row">
                            <div class="col-6">
                                <input type="time" name="form[from_t]" class="form-control" required>
                            </div>
                            <div class="col-6">
                                <input type="time" name="form[to_t]" class="form-control" required>
                            </div>
                        </div>
                        </th>
                        <th width="5%"><button name="work_add" class="btn btn-primary">Qo'shish</button></th>
                        </form>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rows = $db->query("SELECT* FROM work_date WHERE diller={$_SESSION['userId']} ORDER by day ASC");
                    while($row = $rows->fetch_assoc()){
                        $region = $db->query("SELECT * FROM districts WHERE id={$row['region']}")->fetch_assoc();
                        echo "
                        <tr>
                        <td>{$days[$row['day']]}</td>
                        <td>{$region['name']}</td>
                        <td>{$row['from_t']} - {$row['to_t']} </td>
                        <td><div class=\"d-grid\">
                            <a onclick='return confirm(\"Haqiqatdan ham o`chirilsinmi?\")' href=\"/?go=$go&del={$row['id']}\" class=\"btn btn-danger\"><i class=\"la la-trash\"></i></a>
                        </div></td>
                    </tr>
                    ";
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <h2 class="text-center col-12 my-2">Mening ma'lumotlarim</h2>
     <form class="row" method="POST" action="/?go=<?php echo $go;?>">
            <div class="col-md-4 mb-3">
               <label for="name">Diller nomi:</label>
                <input type="text" placeholder="Diller nomi" class="form-control" name="form[name]" id="name" value="<?php echo $dinfo['name'];?>" required autocomplete="off">
            </div>
            <div class="col-md-4 mb-3">
               <label for="inn">STIR (INN) raqami:</label>
                <input type="number" placeholder="STIR (INN)" class="form-control" id="inn" name="form[inn]" required autocomplete="off" value="<?php echo $dinfo['inn'];?>">
            </div>
            <div class="col-md-4 mb-3">
               <label for="phone">Telefon raqami:</label>
                <input type="text" placeholder="Telefon raqami +998 siz" class="form-control" name="form[phone]" required autocomplete="off" id="phone" value="<?php echo $dinfo['phone'];?>">
            </div>

            <div class="col-md-4 mb-3">
               <label for="contract">Shartnoma muddati:</label>
                <input type="date" placeholder="Shartnoma" id="contract" class="form-control" name="form[contract]" required autocomplete="off" value="<?php echo $dinfo['contract'];?>">
            </div>
            <div class="col-md-4 mb-3">
               <label for="tuman">Tumanni tanlang:</label>
                <select name="form[tuman]" id="tuman" class="form-select" required>


                        <?php
                    echo "<option value='{$dinfo['tuman']}'>";
                    echo $db->query("SELECT* FROM districts WHERE id={$dinfo['tuman']}")->fetch_assoc()['name'];
                    echo "</option>";
                    $tumans = $db->query("SELECT * FROM districts WHERE region_id='13'");
                    while($tuman = $tumans->fetch_assoc()){
                        if($tuman['id']!=$dinfo['tuman']){echo "
                        <option value='{$tuman['id']}'>{$tuman['name']}</option>
                        ";}
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4 mb-3">
               <label for="adress">Manzil:</label>
                <input type="text" placeholder="Manzil" name="form[adress]" class="form-control" autocomplete="off" required value="<?php echo $dinfo['adress'];?>">
            </div>
           <div class="col-md-4 mb-3">
               <label for="google_map">Google map URL:</label>
                <input type="text" placeholder="Manzil" name="form[google_map]" class="form-control" autocomplete="off" required value="<?php echo $dinfo['google_map'];?>">
            </div>
            <div class="col-md-4 mb-3">
               <label for="google_map">Bururtma minimal summasi:</label>
                <input type="text" placeholder="Manzil" name="form[minimal]" class="form-control" autocomplete="off" required value="<?php echo $dinfo['minimal'];?>">
            </div>
            <!---<div class="col-md-4 mb-3">
               <label for="spec">Спецзаказ:</label>
                <input type="text" placeholder="Narxi" name="form[spec]" class="form-control" autocomplete="off" required value="<?php echo $dinfo['spec'];?>">
            </div>------>
            <div class="col-md-4">
                <div class="d-grid">
                   <label for="edit">Saqlash:</label>
                    <button name="edit" class="btn btn-success">Saqlash</button>
                </div>
            </div>
        </form>
    <h2 class="text-center col-12 my-2">Parolni yangilash</h2>
    <form action="/?go=<?php echo $go;?>" class="row" method="POST">
        <div class="col-md-4">
            <input type="text" name="old_pass" class="form-control" required placeholder="Eski parol" autocomplete="off">
        </div>
        <div class="col-md-4">
            <input type="text" name="new_pass" class="form-control" required placeholder="Yangi parol" autocomplete="off">
        </div>
        <div class="col-md-4">
           <div class="d-grid">
               <button class="btn btn-success" name="changepass">Yangilash</button>
           </div>

        </div>
    </form>
        <h2 class="text-center col-12 my-2">Rasmni yangilash</h2>
    <form action="/?go=<?php echo $go;?>" class="row" method="POST" enctype="multipart/form-data">
        <div class="col-md-4 d-flex justify-content-center" >
            <img src="<?php echo $dinfo['logo'];?>" class="d-block w-50">
        </div>
        <div class="col-md-4 d-flex align-items-center">
            <input type="file" name="logo" class="form-control" required accept="image/*">
        </div>
        <div class="col-md-4">
           <div class="d-grid h-100 d-flex align-items-center">
               <button class="btn btn-success w-100" name="photoChange">Yangilash</button>
           </div>

        </div>
    </form>
    <h2 class="text-center col-12 my-2">Chegirma</h2>
    <?php
       $distypes = [
           1 => "Tovar turi",
           2 => "Buyurtma narxi"
       ];
       $checkDis = $db->query("SELECT * FROM discounts WHERE diller={$_SESSION['userId']}");
       if($checkDis->num_rows>0){?>
       <div class="table-responsive">
           <table class="table table-bordered w-75 mx-auto">
               <thead class="bg-primary text-white">
                   <tr>
                       <td>Sharti</td>
                       <td>Minimal miqdor (dan oshsa)</td>
                       <td>Chegirma miqdori (%) </td>
                       <td>Saqlash</td>
                       <td>O'chirish</td>
                   </tr>
               </thead>
               <tbody>
                  <?php
                   $checkDis = $checkDis->fetch_assoc();
                   ?>
                   <tr>
                       <form action="/?go=<?php echo$go?>" method="POST">
                       <td>
                           <select name="form[dis_type]" id="" class="form-select">
                <?php echo "<option value='{$checkDis['dis_type']}'>{$distypes[$checkDis['dis_type']]}</option>";
                foreach($distypes as $key=>$value){
                    if($key!=$checkDis['dis_type']){
echo "<option value='$key'>$value</option>";
                    }
                }
                ?>
            </select>
                       </td>

                       <td>
                           <input type="number" name="form[dis_min]" class="form-control" value="<?php echo $checkDis['dis_min'];?>">
                       </td>
                       <td>
                           <input type="number" name="form[dis]" class="form-control" value="<?php echo $checkDis['dis'];?>">
                       </td>
                       <td><button name="saveDis" value="<?php echo "{$checkDis['id']}";?>" class="btn btn-success"><i class="la la-save"></i></button></td>

                       <td>
                           <a onclick="return confirm('Haqiqatdan ham o`chirilsinmi?')" href="/?go=<?php echo "$go&delDis={$checkDis['id']}"?>" class="btn btn-danger"><i class="la la-trash"></i></a>
                       </td>
                    </form>
                    </tr>
               </tbody>
           </table>
       </div>
       <?}else {
       ?>
    <form action="/?go=<?php echo $go;?>" class="row" method="POST" enctype="multipart/form-data">
        <div class="col-md-3">
            <select name="form[dis_type]" id="" class="form-select">
                <option value="">Chegirma sharti</option>
                <option value="1">Tovar turi</option>
                <option value="2">Tovar narxi</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" name="form[dis_min]" class="form-control" placeholder="dan oshsa">
        </div>
        <div class="col-md-3">
            <input type="number" name="form[dis]" placeholder="chegirma % da" class="form-control">
        </div>

        <div class="col-md-3">
           <div class="d-grid h-100 d-flex align-items-center">
               <button class="btn btn-success w-100" name="discount">Qo'shish</button>
           </div>

        </div>
    </form>
       <?}?>
    <form action="/?go=<?php echo $go;?>" class="row" method="POST">
            <h2 class="text-center col-12 my-2">Aksiya va Yangi tovar animatsiyasi</h2>
        <div class="col-md-3 offset-md-3">
        <label for="aksiya">Aksiya</label>
            <select name="form[aksiya]" id="aksiya" class="form-select">
                <?php
                $onoff = [
                    0=>"O'chirilgan",
                    1=>"Yoqilgan"
                    ];
                ?>
                <option value="<?php echo $dinfo['aksiya'];?>"><?php echo $onoff[$dinfo['aksiya']];?></option>
                <?php
                if($dinfo['aksiya']==0){
                    echo "<option value='1'>{$onoff[1]}</option>";

                    } else {
                       echo "<option value='0'>{$onoff[0]}</option>";
                    }
                ?>

            </select>
        </div>
        <div class="col-md-3">
        <label for="new">Yangi (new)</label>
        <select name="form[new]" id="new" class="form-select">
                <option value="<?php echo $dinfo['new'];?>"><?php echo $onoff[$dinfo['new']];?></option>
                 <?php
                if($dinfo['new']==1){
                    echo "<option value='0'>{$onoff[0]}</option>";

                    } else {
                       echo "<option value='1'>{$onoff[1]}</option>";
                    }
                ?>
            </select>
        </div>
        <div class="col-md-2 offset-md-5 mt-4">
            <div class="d-grid">
            <button name="animate" class="btn btn-success btn-block">Saqlash</button>
            </div>
        </div>
    </form>
</div>
