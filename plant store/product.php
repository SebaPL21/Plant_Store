<!DOCTYPE html>
<?php 
session_start();
include("db_connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = 'SELECT * FROM products WHERE id_product='. $id;
    $result=mysqli_query($connection,$sql)or die ("Blad zapytania select");
}else{
    header('location: products.php');
}

$product = mysqli_fetch_array($result);

if($product['name'] == ""){
    header('location: notfound.php');
}

mysqli_close($connection);
?>
<html lang="pl">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>PlantStore - Produkt</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Berkshire+Swash|Kaushan+Script">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400|Roboto:300,400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400|Roboto:300,400,700">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <style>
        .checked { color: orange;}
        .checked-water { color: #83d7ee;}
        .checked-sun { color: #FCD440;}
    </style>
</head>

<body>
    <?php include("header.php"); ?>
    <div class="container">
        <h1 style="text-align: center; margin-top:30px">
            <?=$product['name']?>
        </h1>
        <div class="row">
            <div class=" col-md-7">
                <img src="data:image/jpeg;base64,<?=base64_encode($product['img'] )?>" height="500" width="500"/>
            </div>
            <div class=" col-md-5">
                <h3>Opis produktu</h3>
                <p><?=$product['description']?></p>
                <h2>
                    <?=number_format($product['price'],2)?> zł.
                </h2>
                <form action="cart.php" method="post">
                    Ilość: <input type="number" name="quantity" value="1" min="1" placeholder="Quantity" required>
                    <input type="hidden" name="id_product" value="<?=$product['id_product']?>">
                    <button class="btn btn-danger  btn-lg " type="submit"><i class="fa fa-cart-plus"></i> Dodaj do koszyka</button>
                </form>
            </div>
        </div>
        <div class="opisrosliny">
            <?php 
                if($product['id_category'] != 11):
            ?>
            <h3>
                Dodatkowe informacje
            </h3>
            <div class="row">
            <div class=" col-md-6">
               Trudność uprawy
               <?php 
               for($i = 1; $i<=5; $i++){
                    if($product['difficulty_of_growing'] >= $i){
                        echo '<span class="fa fa-star checked"></span>';
                    }else{
                        echo '<span class="fa fa-star"></span>';
                        }
                    }
               ?></br>
               Częstość podlewania
               <?php 
               for($i = 1; $i<=5; $i++){
                    if($product['watering_frequency'] >= $i){
                        echo '<span class="fa fa-tint checked-water"></span>';
                    }else{
                        echo '<span class="fa fa-tint"></span>';
                        }
                    }
               ?></br>
               Nasłonecznienie
               <?php 
               for($i = 1; $i<=5; $i++){
                    if($product['insolation'] >= $i){
                        echo '<span class="fa fa-sun-o checked-sun"></span>';
                    }else{
                        echo '<span class="fa fa-sun-o"></span>';
                        }
                    }
               ?></br>
            </div>
            <div class=" col-md-6">
                <p><b>Alergeny:</b> <?=$product['allergens']?></p>
            </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <h3 class="text-center" style="padding-top:60px">Proponowane produkty:</h3>
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