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

     <h2 class="text-center col-12 my-2">Mening ma'lumotlarim</h2>
     <form class="row" method="POST" action="/?go=<?php echo $go;?>">
            <div class="col-md-4 mb-3">
               <label for="name">Buyurtmachi nomi:</label>
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
               <label for="adress">Mo'ljal:</label>
                <input type="text" placeholder="Mo'ljal" name="form[orientr]" class="form-control" autocomplete="off" required value="<?php echo $dinfo['orientr'];?>">
            </div>
           <div class="col-md-8 mb-3">
               <label for="google_map">Google map URL:</label>
                <input type="text" placeholder="Manzil" name="form[google_map]" class="form-control" autocomplete="off" required value="<?php echo $dinfo['google_map'];?>">
            </div>

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
         <!--- <h2 class="text-center col-12 my-2">Rasmni yangilash</h2>
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
    --------------->

</div>
