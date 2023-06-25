<div class="row bg-white">
    <?php
    $cats = $db->query("SELECT * FROM category ORDER BY name_uz ASC");
    while($cat = $cats->fetch_assoc()){
        $count = $db->query("SELECT * FROM products WHERE category={$cat['id']}")->num_rows;
        echo "<div class='col-sm-2'>
        <div class='card border-0'>
        <div class='card-body'>
        <div class='d-grid'>
        <a class='btn btn-primary' href='/?go=cat&id={$cat['id']}'>{$cat['name_uz']}($count)</a>
       </div></div></div> </div>";
    }
    ?>
</div>
