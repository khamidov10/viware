<?php
if(isset($_GET['del'])){
    $result = $db->query("DELETE FROM notification WHERE id={$_GET['del']}");
    $result = $db->query("DELETE FROM nf_read WHERE n_id={$_GET['del']}");
}
if(isset($_POST['add'])){
    foreach($_POST['form'] as $key=>$value){
        $keys[] = $key;
        $values[] = "'$value'";
    }
    $date = date("Y-m-d H:i:s");
    $keys[] = "time";
    $values[] = "'$date'";
    $keys = implode(",",$keys);
    $values = implode(",",$values);

    $result = $db->query("INSERT INTO notification ($keys) VALUES ($values)");
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
        <button data-bs-toggle="modal" data-bs-target="#addForm" class="btn btn-primary">Yangi Xabarnoma</button>
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
                <th>Kimga</th>
                <th>Xabar matni</th>
                <th>Ko'rildi</th>
                <th width="5%"></th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            $to = [
                0 => "Barchaga",
                2 => "Dillerlarga",
                3 => "Buyurtmachilarga"
            ];
            $nots = $db->query("SELECT * FROM notification ORDER BY id DESC");
            while($not=$nots->fetch_assoc()){
                $count = $db->query("SELECT * FROM nf_read WHERE n_id={$not['id']}")->num_rows;
               
                echo "
                <tr>
                    <td>{$to[$not['n_to']]}</td>
                    <td>{$not['text']}</td>
                    <td>{$count}</td>
                    <td><div onclick=\"return confirm('O`chirilsinmi?')\" class='d-grid'><a class='btn btn-danger' href='/?go=$go&del={$not['id']}'><i class='la la-trash'></i></a></div></td>
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
            <div class="col-12 mb-3">
               <label for="name_uz">Kimga?:</label>
                <select name="form[n_to]" id="" class="form-select">
                    <option value="">Tanlang</option>
                    <?php
                    foreach($to as $key=>$value){
                        echo "<option value='$key'>$value</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-12 mb-3">
               <label for="inn">Xabar matni:</label>
                <textarea name="form[text]" id="" cols="30" rows="10" class="form-control"></textarea>
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