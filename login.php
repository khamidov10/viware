<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Kirish</title>
<link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/login.css">




    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      .btnL{
            background:#6f8ad54D;
          border:1px solid #fff;
          transition: background 0.5s;
          color:#fff;
          }
        .btnL:hover{
            background:#6f8ad5;
            color:#fff;
            }
    </style>


    <!-- Custom styles for this template -->
  </head>
  <body class="text-center">

<main class="form-signin rounded p-4" style="background:rgb(255,255,255,0.3)">
  <form method="POST" action="/">
    <img class="mb-1" src="/logo.png?ver=1" alt="" height="57">

<?php
    if($message=="error"){
        echo "<h6 class='text-danger text-center my-1'>Login yoki parol xato!</h6>";
    }

    if($message=="regTrue"){
        echo "<h6 class='text-success text-center my-1'>Ro'yxatdan o'tdingiz!</h6>";
    }
      if($message=="regFalse"){
        echo "<h6 class='text-danger text-center my-1'>Qandaydur Ybanuti xato: ".$db->error."!</h6>";
    }

      ?>
    <div class="form-floating my-2">
      <input type="text" name="login" class="form-control" id="floatingInput" placeholder="STIR (INN)" autocomplete="off" required>
      <label for="floatingInput">STIR (INN) raqami</label>
    </div>
    <div class="form-floating my-2">
      <input type="password" name="pass" class="form-control" id="floatingPassword" placeholder="Password" required>
      <label for="floatingPassword">Parol</label>
    </div>


    <button class="w-100 btn btn-lg btnL" name="sign" value="in">Kirish</button>
    <a class="w-100 btn btn-lg btnL my-1" href='/register.php'>Ro'yxatdan o'tish</a>
    <p class="mt-5 mb-3 text-white">Developed: "Breeze Soft"</p>
  </form>
</main>



  </body>
</html>
