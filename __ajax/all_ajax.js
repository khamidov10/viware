$("[order]").click(function(){
    $name = $(this).attr("name")
    $query = $(this).attr("query")
   $("#orderLabel").html($name)
    
   $diller = $(this).attr("diller")
   $.ajax({
       url:"/__ajax/__ajax_items.php",
       type:"POST",
       data:{diller:$diller,orderQuery:$query},
       cache:false,
       success:function($items){
           $("#catalogBody").html("")
           $("#orderBody").html($items)
       }
   }) 
    
})
$("[dillercat]").click(function(){
    $name = $(this).attr("name")
   $("#orderLabel").html($name)
    
   $dillercat = $(this).attr("dillercat")
    $catid = $(this).attr("catid")
   $.ajax({
       url:"/__ajax/__ajax_items.php",
       type:"POST",
       data:{dillercat:$dillercat,catid:$catid},
       cache:false,
       success:function($items){
           $("#catalogBody").html("")
           $("#orderBody").html($items)
       }
   }) 
    
})
$("[catalog]").click(function(){
    $name = $(this).attr("name")
   $("#catalogLabel").html($name)
    
   $diller = $(this).attr("catalog")
   $.ajax({
       url:"/__ajax/__ajax_items.php",
       type:"POST",
       data:{catalog:$diller},
       cache:false,
       success:function($items){
           $("#orderBody").html("")
           $("#catalogBody").html($items)
       }
   }) 
    
})
$("[delete]").click(function(){
    $id = $(this).attr("delete")
    $.ajax({
        url:"/__ajax/__ajax_basket.php",
        type:"POST",
        data:{delCard:1,id:$id},
        cache:false,
        success:function($basket){
         $("#basketBody").html($basket)   
        }
    })
})
$("[info]").click(function(){
    $name = $(this).attr("name")
   $("#infoBoxLabel").html($name)
   $diller = $(this).attr("info")
   $.ajax({
       url:"/__ajax/__ajax_items.php",
       type:"POST",
       data:{info:1,diller_id:$diller},
       cache:false,
       success:function($info){
           $("#infoBoxBody").html($info)
       }
   }) 
    
})
$("[notify]").click(function(){
   $notify = $(this).attr("notify")
   $.ajax({
       url:"/__ajax/__ajax_items.php",
       type:"POST",
       data:{notify:$notify},
       cache:false,
       success:function($info){
           $("#notificationBody").html($info)
       }
   }) 
    
})


	
