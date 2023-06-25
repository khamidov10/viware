<?php
    $u = $db->query("SELECT * FROM users WHERE id={$_SESSION['userId']}")->fetch_assoc();

$notify = $db->query("SELECT * FROM notification WHERE n_to={$u['type']} OR n_to=0");
$nf_count = $notify->num_rows;
while($nf=$notify->fetch_assoc()){
    $nf_check = $db -> query("SELECT * FROM nf_read WHERE n_id={$nf['id']} AND u_id={$_SESSION['userId']}");
    $nf_count = $nf_count - $nf_check->num_rows;
}
$go = "main";
if(isset($_GET['go'])){

$go = $_GET['go'];

if($go=="basket"){
        $go = "main";
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ViWare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/line-awesome.min.css">
     <script src="/assets/js/jquery-3.6.0.min.js"></script>
         <link rel="stylesheet" href="/assets/css/app.css?ver=5.5">

<style>
.imgView{
    position:absolute;
    display:flex;
    align-items:center;
    justify-content:center;
    height:100vh;
    width:100%;
    z-index:9999;
    flex-direction:column;
    }
.imgView>img{
    border:4px solid #ccc;
    }
    .closing{
        background:red;
        padding:10px;
        color:#fff;
        cursor:pointer;
        position:absolute;
        top:0;
        right:0;
        z-index:9999;
        font-size:3rem;
        }
        .closing:hover{
            background:#ccc;
            }
</style>

</head>
<body>
<div class="imgView" style="display:none">
<div class="closing"><i class='la la-close'></i></div>
     <div width="80%" style="background:#fff"> 
     <img width="100%" id='prodimage' src="">
     </div>
     
</div>

<div class="container-fluid ps-0">
    <div class="row">
    <?php
    /*$col = 12;
    $col2 = 12;
    if($go == "orderview" || $go=="orders" || $go=="info" || $go=="credit"){
        $col=12;
        $col2=12;
        }*/
    ?>
        <div class="col-md-12 col-12 pe-0" id="prodZone" >
    <div class="col-12  h-40 shadow-sm sticky head">
        <div class="container h-100">
            <div class="row h-100 d-flex align-items-center">
            <div class="d-none d-md-block col-md-3">
                <a href="/"><img src="/logo.png?ver=1" width="100%"></a>
            </div>
            <ul class="col-12  col-md-9 m-0 list-unstyled topIcon" align="right">
                <li class="d-none d-sm-none d-md-inline-block mx-1">
                <a href="/" class="bell"><i class="la la-home"></i></a>
                </li>
                <li data-bs-toggle="modal" data-bs-target="#searchBox" class="d-inline-block mx-1">
                <a href="#" class="bell"><i class="las la-search"></i></a>
                </li>
                <li class="d-inline-block d-md-none mx-1">
                <a href="#" id="mobList" class="bell"><i class="la la-list"></i></a>
                </li>






                <li class="d-none d-sm-none d-md-inline-block mx-1">
                <a href="/?go=cats" class="bell"><i class="las la-sliders-h"></i></a>
                </li>

                <li class="d-none d-sm-none d-md-inline-block mx-1 ">

                <a href="/?go=orders" class="bell position-relative">
                <i class="la la-shopping-cart"></i>
                </a>
                </li>

                <li class="d-none d-sm-none d-md-inline-block mx-1">
    			<a href="/?go=credit" class="bell"><i class="las la-hand-holding-usd"></i></a>
				</li>


				<li class="d-none d-sm-none d-md-inline-block mx-1" notify="<?php echo $_SESSION['userId'];?>">
				<a data-bs-toggle="modal" data-bs-target="#notification" href="" class="bell position-relative"><i class="la la-bell"></i>
				<?php
                   if($nf_count>0){
                       echo '
                    <span class="rounded-circle num bg-danger text-white">'.$nf_count.'</span>';
                   }

                        ?>
				</a>
				</li>


                <!------
				<li class="d-none d-sm-none d-md-inline-block mx-1">
				<a data-bs-toggle="modal" data-bs-target="#messageDialog" href="" class="bell position-relative"><i class="la la-envelope"></i>
				</a>
				</li> ----------------->

				<li class="d-none d-sm-none d-md-inline-block mx-1">
				<a href="/?go=info" class="bell"><i class="la la-user"></i></a>
				</li>






				<li class="d-none d-sm-none d-md-inline-block mx-1">
				<a href="/?out" class="bell"><i class="la la-sign-out"></i></a>
				</li>
				<li class="d-inline-block mx-1">
                <a href="#" id="basketView" class="bell" do="open"><i class="la la-arrow-left"></i></a>
                </li>
			</ul>
		</div>

		</div>
		</div>
	<div class="container-fluid mt-2">
	<?php
      include $_SERVER['DOCUMENT_ROOT']."/_app/_3/_$go.php";
    ?>
	</div>
		</div>
		<div class="col-md-3 col-5 h-full shadow border-start border-white px-0" style="display:none;" id="basketZone">
		<div class="h-100 position-relative" id="basketBody">
		 <?php
            include $_SERVER['DOCUMENT_ROOT']."/_app/_3/_basket.php";

            ?>
		</div>
		</div>
	</div>
</div>

	<!-- Modal -->
<div class="modal fade" id="order" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-transparent">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="orderLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="orderBody" style="background:rgb(255,255,255,0.9)">
        <!--  Zdes bil ya --->
        </div>
      <div class="modal-footer bg-primary">
        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Yopish</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="catalog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-transparent">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="catalogLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="catalogBody" style="background:rgb(255,255,255,0.9)">
        <!--  Zdes bil ya --->
        </div>
      <div class="modal-footer bg-primary">
        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Yopish</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="messageDialog" tabindex="-1" aria-labelledby="messageDialogLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="messageDialogLabel">Xabarlar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="messageDialogBody">
        Ayni damda xabar mavjud emas
      </div>
      <div class="modal-footer bg-primary">
        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Yopish</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="searchBox" tabindex="-1" aria-labelledby="searchBoxLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="searchBoxLabel">Izlash</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="searchBoxBody">
        <form action="/?go=search" method="POST" class="row">
            <!---<div class="col-12 my-2">
               <label for="searchType">Izlash turi</label>
                <select name="searchType" required id="searchType" class="form-select">
                   <option value="">Tanlang</option>
                    <option value="1">Dillerlar nomi bo'yicha</option>
                    <option value="2">Maxsulot nomi bo'yicha</option>
                </select>
            </div> ------------->
            <input type="hidden" name="searchType" value="2">
             <div class="col-12">
                <label for="searchQuery">Izlash uchun so'z</label>
                 <input id="searchQuery" required name="searchQuery" type="text" class="form-control" placeholder="Izlash uchun so'zni kiriting">
             </div>
             <div class="col-4 offset-4 my-2">
                 <div class="d-grid">
                     <button name="search" class="btn btn-primary">
                         <i class="la la-search"></i> Izlash
                     </button>
                 </div>
             </div>
        </form>
      </div>
      <div class="modal-footer bg-primary">
        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Yopish</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="notification" tabindex="-1" aria-labelledby="notificationLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="notificationLabel">Xabarnoma</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="notificationBody">
        ...
      </div>
      <div class="modal-footer bg-primary">
        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Yopish</button>
      </div>
    </div>
  </div>
</div>
 <div class="modal fade" id="imageBox" tabindex="-1" aria-labelledby="notificationLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-transparent">
        <button type="button" class="btn-close btn-primary" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0" id="imgBoxBody">

      </div>

    </div>
  </div>
</div>
 <div class="modal fade" id="infoBox" tabindex="-1" aria-labelledby="infoBoxLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-transparent">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="infoBoxLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="infoBoxBody" style="background:rgb(255,255,255,0.9)">
        <!--  Zdes bil ya --->
        </div>
      <div class="modal-footer bg-primary">
        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Yopish</button>
      </div>
    </div>
  </div>
</div>
<style>
           .mobMenu{
               display:none;
               position: fixed;
               width: 60%;
               background: rgb(0,0,0,0.8);
               height: 100vh;
               z-index: 999;
               top:0;
               left: 0;
               padding:1rem ;

           }
           .mobMenu a{
               text-decoration: none;
               font-size: 1.2rem;
           }
    @media screen and (min-width:768px){
        .mobMenu{
            display:none !important;
        }
    }
    </style>
        <ul class="mobMenu list-unstyled">
                <li class="mx-1" align="right">
				<a href="#" id="close" class="bell"><i class="la la-close"></i></a>
				</li>
    			<li class="mx-1">
				<a href="/" class="bell"><i class="la la-home"></i> Bosh sahifa</a>
				</li>



                <li class="mx-1 ">
    			<a href="/?go=cats" class="bell position-relative">
				<i class="las la-sliders-h"></i> Bo'limlar
				</a>
				</li>

                <li class="mx-1 ">
    			<a href="/?go=orders" class="bell position-relative">
				<i class="la la-shopping-cart"></i> Buyurtmalar
				</a>
				</li>

                <li class="mx-1">
    			<a href="/?go=credit" class="bell"><i class="las la-hand-holding-usd"></i> Qarzdorlik</a>
				</li>


				<li class="mx-1" notify="<?php echo $_SESSION['userId'];?>">
				<a data-bs-toggle="modal" data-bs-target="#notification" href="" class="bell position-relative"><i class="la la-bell"></i> Xabarnoma
				<?php
                   if($nf_count>0){
                       echo '
                    <span class="rounded-circle num bg-danger text-white">'.$nf_count.'</span>';
                   }
                        ?>
				</a>
				</li>




				<!---- <li class="mx-1">
				<a data-bs-toggle="modal" data-bs-target="#messageDialog" href="" class="bell position-relative"><i class="la la-envelope"></i>  Xabarlar
				</a></li>  --------------->










				<li class="mx-1">
				<a href="/?go=info" class="bell"><i class="la la-user"></i> Profil</a>
				</li>



				<li class="mx-1">
				<a href="/?out" class="bell"><i class="la la-sign-out"></i> Chiqish</a>
				</li>
			</ul>

	<script src="/assets/js/bootstrap.bundle.min.js"></script>
	<script src="/assets/js/jquery-3.6.0.min.js"></script>
	<script>
        $.each($(".num"),function(){
            $(this).width($(this).height())
        })
    </script>
    <script>
    $("#mobList").click(function(){
        $(".mobMenu").show(300)
    })
    $("#close").click(function(){
        $(".mobMenu").hide(300)
    })


    $("#viewMod").click(function(){

        $("[dillercard]").toggleClass("col-6");
        $("[grid]").toggleClass("la-toggle-on")
        $("[prodMobText]").toggleClass("d-none","d-block")
        $("[prodFullText]").toggleClass("d-none")
        $("[catMobText]").toggleClass("d-none","d-block")
        $("[catFullText]").toggleClass("d-none")
        $("[dillerName]").toggleClass("d-none")
        $("[stars]").toggleClass("d-none")
        $(".infoIcon").toggleClass("infomin")

    })
    $(".closing").click(function(){
        $(".imgView").fadeOut(100)
        })

        $("#basketView").click(function(){
            if($(this).attr("do")=="open"){
                $("#prodZone").attr("class","col-md-9 col-7 pe-0")
            $("#basketZone").show()
            $(this).html('<i class="la la-arrow-right"></i>')
             $(this).attr("do","close")

            if(!$("[grid]").hasClass("la-toggle-on")){
            $("#viewMod").click()
            }

            } else {
                $("#prodZone").attr("class","col-md-12 col-12 pe-0")
            $("#basketZone").hide()
            $(this).html('<i class="la la-arrow-left"></i>')
             $(this).attr("do","open")
             if($("[grid]").hasClass("la-toggle-on")){
            $("#viewMod").click()
            }
            }
        })
</script>
	<script src="/__ajax/all_ajax.js"></script>
<div class="modal fade" id="confirmOrder" tabindex="-1" aria-labelledby="confirmOrderLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title " id="confirmOrderLabel">Buyurtmani tasdiqlash</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="form-group py-1 border-bottom">
      <h4>Oldindan to'lov </h4>
       <label for="predoplata" to="5000000"><b>100</b>% <pay>5000000</pay> so'm</label>
        <input type="range" id="predoplata" class="form-range"  max="100" min="50" value="100">
        </div>
        <div class="form-group my-1">
          <h4>To'lov turi</h4>
          <input type="radio" class="form-check-input mx-1" name="payType" value="1" id="cash">
          <label for="cash">Naqd pulda</label>
          <input type="radio" class="form-check-input mx-1" name="payType" value="2" id="schet">
          <label for="schet">Pul ko'chirish</label>
          <input type="radio" class="form-check-input mx-1" name="payType" value="3" id="card">
          <label for="card">Plastik kartochka orqali</label>
      </div>
      <div class="form-group">
        <label for="comment" class="my-1"><b>Yetkazib beruvchiga qo'shimcha izoh qoldirishingiz mumkin:</b></label>
          <textarea name="comment" id="comment" cols="30" rows="5" class="form-control" placeholder="Yetkazib beruvchi uchun qo'shimcha"></textarea>
      </div>
      </div>

      <div class="modal-footer bg-primary">
        <button type="button" class="btn btn-light d-none" data-bs-dismiss="modal">Yopish</button>
        <button type="button" class="btn btn-light">Buyurtmani tasdiqlash</button>
      </div>
    </div>
  </div>
</div>
<script>
    $("[type=range]").on("input",function(){
        $pay = parseInt($("[for="+$(this).attr("id")+"]").attr("to"))
        $("[for="+$(this).attr("id")+"]>b").html($(this).val())
        $("[for="+$(this).attr("id")+"]>pay").html((parseInt($(this).val())*$pay)/100)
    })
    </script>
</body>
</html>
