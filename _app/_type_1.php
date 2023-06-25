<?php
$go = "main";
$go_pages = [
    "main" => "Dillerlar",
    "clients"=>"Buyurtmachilar",
    "category"=>"Bo'limlar",
    "units"=>"O'lchov birliklar",
    "notify"=>"Xabarnomalar",
    "stat"=>"Statistika",
    "rating"=>"Reyting"

    ];
if(isset($_GET['go'])){
    $_GET['go'] = $db->real_escape_string($_GET['go']);
    if(array_key_exists($_GET['go'],$go_pages)){
        $go = $_GET['go'];
    } else {
        $go = "main";
    }

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ViWare - <?php echo $go_pages[$go]?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/app.css?ver=2">
    <link rel="stylesheet" href="/assets/css/line-awesome.min.css">
</head>
<body>
<div class="container-fluid ps-0">
    <div class="row">
		<div class="col-12 pe-0">
	<div class="col-12  head h-40 shadow-sm sticky">
		<div class="container h-100">
			<div class="row h-100 d-flex align-items-center">
			<div class="col-6 col-md-3">
				<img src="/logo.png?ver=1" width="100%">
			</div>
			<ul class="col-6  col-md-9 m-0 list-unstyled topIcon" align="right">


				<li class="d-inline-block mx-1">
				<a href="/?out" class="bell"><i class="la la-sign-out"></i></a>
				</li>
			</ul>
		</div>

		</div>
		</div>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="/">Viware</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 menu">
          <?php
    foreach($go_pages as $url=>$text){
        $active = "";
        if($go == $url){
            $active = "active";
        }
        if($go=="edit" && $url=="main"){
            $active = "active";
        }
        if($url!="edit" && $url!="orderview"){
            echo "
            <li class=\"nav-item\">
          <a class=\"nav-link $active\" href=\"/?go=$url\">$text</a>
        </li>


        ";
        }
    }


    ?>


      </ul>

    </div>
  </div>
</nav>

	<div class="container-fluid mt-2">
	<div class="col-12">

	<?php
        include __DIR__."/_1/_$go.php";

        ?>
	</div></div>
		</div>
		</div>
</div>

	<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bgMango">
        <h5 class="modal-title text-white" id="exampleModalLabel">"Coca Cola baraka" MChJ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="row list-unstyled">
        <li class="col-12 border-bottom borBlue my-2 py-2">
        	<div class="row">
        		<div class="col-3">
        		<img src="/cola.jpeg" width="100%">
        	</div>
        	<div class="col-9">
        	<div class="row">
        		<div class="col-12"><p class="m-0">Coca cola 0.5 литр</p></div>
        		<div class="col-3"><input class="form-control" type="number" size="1" value="1" style="height:25px !important;"></div>
        		<div class="col-9">блок</div>
        		<div class="col-12"><a href="" class="text-primary text-decoration-none"><i class="la la-shopping-cart"></i> Добавить корзину</a></div>
        	</div>


        	</div>

        	</div>
        </li>
         <li class="col-12 border-bottom borMango">
        	<div class="row">
        		<div class="col-3">
        		<a href="#"><img src="/cola.jpeg" width="100%"></a>
        	</div>
        	<div class="col-5">
        	<div class="row">
        		<div class="col-12"><p class="m-0">Coca cola 0.5 литр</p></div>
        		<div class="col-6"><input class="form-control" type="number" size="1" value="1" style="height:25px !important;"></div>
        		<div class="col-6">блок</div>
        		<div class="col-12"><a href="" class="text-primary text-decoration-none"><i class="la la-shopping-cart"></i> Добавить корзину</a></div>
        	</div>
        	</div>
        	<div class="col-4">
        		<h3 align="center">4500 сум</h3>
        		<p align="center">Блок</p>
        	</div>

        	</div>
        </li>

        		</ul>
      </div>
      <div class="modal-footer" style="background-image:url(/bg/6.jpg)">
        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Yopish</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="messageDialog" tabindex="-1" aria-labelledby="messageDialogLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bgMango">
        <h5 class="modal-title text-white" id="messageDialogLabel">Собщении</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer bgBlue">
        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Yopish</button>
      </div>
    </div>
  </div>
</div>

	<script src="/assets/js/bootstrap.bundle.min.js"></script>
	<script src="/assets/js/jquery-3.6.0.min.js"></script>
<script>

     $("#unit").change(function(){
        $unit = $("#unit option:selected").html()
        $("#min_unit").html($unit)
         $("#price_areapre").html("1 - "+$unit)
    })
    $("#discount_type").change(function(){
        $val = parseInt($(this).val())
        if($val==1){
            $("#discount_price").removeAttr("disabled")
            $("#discount").removeAttr("disabled")
        }
        else if($val==2){
            $("#discount_price").attr("disabled","disabled")
            $("#discount").removeAttr("disabled")
        }
        else {
            $("#discount_price").attr("disabled","disabled")
            $("#discount").attr("disabled","disabled")
        }
    })
    $("[load]").change(function(){
        $unit = $("[load] option:selected").attr("unit")
        if($unit!='0'){
            $("#count_area").html($unit)
        $("#count").removeAttr("disabled")
        } else {
           $("#count_area").html("")
        $("#count").attr("disabled","disabled")
        }

    })
    $("#ok").click(function(){
    $("#offerta").hide(100,function(){
        $("#reg").show(100)})

    })
    $("[regbutton]").click(function(){
    $("#offerta").show()
     $("#reg").hide()

    })


    </script>

</body>
</html>
