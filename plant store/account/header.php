<!DOCTYPE html>
<?php 
include("../db_connection.php");
$number_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <title>PlantStore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400|Roboto:300,400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400|Roboto:300,400,700">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/css/swiper.min.css">
    <link rel="stylesheet" href="../assets/css/styles.min.css">
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js"></script>
    <script src="../assets/js/script.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md navigation-clean-button">
        <div class="container">
            <a class="navbar-brand" href="../index.php">PlantStore</a>
            <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle
                    navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link " href="../index.php" style="color: #ffffff;">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" style="color: #ffffff;" role="button" data-toggle="dropdown" id="navbarProducts">Produkty</a>
                    <div class="dropdown-menu" aria-labelledby="navbarProducts">
                    <h6 class="dropdown-header">Produkt:</h6>
                    <a class="dropdown-item" href="../products.php">Wszystkie produkty</a>

                    <a class="dropdown-item dropdown-toogle" href="#" role="button" data-toggle="dropdown" id="navbarCategory">Kategorie:</a>
                        <div class="dropdown-menu" aria-labelledby="navbarCateogry" id="navbarCategory" style="position: relative; background-color: #F8F9FA">
                        <?php
                        $categoriesList = mysqli_query($connection, "SELECT name,id_category FROM `categories`") or die ("blad zapytania select(pobieranie kategorii)");
                        while($row = mysqli_fetch_array($categoriesList)):?>
                        <a class="dropdown-item" href="../products.php?category=<?=$row[1]?>">- <?=$row[0]?></a>
                        <?php endwhile;
                        ?>
                        </div>
                    <div class="dropdown-divider"></div>
                    <h6 class="dropdown-header">Personalizowane:</h6>
                    <a class="dropdown-item" href="../products.php?option=1">Łatwe w uprawie</a>
                    <a class="dropdown-item" href="../products.php?option=2">Lubiące światło</a>
                    <a class="dropdown-item" href="../products.php?option=3">Wymagające rośliny &nbsp; &nbsp;&nbsp;&nbsp;</a>
                    </div>
                    </li>
                </ul>
                <div class="cart "><a href="../cart.php"><i class="fa fa-shopping-cart"> </i></a>
                    <span class="cart-basket_dot">
                        <sup style="position: relative;
    right: -5px;
    top: -9.5px;"> <?=$number_items_in_cart?> </sup>
                    </span>
                </div>
                <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                    <div class="dropdownn">
                                <a href="index.php" style="color:white; padding-top: 20px"><p style="margin-top:16px"> Witaj <?=$_SESSION["username"]?></p></a>
                            </div>
                            <span class="navbar-text actions">
                                <a class="btn action-button" href="../logout.php"> Wyloguj się</a>
                             </span>
                <?php else: ?> 
                <span class="navbar-text actions">
                    <a class=" btn action-button" href="../login.php"> Zaloguj sie</a>
                    <a class="btn action-button" role="button" href="../register.php">Rejestracja</a>
                </span>
                <?php endif; ?> 


            </div>
        </div>
    </nav>

    <div id="id01" class="modal">

        <form class="modal-content animate" action="/action_page.php" method="post">
            <div class="imgcontainer">
                <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                <img src="assets/img/icon.png" alt="Avatar" class="avatar">
            </div>

            <div class="container">
                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="uname" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" required>

                <button type="submit">Login</button>
                <label>
                    <input type="checkbox" checked="checked" name="remember"> Remember me
                </label>
            </div>

            <div class="container" style="background-color:#f1f1f1">
                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                <span class="psw">Forgot <a href="#">password?</a></span>
            </div>
        </form>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById('id01');

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js"></script>
    <script src="../assets/js/script.min.js"></script>
</body>
</html>