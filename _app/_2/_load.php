<?php
if(isset($_GET['del'])){
   $result=$db->query("DELETE FROM load_prod WHERE id={$_GET['del']}"); 
}
if(isset($_POST['add'])){
    $result = $db->query("INSERT INTO load_prod (add_prod,count,diller) VALUES ('{$_POST['prod']}','{$_POST['count']}','{$_SESSION['userId']}')");
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
   <div class="col-12 my-4">
       <form action="" method="POST" class="row">
           <div class="col-4">
              <label for="prod">Tovarni tanlang:</label>
               <select name="prod" id="prod" load class="form-select form-select-lg" required>
                   <option value="" unit="0">Tanlang</option>
                   <?php
                   $prods = $db->query("SELECT * FROM products WHERE diller={$_SESSION['userId']}");
                   while($prod = $prods->fetch_assoc()){
                       $unit = $db->query("SELECT * FROM units WHERE id={$prod['unit']}")->fetch_assoc();
                       echo "<option value='{$prod['id']}' unit='{$unit['name_uz']}'>{$prod['name']}</option>";
                   }
                   ?>
               </select>
           </div>
       
   
   <div class="col-4">
      <label for="count">O'lchov birligini kiriting</label>
       <div class="input-group">
      <input type="number" class="form-control form-control-lg" placeholder="0" aria-label="0" name="count" id="count" aria-describedby="count_area" disabled="" required="">
      <span class="input-group-text" id="count_area" required></span>
    </div>
   </div>
   <div class="col-4 text-end">
      <label for="add">Barcha maydonlarni to'dirib qo'shing</label>
       <button class="btn btn-primary btn-lg" name="add" id="add">Qo'shish</button>
   </div>
   </form></div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tovar nomi</th>
                <th>Narxi</th>
                <th>O'lchov birligi</th>
                <th>O'chirish</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $loads = $db->query("SELECT * FROM load_prod WHERE diller={$_SESSION['userId']}");
            while($load = $loads->fetch_assoc()){
        $prod = $db->query("SELECT * FROM products WHERE id='{$load['add_prod']}'")->fetch_assoc();
        $unit = $db->query("SELECT * FROM units WHERE id='{$prod['unit']}'")->fetch_assoc();
        
                echo "
                <tr>
                    <td>{$prod['name']}</td>
                    <td>".number_format($prod['price'], 0, '', ' ')."</td>
                    <td>{$load['count']} {$unit['name_uz']}</td>
                    <td><a onclick='return confirm(\"Haqiqatdan ham o`chirilsinmi?\")' href='/?go=$go&del={$load['id']}' class='btn btn-danger'><i class='la la-trash'></i></a></td>
                </tr>
                ";
            }
            
            ?>
        </tbody>
    </table>
</div>