<div class="row bg-white rounded p-3 mb-5 pb-5">
<div class='col-12'>
    <form class='row' action="/?go=<?php echo $go;?>" method="POST">

        <div class="col-lg-4 mb-3">
   <label for="region">Tumanni tanlang</label>
    <div class="input-group">
    <select name="region" required="" class="form-select form-select-lg">
        <option value="">Tumanni tanlang</option>
        <?php
        $all = $db->query("SELECT * FROM regions");
        while($reg = $all->fetch_assoc()){
         echo "<option value='{$reg['id']}'>{$reg['name']}</option>";
         }

        ?>

    </select>
    </div>
</div>

        <div class="col-lg-4 mb-3">
   <label for="region">SMS matni tanlang</label>
    <div class="input-group">
   <textarea class='d-block w-100 form-control' name='sms' placeholder='SMS matnini kiriting' maxlength="160"></textarea>
    </div>
</div>
<div class="col-lg-4 mb-3">
<div class='d-flex align-items-center justify-content-center h-100'>
    <button class='btn btn-success d-block w-50'>Jo'natish</button>
</div>

</div>

    </form>
</div>
</div>
