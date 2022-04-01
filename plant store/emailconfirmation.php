<!DOCTYPE html>
<?php 
session_start();
unset($_SESSION['cart']);
?>
<html lang="pl">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>PlantStore - Nowe konto</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Berkshire+Swash|Kaushan+Script">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400|Roboto:300,400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400|Roboto:300,400,700">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
</head>

<body>
 <?php include("header.php"); ?>
    <div class="text-center">
    <img src="assets/img/happy_plant.png" width=150px height=auto style="margin-top:2%; margin-bottom:2%">
    <h2>Dziękujemy za rejestracje !</h2>
    </br>
    </br>
        <div class="col-sm-12 my-auto" style="background: #ebf8f3; padding: 30px">
        <h3>Od teraz możesz swobodnie robić zakupy na naszej stronie.</h3>
        <h4 style="padding-top: 30px">Aby zalogować się <a href="login.php" style="color:#e23838">kliknij tutaj</a></h4>
        </div>
    </div>
    <h3 class="text-center" style="padding-top:50px">Zobacz także:</h3>
    <?php include("productslider.php"); ?>
 <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-8 col-sm-6 col-md-6">
                    <p class="text-left">© 2021 PlantStore</p>
                </div>
                <div class="col-12 col-sm-6 col-md-6">
                    <p class="text-right">Kontakt:&nbsp;&nbsp;<i class="fa fa-facebook"></i>&nbsp; &nbsp;<i class="fab fa-discord"></i> &nbsp; &nbsp;&nbsp;
                    </p>
                </div>
            </div>
        </div>
    </div>
 </body>
 </html>
