<?php
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
              $allow = true;
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
    else {
        $allow = true;
    }
if(isset($_GET['delUser'])){
    $result = $db->query("DELETE FROM users WHERE id={$_GET['delUser']}");
}
if(isset($_POST['add'])){
    foreach($_POST['form'] as $key=>$value){
        if($key == 'password'){
            $value = shifr($value);
        }
        $keys[] = $key;
        $values[] = "'$value'";
    }
        if($upload){$keys[]='logo'; $values[] = "'$photo'";}
    $keys = implode(",",$keys);
    $values = implode(",",$values);
    if($allow){
      $result = $db->query("INSERT INTO users ($keys) VALUES ($values)");
    }

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
?>




<div class="row p-3 bg-white rounded">
    <div class="col-12 text-end my-3">
        <button data-bs-toggle="modal" regbutton data-bs-target="#addForm" class="btn btn-primary">Yangi Buyurtmachi</button>
    </div>
     <?php
        if(isset($message)){
    echo "
    <div class='alert alert-{$message['type']} my-2' >{$message['text']}</div>
    ";
}
    ?>
      <div class="table-responsive">
       <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nomi</th>
                <th>STIR (INN)</th>
                <th>Telegram ID</th>
                <th>Phone</th>
                <th>Holati</th>
                <th>Manzil</th>
                <th>O'chirish</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $status =[
                0=>"<b class='text-danger'>Deaktiv</b>",
                1=>"<b class='text-success'>Aktiv</b>"
            ];
            $dillers = $db->query("SELECT * FROM users WHERE type=3");
            while($diller=$dillers->fetch_assoc()){
                $tuman = $db->query("SELECT * FROM districts WHERE id={$diller['tuman']}")->fetch_assoc();
                echo "
                <tr>
                    <td>{$diller['name']}</td>
                    <td>{$diller['inn']}</td>
                    <td>{$diller['telegram']}</td>
                    <td>+998{$diller['phone']}</td>
                    <td>{$status[$diller['status']]}</td>
                    <td>{$tuman['name']}, {$diller['adress']}</td>
                    <td>
                    <div class='d-grid'>
                    <a href='/?go=$go&delUser={$diller['id']}' onclick='return confirm(\"O`chirilsinmi?\")' class='btn btn-danger'><i class='la la-trash'></i></a>
                    </div>
                    </td>
                </tr>
                ";
            }
            ?>
        </tbody>
    </table>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="addForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form class="modal-content" action="" method="POST" enctype="multipart/form-data">
     <input type="hidden" name="form[type]" value="3">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Yangi Buyurtmachi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div class='row' id="offerta">
      <div class='col-12' >
        <p><b>Мобил иловадан фойдаланиш коидалари ва шартлари:</b></p><p>Фойдаланувчилар:</p><ul><li>“БАЖАРУВЧИ” – махсулот етказиб берувчи&nbsp;</li><li>“БУЮРТМАЧИ” – махсулот буюртма берувчи</li></ul><p><b>Фойдаланувчилар мажбуриятлари:&nbsp;</b></p><p>“БАЖАРУВЧИ”:</p><ul><li>буюртма килинган махсулотни белгиланган вахтда йетказиб беришни таминлаш.</li><li>етказилган махсулот истемолга ярокли болиши шарт.&nbsp;</li></ul><p>“БУЮРТМАЧИ”:</p><ul><li>буюртма йетказилгач махсулотни кабул килиб олиши керак</li><li>келишилган вахтда толовларни амалга ошириши керак</li></ul><p><b>Томонлар жавобгарлиги:</b></p><ul><li>томонлар куйидаги холатда жавобгар боладилар, агар юкоридаги корсатилган бандлардан бири бузулган холда бир томоннинг айби билан иккинчи томонга моддий зарар йетказилса, айбдор томон иккинчи томонни зарарини коплаб бериши керак.</li></ul><p><b>Низоларни хал етиш тартиби:</b></p><ul><li>Ушбу шартномани бажаришда юзага келадиган барча тортишувлар ва келишмовчиликлар озаро томонларнинг музокара йўли билан ҳал қилинади.</li><li>Низолар ҳал этилмаган тақдирда, улар қонун ҳужжатларида белгиланган тартибда судлар томонидан кўриб чиқилади.</li></ul><p><span style="font-weight: 700;">Маълумотлардан фойдаланиш:</span></p><ul><li><span style="font-weight: 700;">Ушбу иловадан рўйхатдан ўтиш билан сиз, сизнинг маълумотларингиздан тизимда реклама алгортимларини сифатини ошириш учун фойдаланишга розилик билдирган хисобланасиз.<br></span><br></li></ul>
        </div>
        <div class='col-4 offset-4' >
        <div class='d-grid'>
        <a class='btn btn-success' id='ok'><i class='la la-check'></i> Розиман</a>
        </div></div>
      </div>
        <div class="row" id="reg">
            <div class="col-4 mb-3">
               <label for="name">Buyurtmachi nomi:</label>
                <input type="text" placeholder="Buyurtmachi nomi" class="form-control" name="form[name]" id="name" required autocomplete="off">
            </div>
            <div class="col-4 mb-3">
               <label for="inn">STIR (INN) raqami:</label>
                <input type="number" placeholder="STIR (INN)" class="form-control" id="inn" name="form[inn]" required autocomplete="off">
            </div>
            <div class="col-4 mb-3">
               <label for="phone">Telefon raqami:</label>
                <input type="text" placeholder="Telefon raqami +998 siz" class="form-control" name="form[phone]" required autocomplete="off" id="phone">
            </div>
            <div class="col-4 mb-3">
               <label for="pass">Parol:</label>
                <input type="text" placeholder="Parol" class="form-control" name="form[password]" required autocomplete="off" value="<?php echo rand(100000,999999);?>" id="pass">
            </div>

            <div class="col-4 mb-3">
               <label for="status">Akkaunt holati:</label>
                <select name="form[status]" id="status" class="form-select" required>
                       <option value="">Tanlang</option>
                        <option value="1">Aktiv</option>
                        <option value="0">Deaktiv</option>
                </select>
            </div>

            <div class="col-4 mb-3">
               <label for="tuman">Tumanni tanlang:</label>
                <select name="form[tuman]" id="tuman" class="form-select" required>
                       <option value="">Tanlang</option>
                        <?php
                    $tumans = $db->query("SELECT * FROM districts WHERE region_id='13'");
                    while($tuman = $tumans->fetch_assoc()){
                        echo "
                        <option value='{$tuman['id']}'>{$tuman['name']}</option>
                        ";
                    }
                    ?>
                </select>
            </div>
            <div class="col-8 mb-3">
               <label for="adress">Manzil:</label>
                <input type="text" placeholder="Manzil" name="form[adress]" class="form-control" autocomplete="off" required>
            </div>

            <div class="col-4 mb-3">
               <label for="adress">Telegram ID:</label>
                <input type="number" placeholder="Telegram" name="form[telegram]" class="form-control" autocomplete="off" required>
            </div>
            <div class="col-md-8 mb-3">
               <label for="google_map">Google map URL:</label>
                <input type="text" placeholder="Manzil" name="form[google_map]" class="form-control" autocomplete="off" required value="<?php echo $dinfo['google_map'];?>">
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <a class="btn btn-secondary" data-bs-dismiss="modal">Yopish</a>
        <button name="add" class="btn btn-primary">Qo'shish</button>
      </div>
    </form>
  </div>
</div>
