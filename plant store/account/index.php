<!DOCTYPE html>
<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('location: ../notfound.php');
    exit;
}
?>
<html>
<head>
<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Berkshire+Swash|Kaushan+Script">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400|Roboto:300,400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400|Roboto:300,400,700">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="../assets/css/styles.min.css">
</head>
<body>
<?php 
include("header.php")?>
    <div class="container">
        <div class="welcome justify-content-center">
            <h2 style="margin-top:30px; margin-bottom:50px">Twoje zamowienia</h2>
            <div class="row container d-flex ">
                <div class="col-sm-12 col-md-3" style="margin-top: 1px;">
                   <div style="text-align:center;"><img src="https://img.icons8.com/bubbles/100/000000/user.png" class="img-radius" alt="User-Profile-Image" > 
                    <h2 data-text="Witaj" style="margin-top:16px" >Witaj <?=$_SESSION["username"]?> </h2>
                    <?php 
                    //Authorize
                    if (!isset($_SESSION['id'])) {
                        header('HTTP/1.0 403 Forbidden');
                        exit;
                    }else{
                        $sql = "SELECT role FROM users WHERE id_user='$_SESSION[id]'";
                        $query = mysqli_query($connection,$sql);
                        $row=mysqli_fetch_array($query);
                        if($row["role"]=="ADMIN"){
                            echo '<a href="../admin" style="margin-top:16px" >Panel Administratora</a>';
                        }
                    }?>
                    </div> 
                </div>

                <div class="col-sm-12 col-md-8 "style="overflow-x:auto; padding-left:0; padding-right:0;">
                <?php 
                include("orders.php")
                ?>
                </div>

            </div>           
            </div>
        </div>
    </div> 
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
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js"></script>
    <script src="../assets/js/script.min.js"></script>

</body>
</html>