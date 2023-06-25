<?php


if(isset($_POST['edit'])){
    $photo = $_POST['old_photo'];
  if($_FILES['photo']['size']>0){
      if($_FILES['photo']['siz']<512000){
      $root = $_SERVER['DOCUMENT_ROOT'];
      if(!is_dir("$root/products/{$_SESSION['userId']}")){
          mkdir("$root/products/{$_SESSION['userId']}");
      }
      $format = end(explode(".",$_FILES['photo']['name']));
      $filename = md5(rand(1,9999).date("ymd_his-").rand(1,999999)).".$format";
      $upload = move_uploaded_file($_FILES['photo']['tmp_name'],"$root/products/{$_SESSION['userId']}/$filename");
      $photo = "/products/{$_SESSION['userId']}/$filename";

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




          if($allow==true){
$add = $db->query("UPDATE products SET
name='{$_POST['name']}',
category='{$_POST['cat']}',
unit='{$_POST['unit']}',
stock='{$_POST['stock']}',
min='{$_POST['min']}',
price='{$_POST['price']}',
discount_type='{$_POST['discount_type']}',
discount_price='{$_POST['discount_price']}',
discount='{$_POST['discount']}',
photo='$photo',new='{$_POST['new']}',rec='{$_POST['rec']}',
diller='{$_SESSION['userId']}'        WHERE id='{$_POST['edit']}'");
          if($add){
             $message = [
          "type"=>"success",
          "text"=>"Ajoyib"
      ];
          } else {
              $message = [
          "type"=>"danger",
          "text"=>"Xatolik: ".$db->error
      ];
          }

      }
}

















































if(isset($_POST['add'])){
  if($_FILES['photo']['size']>0 && $_FILES['photo']['size']<512000){
      $root = $_SERVER['DOCUMENT_ROOT'];
      if(!is_dir("$root/products/{$_SESSION['userId']}")){
          mkdir("$root/products/{$_SESSION['userId']}");
      }
      $format = end(explode(".",$_FILES['photo']['name']));
      $filename = md5(rand(1,9999).date("ymd_his-").rand(1,999999)).".$format";
      $upload = move_uploaded_file($_FILES['photo']['tmp_name'],"$root/products/{$_SESSION['userId']}/$filename");
      $photo = "/products/{$_SESSION['userId']}/$filename";
      if($upload){
          $add = $db->query("INSERT into products (name,category,unit,stock,min,price,discount_type,discount_price,discount,photo,diller,new,rec) VALUES ('{$_POST['name']}','{$_POST['cat']}','{$_POST['unit']}','{$_POST['stock']}','{$_POST['min']}','{$_POST['price']}','{$_POST['discount_type']}','{$_POST['discount_price']}','{$_POST['discount']}','$photo','{$_SESSION['userId']}','{$_POST['new']}','{$_POST['rec']}')");
          if($add){
             $message = [
          "type"=>"success",
          "text"=>"Ajoyib"
      ];
          } else {
              $message = [
          "type"=>"danger",
          "text"=>"Xatolik: ".$db->error
      ];
          }
          /*ADD DB*/
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




if(isset($_GET['del'])){
    $result = $db->query("DELETE FROM products WHERE id='{$_GET['del']}' AND diller='{$_SESSION['userId']}'");
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
            "text" => "Xatolik"
        ];
    }
}
?>
<div class="row bg-white p-3 rounded">
<div class="col-6  offset-3">
<?php
    if(isset($message)){
    echo "
    <div class='alert alert-{$message['type']} my-2' >{$message['text']}</div>
    ";
}
$all = $db->query("SELECT * FROM products WHERE diller='{$_SESSION['userId']}'")->num_rows;
$in_page = 10;
$pages = $all/$in_page;
if($pages!=(int)$pages){
    $pages = (int)$pages+1;
}

$pn=1;
if($_GET['p']>0 && $_GET['p']<=$all){
    $pn = $_GET['p'];
}
$offset = ($pn-1)*$in_page;

    ?>
</div>
   <div class="col-12">

  <div class="table-responsive">
    <table class="table table-responsive table-bordered table-striped mt-1">
        <thead>
            <tr>
                <th width="5%">Rasmi</th>
                <th>Mahsulot</th>
                <th>O'lchov birligi</th>
                <th>narx</th>
                <th>Minimal</th>
                <th>Mavjud</th>
                <th>Aksiya</th>
                <th colspan="2">Amal</th>
            </tr>
        </thead>
        <tbody>
 <?php
  $prods = $db -> query("SELECT * FROM products WHERE diller='{$_SESSION['userId']}' ORDER BY id DESC LIMIT $in_page OFFSET $offset");
while($prod = $prods->fetch_assoc()){
    $unit = $db->query("SELECT * FROM units WHERE id='{$prod['unit']}'")->fetch_assoc()['name_uz'];
    echo '<tr>
         <td><img src="'.$prod['photo'].'" class="d-block w-100"></td>
            <td>'.$prod['name'].'</td>
            <td>'.$unit.'</td>
            <td>'.number_format($prod['price'], 0, '', ' ').'</td>
            <td>'.$prod['min'].'-'.$unit.'</td>
            <td>'.$prod['stock'].'</td>
            <td>'.$prod['discount'].'</td>
            <td width="5%">
            <a href="/?go=edit&pn='.$pn.'&id='.$prod['id'].'" class="btn btn-primary"><i class="la la-pen"></i></a>
            </td>
            <td width="5%">
             <a onclick="return confirm(\'Haqiqatdan ham o`chirmoqchimisiz?\')" href="/?go='.$go.'&del='.$prod['id'].'" class="btn btn-danger"><i class="la la-trash"></i></a>

            </td>
  </tr>';
}

?>



        </tbody>
    </table>
    </div>
    <?php
     if($all>$in_page){
         ?>
             <nav aria-label="Navigatsiya">
  <ul class="pagination justify-content-center" >
    <?php
    for($p=1;$p<=$pages;$p++){
       if($p==$pn){
           echo '
           <li class="page-item active" aria-current="page">
      <span class="page-link">'.$p.'</span>
    </li>
           ';
       }
        else {
             echo '
    <li class="page-item"><a class="page-link" href="/?go='.$go.'&p='.$p.'">'.$p.'</a></li>
        ';
        }
    }
    ?>

  </ul>
</nav>
         <?
     }
    ?>
     </div>
</div>
