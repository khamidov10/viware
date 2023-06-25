<div class="col-12 my-2">
    <div class="d-sm-block d-md-none mx-1" align="right">
                <a href="#" id="viewMod" class="bell">

                <i class="las la-grip-vertical"></i><i grid class="la la-toggle-off"></i>
				</a>
	</div>
</div>
       <div class="col-12">
        <div class="row">
            <?php
                $skidka = 0;
                $new = 0;
            $dillers = $db->query("SELECT * FROM users WHERE type=2 AND status=1 ORDER by rating DESC, id DESC LIMIT 20");
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
<div class=\"my-2 col-md-4 col-6\" dillerCard>
    			<div class=\"$disclass card position-relative border border-white shadow\" style='overflow:hidden;background:rgb(111, 138, 213,0.5) !important'>
				$disstext
                <a class=\"d-flex align-items-center justify-content-center infoIcon\" info='{$diller['id']}' name='{$diller['name']}'><i class=\"la la-info\" data-bs-toggle=\"modal\" data-bs-target=\"#infoBox\"></i></a>
                <div style='background:url({$diller['logo']});background-size:cover;background-position:center;padding-top:75%;'></div>
					<!--<img src=\"{$diller['logo']}\" class=\"card-img-top\" alt=\"Coca cola\">-->
					<div class=\"card-body py-1\">
						<h5 dillerName class=\"card-title text-white\">{$diller['name']}</h5>
						<div class=\"row\">
							<div class=\"col-12 col-xl-6 my-2\">
								<div class=\"d-grid\">
									<a order name='{$diller['name']}' diller='{$diller['id']}' href=\"#\" class=\"btn btn-outline-light position-relative\" data-bs-toggle=\"modal\" data-bs-target=\"#order\">$newtext
                                    <span prodMobText class='d-none'><i class=\"las la-dolly-flatbed\"></i></span>
                                    <span prodFullText class='x'>Tovar</span>
                                    </a>
								</div>
							</div>
							<div class=\"col-12 col-xl-6 my-2\">
								<div class=\"d-grid\">
									<a catalog='{$diller['id']}' name='{$diller['name']}' href=\"#\" class=\"btn btn-outline-light\" data-bs-toggle=\"modal\" data-bs-target=\"#catalog\">
                                    <span catMobText class='d-none'><i class=\"las la-list\"></i></span>
                                    <span catFullText class='x'>Kategoriya</span></a>
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

