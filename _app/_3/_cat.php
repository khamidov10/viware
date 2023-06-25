<?php
if(isset($_GET['id'])){
$catName = $db -> query("SELECT name_uz FROM category WHERE id={$_GET['id']}")->fetch_assoc()['name_uz'];
$cats = $db->query("SELECT diller FROM products WHERE category={$_GET['id']} GROUP BY diller");
$dillerIds = [];
while($cat=$cats->fetch_assoc()){
    $dillerIds[] = $cat['diller'];
}
if(count($dillerIds)>0){
    $dillerIds = implode(",",$dillerIds);
}
    else {
        $dillerIds = 0;
    }
$dillers = $db->query("SELECT * FROM users WHERE type=2 AND status=1 AND id IN ($dillerIds) ORDER by rating DESC, id DESC LIMIT 20");
$count = $dillers->num_rows;
?>
<div class="col-12 my-2">
    <div class="d-sm-block d-md-none mx-1" align="right">
                <a href="#" id="viewMod" class="bell">
            	<i class="las la-grip-vertical"></i><i grid class="la la-toggle-off"></i>
				</a>
	</div>
	<div class="mx-1">
				<p class="alert alert-info"><b><?php echo $catName;?></b> bo'limi bo'yicha <b><?php echo $count;?></b> ta diller topildi</p>
	</div>

</div>
       <div class="col-12">
        <div class="row">
            <?php

            while($diller = $dillers->fetch_assoc()){

                $skidka = $diller['aksiya'];
                $new = $diller['new'];
                $disclass = "";
                $disstext = "";
                $newtext = "";
                if($skidka >0){
                    $disclass = "disAnimate";
                    $disstext = "<div class='discount'><img src='/assets/img/aksiya.png' width='100%'></div>";
                    }
                if($new >0){
                    $disclass = "disAnimate";
                    $newtext = "<div class='position-absolute badge bg-danger' style='right:-5%;top:-25%;'>New</div>";
                    }
                echo "
<div class=\"my-2 col-md-4\" dillerCard>
    			<div class=\"$disclass card position-relative border border-white shadow\" style='overflow:hidden;background:rgb(111, 138, 213,0.5) !important'>
				$disstext
                <a class=\"d-flex align-items-center justify-content-center infoIcon\" info='{$diller['id']}' name='{$diller['name']}'><i class=\"la la-info\" data-bs-toggle=\"modal\" data-bs-target=\"#infoBox\"></i></a>
                <div style='background:url({$diller['logo']});background-size:cover;background-position:center;padding-top:75%;'></div>
					<!--<img src=\"{$diller['logo']}\" class=\"card-img-top\" alt=\"Coca cola\">-->
					<div class=\"card-body py-1\">
						<h5 dillerName class=\"card-title text-white\">{$diller['name']}</h5>
						<div class=\"row\">
							<div class=\"col-12 my-2\">
								<div class=\"d-grid\">
                                <!--a ichiga attr order--->
									<a  name='{$diller['name']}' dillercat='{$diller['id']}' catid='{$_GET['id']}' href=\"#\" class=\"btn btn-outline-light position-relative\" data-bs-toggle=\"modal\" data-bs-target=\"#order\">$newtext
                                    <span prodMobText class='d-none'><i class=\"las la-dolly-flatbed\"></i></span>
                                    <span prodFullText class='x'>Tovar</span>
                                    </a>
								</div>
							</div>

							    					<div stars class=\"col-12 py-2\">";

                if($diller['rating']>100){
                    $diller['rating'] = 100;
                }
                           echo "<div class=\"star-ratings-sprite\"><span style=\"width:{$diller['rating']}%\" class=\"star-ratings-sprite-rating\"></span></div>";


    						echo " </div>
						</div>
					</div>
				</div>
			</div>";
			}

			?>
			<div class="col-12 my-2">
				<div class="d-grid">
					<button class="btn btn-outline-light">
						<i class="la la-sync-alt"></i>Ko'proq
					</button>
				</div>
			</div>
		</div>
	</div>
<?php } else {
    ?>
    <div class="mx-1">
				<p class="alert alert-danger"><b>Bo'lim tanlanmadi</b></p>
	</div>
    <?
}
?>
