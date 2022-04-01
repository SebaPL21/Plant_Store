<!DOCTYPE html>
<?php
session_start();
error_reporting(0);
include("db_connection.php");

if (isset($_POST['id_product'], $_POST['quantity']) && is_numeric($_POST['id_product']) && is_numeric($_POST['quantity'])) {

    $id_product = (int)$_POST['id_product'];
    $quantity = (int)$_POST['quantity'];

    $sql = 'SELECT * FROM products WHERE id_product='. $id_product;
    $result=mysqli_query($connection,$sql)or die ("Blad zapytania select1");

    $product = mysqli_fetch_array($result);

    if ($product && $quantity > 0) {
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($id_product, $_SESSION['cart'])) {
                $_SESSION['cart'][$id_product] += $quantity;
            } else {
                $_SESSION['cart'][$id_product] = $quantity;
            }
        } else {
            $_SESSION['cart'] = array($id_product => $quantity);
        }
    }
    header('location: cart.php');
    exit;
}
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    unset($_SESSION['cart'][$_GET['remove']]);
}
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int)$v;
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
    header('location: cart.php');
    exit;
}
if (isset($_POST['order']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    header('Location: order.php');
    exit;
}
//Discount
$discount = 1;
if (isset($_POST['discount']) && isset($_SESSION['cart'])) {
    $disCode = $_POST['discode'];
    if($disCode=="MINUS10")
    {
    $discount = 0.9;
    $_SESSION['discount'] = $discount;
    }
}else{
$_SESSION['discount'] = $discount;
}


$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$subtotal = 0.00;
if ($products_in_cart) {
    $ids = array_keys($products_in_cart);
    $sql = 'SELECT * FROM products WHERE id_product IN (' . implode(',', array_map('intval', $ids)) . ')';
    $result=mysqli_query($connection,$sql)or die ("Blad zapytania select2");

    while($row = mysqli_fetch_array($result))
    {
        $subtotal +=  ((float)$row['price'] * (int)$products_in_cart[$row['id_product']]);
    }
    $subTotalWithOutDiscount = $subtotal;
    $subtotal *= $discount;
}
?>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>PlantStore - Koszyk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
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
    <div class="container">
        <h2 style="margin-top: 30px;">Twój koszyk</h2>
        <div class="col-md-8 col-sm-12 col-lg-8" style="overflow-x:auto;">
        <form action="cart.php" method="post">
        <table class="table" >
            <thead>
                <tr>
                    <th colspan="2">Produkt</th>
                    <th>Cena</th>
                    <th>Ilość</th>
                    <th>Łącznie</th>
                    <th>Usuń</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result == null): ?>
                <tr>
                    <td colspan="6" style="text-align:center;">Nie masz produktów w koszyku</td>
                </tr>
                <?php else:
                $result=mysqli_query($connection,$sql)or die ("Blad zapytania select3"); ?>
                <?php while($product = mysqli_fetch_array($result)): ?>
                <tr>
                    <td>
                        <img src="data:image/jpeg;base64,<?=base64_encode($product['img'])?>" height="100" width="100"/>
                    </td>
                    <td>
                        <a href="product.php?id=<?=$product['id_product']?>"><?=$product['name']?></a>
                    </td>
                    <td ><?=number_format($product['price'],2)?> zł</td>
                    <td>
                        <input type="number" name="quantity-<?=$product['id_product']?>" value="<?=$products_in_cart[$product['id_product']]?>" min="1" placeholder="Quantity" required>
                    </td>
                    <td><?=number_format($product['price'] * $products_in_cart[$product['id_product']],2)?> zł</td>
                    <td>
                        <a class="btn btn-danger" href="cart.php?remove=<?=$product['id_product']?>"><i class="far fa-trash-alt d-xl-flex justify-content-xl-center align-items-xl-center"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table> 
        </div>
        <div class="suma col-md-4 col-sm-12 col-lg-4">
            <h4 class="text">Suma:
                <?=number_format($subtotal,2)?> zł.
            </h4>
            <?php if($subTotalWithOutDiscount-$subtotal!=0):?>
            <h6>Kod rabatowy: <?=$disCode?>  <button class="btn btn-secondary btn-sm" type="submit" name="update">Usuń kod rabatowy</button></h6>
            <h6>Używajac kodu oszczędzasz: <?=number_format($subTotalWithOutDiscount-$subtotal,2)?> zł.</h6>
            <?php endif; ?>
            <div class="cart_buttons ">
                <button class="btn btn-danger" type="submit" name="order">Złóż zamówienie</button>
                <button class="btn btn-danger" type="submit" name="update">Aktualizuj koszyk</button>
            <?php if($subTotalWithOutDiscount-$subtotal==0):?>  
                <hr>
                <input type="text" placeholder="Kod rabatowy" name="discode" style="margin-top: 20px" class="discount">
                <button class="btn btn-danger" type="submit" name="discount">Aktywuj rabat</button>
            <?php endif; ?>    
            </div>
        </div>
    </div>
    </form>
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
<?php 
mysqli_close($connection);
?>
</body>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js"></script>
<script src="assets/js/script.min.js"></script>
</html>
