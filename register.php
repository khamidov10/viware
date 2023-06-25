<?php
require_once "__conn_db_config_file_.php";

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Kirish</title>
<link rel="stylesheet" href="/assets/css/bootstrap.min.css">
   <link rel="stylesheet" href="/assets/css/line-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/login.css?ver=<?php echo rand(1,150);?>">




    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      .form-register{
      width:80% !important;
      margin:0 auto;
      }
    </style>


    <!-- Custom styles for this template -->
  </head>
  <body class="text-center" style="<?php if(!isset($_POST['agree'])){echo "height: auto !important;";}?>" >

<main class="rounded p-4 form-register" style="background:rgb(255,255,255,<?php if(isset($_POST['agree'])){echo "0.3";}else {echo "0.7";}?>)">
   <?php
    if(isset($_POST['agree'])){ ?>
    <form action="/" method="POST">
    <?php
    if($message=="regFalse"){
        echo "<h6 class='text-danger text-center my-1'>Tizim xatoligi!</h6>";
    }

    if($message=="double"){
        echo "<h6 class='text-danger text-center my-1'>Bunday foydalanuvchi oldin ro'yxatdan o'tgan!</h6>";
    }
      ?>

     <input type="hidden" name="form[type]" value="3">

        <div class="row">
            <div class="col-md-4 mb-3">
               <label for="name">Buyurtmachi nomi:</label>
                <input type="text" placeholder="Buyurtmachi nomi" class="form-control" name="form[name]" id="name" required autocomplete="off">
            </div>
            <div class="col-md-4 mb-3">
               <label for="inn">STIR (INN) raqami:</label>
                <input type="number" placeholder="STIR (INN)" class="form-control" id="inn" name="form[inn]" required autocomplete="off">
            </div>
            <div class="col-md-4 mb-3">
               <label for="phone">Telefon raqami:</label>
                <input type="text" placeholder="Telefon raqami +998 siz" class="form-control" name="form[phone]" required autocomplete="off" id="phone">
            </div>
            <input type="hidden" name="form[password]" value="<?php echo rand(100000,999999);?>">

           <!--- <div class="col-md-4 mb-3">
               <label for="pass">Parol:</label>

                <input type="text" placeholder="Parol" class="form-control" name="form[password]" required autocomplete="off" value="<?php echo rand(100000,999999);?>" id="pass">
            </div>
            ------------------>



            <div class="col-md-4 mb-3">
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
            <div class="col-md-4 mb-3">
               <label for="adress">Manzil:</label>
                <input type="text" placeholder="Manzil" name="form[adress]" class="form-control" autocomplete="off" required>
            </div>
            <div class="col-md-4 mb-3">
               <label for="adress">Mo'ljal:</label>
                <input type="text" placeholder="Mo'ljal" name="form[orientr]" class="form-control" autocomplete="off" required>
            </div>
            <div class="col-md-4 mb-3">
               <label for="adress">Telegram ID:</label>
                <input type="number" placeholder="Telegram" name="form[telegram]" class="form-control" autocomplete="off" required>
            </div>

            <div class="col-md-6 offset-md-3 mb-3">
                <div class="d-grid">
                    <button name='reg' class='btn btn-success'>Ro'yxatdan o'tish</button>
                </div>
            </div>
        </div>


    </form>
   <?}  else{
        ?>
        <div align="left">
<p><b>Мобил иловадан фойдаланиш коидалари ва шартлари:</b></p><p>Фойдаланувчилар:</p><ul><li>“БАЖАРУВЧИ” – махсулот етказиб берувчи&nbsp;</li><li>“БУЮРТМАЧИ” – махсулот буюртма берувчи</li></ul><p><b>Фойдаланувчилар мажбуриятлари:&nbsp;</b></p><p>“БАЖАРУВЧИ”:</p><ul><li>буюртма килинган махсулотни белгиланган вахтда йетказиб беришни таминлаш.</li><li>етказилган махсулот истемолга ярокли болиши шарт.&nbsp;</li></ul><p>“БУЮРТМАЧИ”:</p><ul><li>буюртма йетказилгач махсулотни кабул килиб олиши керак</li><li>келишилган вахтда толовларни амалга ошириши керак</li></ul><p><b>Томонлар жавобгарлиги:</b></p><ul><li>томонлар куйидаги холатда жавобгар боладилар, агар юкоридаги корсатилган бандлардан бири бузулган холда бир томоннинг айби билан иккинчи томонга моддий зарар йетказилса, айбдор томон иккинчи томонни зарарини коплаб бериши керак.</li></ul><p><b>Низоларни хал етиш тартиби:</b></p><ul><li>Ушбу шартномани бажаришда юзага келадиган барча тортишувлар ва келишмовчиликлар озаро томонларнинг музокара йўли билан ҳал қилинади.</li><li>Низолар ҳал этилмаган тақдирда, улар қонун ҳужжатларида белгиланган тартибда судлар томонидан кўриб чиқилади.</li></ul><p><span style="font-weight: 700;">Маълумотлардан фойдаланиш:</span></p><ul><li><span style="font-weight: 700;">Ушбу иловадан рўйхатдан ўтиш билан сиз, сизнинг маълумотларингиздан тизимда реклама алгортимларини сифатини ошириш учун фойдаланишга розилик билдирган хисобланасиз.<br></span><br></li></ul>
        </div><form action="" method="POST" class="row my-2">
           <div class="col-12" align="center">
               <input type="checkbox" required id="agree" name="agree">
                    <label for="agree" class="my-2 check">Offerta shartlari bilan tanishdib chiqdim va barcha shartlarga roziman</label>
                    <p class="my-1 text-danger" style="display:none" id="error">Offertaga rozilik bildirib keyin ro'yxatdan o'tishingiz mumkin</p>
           </div>
            <div class="col-4 offset-4">
                    <div class="d-grid my-2">
                        <button id="next" class="btn btn-success">Keyingi</button>
                    </div>
            </div>
        </form>


        <?
    } ?>
<p align="center" ><a class='text-dark text-decoration-none' href='/'>Bosh sahifaga qaytish</a></p>
</main>


<script src="/assets/js/jquery-3.6.0.min.js"></script>
 <script>
      $("#next").click(function(){
 if($("#agree").is(":checked")){

    } else {
        $("#error").show(100)
    }

      })
      </script>
  </body>
</html>
