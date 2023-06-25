<?php
if(isset($_GET['del'])){
    $result = $db->query("DELETE FROM units WHERE id={$_GET['del']}");
}
if(isset($_POST['add'])){
    foreach($_POST['form'] as $key=>$value){
        if($key == 'password'){
            $value = shifr($value);
        }
        $keys[] = $key;
        $values[] = "'$value'";
    }
    $keys = implode(",",$keys);
    $values = implode(",",$values);

    $result = $db->query("INSERT INTO units ($keys) VALUES ($values)");
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
        <button data-bs-toggle="modal" data-bs-target="#addForm" class="btn btn-primary">Yangi birlik</button>
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
                <th>id</th>
                <th>Nomi O'zbekcha</th>
                <th>Название на русском</th>
                <th width="5%">O'chirish</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            
            $cats = $db->query("SELECT * FROM units");
            while($cat=$cats->fetch_assoc()){
               
                echo "
                <tr>
                    <td>{$cat['id']}</td>
                    <td>{$cat['name_uz']}</td>
                    <td>{$cat['name_ru']}</td>
                    <td><div onclick=\"return confirm('O`chirilsinmi?')\" class='d-grid'><a class='btn btn-danger' href='/?go=$go&del={$cat['id']}'><i class='la la-trash'></i></a></div></td>
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
    <form class="modal-content" action="" method="POST">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Yangi birlik</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-6 mb-3">
               <label for="name_uz">O'zbek tilida:</label>
                <input type="text" placeholder="name_uz" class="form-control" name="form[name_uz]" id="name_uz" required autocomplete="off">
            </div>
            <div class="col-6 mb-3">
               <label for="inn">Russ tilida:</label>
                <input type="text" placeholder="name_ru" class="form-control" id="name_ru" name="form[name_ru]" required autocomplete="off">
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