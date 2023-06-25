<div class="row bg-white p-3 rounded">
<div class="col-12">
<?php
if(isset($_GET['d'])){

    $inPage = 10;
    $_POST['diller'] = $_GET['d'];

    $allProducts = $db->query("SELECT * FROM products WHERE diller={$_POST['diller']}")->num_rows;
    $p = 1;
    if(isset($_GET['pn'])){
        $p = $_GET['pn'];
    }
    $offset = ($p-1)*$inPage;
    echo "
        <div class='col-md-12'>
        <p class='py-2'>Jami maxsulotlar: $allProducts</p>
        <hr>

        </div>
        ";
    $query = "";
    if(!empty($_POST['orderQuery'])){
        $query = "AND name LIKE '%{$_POST['orderQuery']}%'";
    }
    $dillerDisc = $db->query("SELECT * FROM discounts WHERE diller={$_POST['diller']}");
    if($dillerDisc->num_rows>0){
        $dillerDisc = $dillerDisc ->fetch_assoc();
        switch($dillerDisc['dis_type']){
            case 1:
                $discType = "Buyurtmada maxsulot turi <b>{$dillerDisc['dis_min']}</b> tadan oshsa";
                break;
            case 2:
                $discType = "Buyurtma narxi <b>".number_format($dillerDisc['dis_min'], 0, '', ' ')."</b> so'mdan oshsa";
                break;
        }
        echo "
        <div class='col-md-12'>
        <p class='py-2 text-center text-danger'>$discType <b>{$dillerDisc['dis']}%</b> chegirma mavjud.</p>
        <hr>

        </div>
        ";
    }
    $tovars = $db->query("SELECT * FROM products WHERE diller={$_POST['diller']} $query ORDER BY rec DESC, new DESC, discount_type DESC,name ASC, price DESC, discount desc,id DESC LIMIT $inPage OFFSET $offset");
    echo '<ul class="row list-unstyled">';
    while($tovar=$tovars->fetch_assoc()){
        $dis_text ="";
        $recomendated = "";
        if($tovar['rec']>0){
            $recomendated = "<marquee behavior='alternate' class='d-block w-50 mx-auto mb-1 text-danger'><b>Tavsiya etiladi!!!</b></marquee>";
        }

        $disc = "";
        if($tovar['discount_type']>0){
            $disc = "<img src='/assets/img/discount.png' style='position:absolute;width:40%;top:-20%;left:0'>";
            if($tovar['discount_type'] == 1){
            $dis_text = "<div class='col-12 text-center mb-2'>
                <small class='text-danger'>Narxi ".number_format($tovar['discount_price'], 0, '', ' ')." dan oshsa chegirma {$tovar['discount']}%</small>
                </div>";
        } else {
                $dis_text = "<div class='col-12 text-center mb-2'>
                <small class='text-danger'>Chegirma {$tovar['discount']}%</small>
                </div>";
            }

        }
        $new = "";
        if($tovar['new']>0){
            $new = "<img src='/assets/img/new.png' style='position:absolute;width:40%;top:-20%;right:0'>";
        }

        $unit = $db->query("SELECT * FROM units WHERE id={$tovar['unit']}")->fetch_assoc();
        echo "<li class=\"col-12 col-md-6 my-2 border-bottom border-primary border-right\">
        $recomendated
            <div class=\"row\">

                <div class=\"col-3 position-relative\">

                $disc
                $new
                <a><img prodimageview style='cursor:pointer' src=\"{$tovar['photo']}\" width=\"100%\"></a>
            </div>
            <div class=\"col-4\">
            <div class=\"row\">
                <div class=\"col-12\"><p class=\"m-0\">{$tovar['name']}</p></div>
                <div class=\"col-6 pe-0\">
                <input class=\"form-control\" type=\"number\" size=\"1\" value=\"";
        if($tovar['min']>$tovar['stock']){
                    $tovar['min']=$tovar['stock'];
                }
        if($tovar['min']<0){
            $tovar['min']=0;
            $tovar['stock']=0;
            }
        echo "{$tovar['min']}\"

                min='{$tovar['min']}' max='{$tovar['stock']}' count_prod='{$tovar['id']}' style=\"height:25px !important;\"></div>
                <div class=\"col-6 ps-0\">{$unit['name_uz']}</div>
                <div class=\"col-12\"><button  card='{$tovar['id']}' diller='{$_POST['diller']}' product='{$tovar['id']}' user='{$_SESSION['userId']}' count='{$tovar['min']}' class=\"btn text-primary cursor-pointer text-decoration-none\" style='cursor:pointer'><i class=\"la la-shopping-cart\"></i> Buyurtma</button>
                </div>

            </div>
            </div>
            <div class=\"col-5\">
                <h3 align=\"center\">".number_format($tovar['price'], 0, '', ' ')." so'm</h3>
                <p align=\"center\">{$unit['name_uz']}</p>
            </div>
        $dis_text
            </div>
        </li>";
    }
    echo '</ul>';
    echo "<div class='row'> <div class='col-12'>";
    $pages = $allProducts/$inPage;
    if($pages!=(int)$pages){
    $pages = (int)$pages+1;
    }
    $backDis = "";
    if($p==1){
        $backDis = "disabled";
    }
    $nexDis = "";
    if($p==$pages){
        $nexDis = "disabled";
    }
    echo "<nav aria-label='...'>
  <ul class='pagination flex-wrap justify-content-center'>
   <li class='page-item $backDis'>
      <a class='page-link' href='/?go=products&d={$_POST['diller']}&pn=1' tabindex='-1' aria-disabled='true'>Boshiga</a>
    </li>";
   $n = 1;
    while($n<=$pages){
        $act = "";
        $current = "";
        if($n==$p){
            $act = "active";
            $current = "aria-current='page'";
        }
        echo "
    <li class='page-item $act' $current><a class='page-link' href='/?go=products&d={$_POST['diller']}&pn=$n'>$n</a>
    </li>
    ";
        $n++;
    }

  echo "<li class='page-item $nexDis'>
      <a class='page-link' href='/?go=products&d={$_POST['diller']}&pn=$pages'>Oxirgi</a>
    </li></ul>
</nav>";

    echo "</div></div>";


























} else {
 echo "Xatolik";
}

?>
</div></div>
<script>
$("[card]").click(function(){
    $allow = false
    $prod = $(this).attr("product")
    $count = $("[count_prod="+$prod+"]").val()
    $min = $("[count_prod="+$prod+"]").attr("min")
    $max = $("[count_prod="+$prod+"]").attr("max")
    $diller = $(this).attr("diller")
    $user = $(this).attr("user")
    if($max==0){
        alert("Mahsulot vaqtincha omborda mavjud emas")
    }
    else if($count==0){
        alert("Buyurtmada tovar soni mavjud emas")
    }
    else {
        if(parseInt($count)<parseInt($min)){
            alert("Kamida "+$min+" ta bo'lishi kerak")
        } else{
            $allow = true
        }
    }

    if($allow==true){
        $.ajax({
        url:"/__ajax/__ajax_basket.php",
       type:"POST",
       data:{addCard:1,user:$user,prod:$prod,count:$count,diller:$diller},
       cache:false,
       success:function($basket){
           $("#basketBody").html($basket)
           alert("Savatchaga qo'shildi")
       },
       error: function (request, error) {
        console.log(arguments);
        alert(" Can't do because: " + error);
    },
    })
    }

})

    $("[prodimageview]").click(function(){
        $(".imgView").css("top",$(document).scrollTop()+"px")
        $("#prodimage").attr("src",$(this).attr("src"))
        $(".imgView").fadeIn(200)
        })

</script>
