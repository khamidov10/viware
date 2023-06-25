<?php
if(isset($_GET['del'])){
   $result=$db->query("DELETE FROM credit WHERE id={$_GET['del']}");
}
if(isset($_POST['pay'])){
    $all = $_POST['all'];
    $payed = $_POST['payed'];
    if($payed == $all) {
        $status = "3";} else {
            $status = "2";}
    if($payed >0) {
   $result=$db->query("UPDATE credit SET status='$status',payed='$payed' WHERE id={$_POST['pay']}");
    }
}
if(isset($_POST['add'])){
    $result = $db->query("INSERT INTO credit (user,summa,date,diller) VALUES ('{$_POST['user']}','{$_POST['summa']}','{$_POST['date']}','{$_SESSION['userId']}')");
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
            "text" => "Xatolik: ".$db->error
        ];
    }
}

?>
<div class="row rounded p-3 bg-white">
   <div class="col-12">
       <?php
    if(isset($message)){
    echo "
    <div class='alert alert-{$message['type']} my-2' >{$message['text']}</div>
    ";
}?>
   </div>
   <div class="col-12 my-3">
       <form action="" method="POST" class="row">
           <div class="col-3">
              <label for="prod">Qarzdor STIR (INN)i:</label>
               <input name="user" id="user" type="number" class="form-control" required>

           </div>
       <div class="col-3">
              <label for="summa">Summa:</label>
               <input name="summa" id="summa" type="number" class="form-control" required>

           </div>
   <div class="col-3">
              <label for="date">Sana:</label>
               <input name="date" id="date" type="date" class="form-control" required>

           </div>

   <div class="col-3 offset-9 text-end my-2">
       <button class="btn btn-primary" name="add" id="add">Qo'shish</button>
   </div>
   </form>
   <div class="alert alert-info" id="info">
       
   </div>
   </div>
   
   <div class='table-responsive'>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Qarzdor</th>
                <th>Summa</th>
                <th>Sana</th>
                <th>To'langan</th>
                <th>Holati</th>
                <th width="5%">O'chirish</th>
                <th width="25%">To'lov</th>
            </tr>
        </thead>
        <tbody>
           <script>allQarz = 0;tulangan=0</script>
            <?php
            $status = [
              1 => "<b class='text-danger'>To'lanmagan</b>",
              2 => "<b class='text-warning'>Qisman to'langan</b>",
                3 => "<b class='text-success'>To'liq to'langan</b>",

            ];
            $loads = $db->query("SELECT * FROM credit WHERE diller={$_SESSION['userId']} ORDER BY status ASC,date DESC,id DESC");
            while($load = $loads->fetch_assoc()){
                $dis = "";
                if($load['status']==3){
                    $dis = 'disabled';
                    }
        $user = $db->query("SELECT * FROM users WHERE inn='{$load['user']}'")->fetch_assoc();


                echo "
                <tr>
                    <td>{$user['name']} ({$user['inn']})</td>
                    <td>".number_format($load['summa'], 0, '', ' ')." so'm
                    <script>allQarz = allQarz+parseInt({$load['summa']})</script>
                    </td>
                    <td>{$load['date']}</td>
                    <td>".number_format($load['payed'], 0, '', ' ')." so'm 
                    <script>tulangan = tulangan+parseInt({$load['payed']})</script>
                    </td>
                    <td>{$status[$load['status']]}</td>
                    <td><a onclick='return confirm(\"Haqiqatdan ham o`chirilsinmi?\")' href='/?go=$go&del={$load['id']}' class='btn btn-danger'><i class='la la-trash'></i></a>
                    </td>
                    <td>
                    <form method='POST' action='/?go=$go' class='row'>
                    <div class='col-md-8'>
                    <input value='{$load['payed']}' $dis name='payed' class='form-control'>
                    </div>
                    <div class='col-md-4'>
                    <div class='d-grid'>
                    <input type='hidden'  name='all' $dis value='{$load['summa']}'>
                    <button name='pay' $dis value='{$load['id']}' class='btn btn-success'><i class='la la-check'></i></a>
                    </div>
                    </div>
                    </form>
                    </td>
                </tr>
                ";
            }

            ?>

        </tbody>
    </table>
    </div>
</div>
<script>
qoldi = allQarz-tulangan;
document.getElementById("info").innerHTML = "Jami qarz: <b>"+allQarz+"</b> so'm.<br> To'langan: <b>"+tulangan+"</b> so'm.<br> Qoldi: <b>"+qoldi+"</b> so'm"
</script>