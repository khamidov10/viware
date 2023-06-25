   <form class="row bg-white p-3 rounded" action="/?go=main" method="POST" enctype="multipart/form-data">
    <div class="col-lg-4">
      <label for="name">Tovar nomi</label>
       <input class="form-control form-control-lg" type="text" placeholder="Tovar nomi" aria-label="Tovar nomi" name="name" id="name" required autocomplete="off">
    </div>
       <div class="col-lg-3 mb-3">
      <label for="cat">Bo'lim</label>
       <select class="form-select form-select-lg"  aria-label="Tovar nomi" name="cat" id="cat" autocomplete="off" required>
        <option value="">Tanlang</option>
        <?php
        $cats = $db -> query("SELECT * FROM category");
        while($cat = $cats->fetch_assoc()){
            echo "
            <option value='{$cat['id']}'>{$cat['name_uz']}</option>
            ";
        }

        ?>

        </select>

    </div>
    <div class="col-lg-3 mb-3">
      <label for="unit">O'lchov birligi</label>
       <select class="form-select form-select-lg"  aria-label="Tovar nomi" name="unit" id="unit" autocomplete="off" required>
        <option value="">Tanlang</option>
        <?php
        $units = $db -> query("SELECT * FROM units");
        while($unit = $units->fetch_assoc()){
            echo "
            <option value='{$unit['id']}'>{$unit['name_uz']}</option>
            ";
        }

        ?>

        </select>

    </div>
    <div class="col-lg-2">
      <label for="stock">Omborda</label>
       <input class="form-control form-control-lg" type="number" placeholder="Mavjud"name="stock" id="stock" required autocomplete="off">
    </div>
    <div class="col-lg-3 mb-3">
      <label for="min">Minimal buyurtma</label>
       <div class="input-group">
  <input type="number" class="form-control form-control-lg" placeholder="Minimal" aria-label="Minimal" min="1" value="1" name="min" id="min" aria-describedby="min_unit">
  <span class="input-group-text" id="min_unit">-</span>
</div>

    </div>



        <div class="col-lg-4 mb-3">
      <label for="price">Narxi</label>
     <div class="input-group">
     <span class="input-group-text" id="price_areapre"></span>
      <input type="number" class="form-control form-control-lg" placeholder="Narxi" aria-label="Narxi" min="100" name="price" id="price" aria-describedby="price_area" autocomplete="off">
      <span class="input-group-text" id="price_area">so'm</span>
    </div>

    </div>
 <div class="col-lg-5 mb-3">
<label for="photo">Tovar rasmi</label>
  <input id="photo" name="photo" type="file" class="form-control form-control-lg" id="inputGroupFile01" required accept="image/*">
</div>

 <div class="col-lg-3 mb-3">
<label for="discount_type">Chegirma</label>
<select name="discount_type" id="discount_type" class="form-select form-select-lg">
    <option value="0">Chegirmasiz</option>
    <option value="1">Shartli</option>
    <option value="2">Shartsiz</option>
</select>

</div>
<div class="col-lg-3 mb-3">
   <label for="discount_price">narx</label>
    <div class="input-group">
      <input type="number" class="form-control form-control-lg" placeholder="0" aria-label="0" name="discount_price" id="discount_price" aria-describedby="discount_price_area" disabled required>
      <span class="input-group-text" id="discount_price_area">dan oshsa</span>
    </div>
</div>

<div class="col-lg-2 mb-3">
   <label for="discount">Chegirma O'lchov birligi</label>

    <div class="input-group">
      <input type="number" class="form-control form-control-lg" placeholder="Chegirma" aria-label="Chegirma" name="discount" id="discount" aria-describedby="discount_area" disabled required>
      <span class="input-group-text" id="discount_area">%</span>
    </div>
</div>
<div class="col-lg-2 mb-3">
   <label for="new">NEW belgisi</label>
    <div class="input-group">
    <select name="new" required class="form-select form-select-lg">
        <option value="0">O'chirilgan</option>
        <option value="1">Yoqilgan</option>

    </select>
    </div>

</div>
<div class="col-lg-2 mb-3">
   <label for="rec">Tavsiya belgisi</label>
    <div class="input-group">
    <select name="rec" required class="form-select form-select-lg">
        <option value="0">O'chirilgan</option>
        <option value="1">Yoqilgan</option>

    </select>
    </div>

</div>
<div class="col-lg-12">
   <hr>
    <div class="d-grid">
        <button class="btn btn-primary btn-lg" name="add">Saqlash</button>
    </div>
</div>
</form>
