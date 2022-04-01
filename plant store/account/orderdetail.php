<!DOCTYPE html>
<?php
session_start();
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
<?php include("header.php"); ?>
<div class="container" style="margin-bottom: 30px">
<div class="row">
    <div class="col col-md-12">
    <?php

include("../db_connection.php");

//Authorize
if (!isset($_SESSION['id'])) {
    header('location: ../notfound.php');
    exit;
}
//
//Get order informaction
$id_order=$_REQUEST['id_order'];
$id_user=$_SESSION['id'];

$order_result=mysqli_query($connection,"SELECT * FROM orders WHERE id_order='$id_order' AND id_user='$id_user'")or die ("Blad zapytania select");
if($order_result!= null){
    $order_row = mysqli_fetch_row($order_result);
    $order_status = $order_row[9];
    $order_date = $order_row[8];
    $order_phonenumber = $order_row[7];
    $order_totalprice = $order_row[6];
    $order_surname = $order_row[5];
    $order_firstname = $order_row[4];
    $id_user = $order_row[3];
    $id_payment = $order_row[2];
    $id_address = $order_row[1];
}
$user_result=mysqli_query($connection,"SELECT nickname,email,phone_number FROM users WHERE id_user='$id_user'")or die ("Blad zapytania select");
if($order_result!= null){
    $user_row = mysqli_fetch_row($user_result);
    $user_nickname = $user_row[0];
    $user_email = $user_row[1];
    $user_phonenumber = $user_row[2];
}
$payment_result=mysqli_query($connection,"SELECT method_name FROM payments WHERE id_payment='$id_payment'")or die ("Blad zapytania select");
if($payment_result!= null){
    $payment_row = mysqli_fetch_row($payment_result);
    $payment_methodname = $payment_row[0];
}
$address_result=mysqli_query($connection,"SELECT address,city,zip_code,country FROM address WHERE id_address='$id_address'")or die ("Blad zapytania select");
if($address_result!= null){
    $address_row = mysqli_fetch_row($address_result);
    $address_name = $address_row[0];
    $address_city = $address_row[1];
    $address_zipcode = $address_row[2];
    $address_country = $address_row[3];
}
?>
<ul class="list-group">
<li class="list-group-item"><h4>Numer zamówienia: <?=$id_order?></h4></li>
<?php
if($order_status=="placed"){
    $status_message = "Złożone";
}else{
    $status_message = "Wysłane";
}
?>
<li class="list-group-item"><h4>Status zamówienia: <?=$status_message?></h4></li>
<li class="list-group-item"><h4>Data złożenia zamówienia: <?=$order_date?></h4></li>
<li class="list-group-item"><h4>Uzytkownik: </h4>
    Nazwa użytkownika: <?=$user_nickname?><br>
    Email: <?=$user_email?><br>
    Numer telefonu: <?=$user_phonenumber?></li>
<li class="list-group-item"><h4>Dane klienta:</h4>
    Imie: <?=$order_firstname?><br>
    Nazwisko: <?=$order_surname?><br>
    Numer telefonu: <?=$order_phonenumber?></li>
<li class="list-group-item"><h4>Metoda płatności:<?=$payment_methodname?></h4>   </li>
<li class="list-group-item"><h4>Dane do wysyłki:</h4>
    Adres: <?=$address_name?><br>
    Miasto: <?=$address_city?><br>
    Kod pocztowy: <?=$address_zipcode?><br>
    Państwo: <?=$address_country?></li>
<li class="list-group-item">
    <h4>Cena łącznie: <?=number_format($order_totalprice,2)?> zł.</h4> </li>
</ul>
    </div>
    <div class="col col-md-12">
    <br>
<h3>Szczegóły zamówienia:</h3>
<br>
<table class="table  table-striped">
    <thead class="">
        <tr>
            <th>Nazwa produktu</th>
            <th></th>
            <th>Cena</th>
            <th>Ilość</th>
            <th>Cena łącznie</th>
        </tr>
    </thead>
        <tbody>
            <?php
            $order_items_result=mysqli_query($connection,"SELECT id_product,price,quantity FROM order_item WHERE id_order='$id_order'")or die ("Blad zapytania select1");

            while(list($id_product,$price,$quantity)=mysqli_fetch_array($order_items_result)): 
                $order_item_result=mysqli_query($connection,"SELECT id_product,name,description,price,img,id_category FROM products WHERE id_product='$id_product'")or die ("Blad zapytania select2");
                $order_item_row = mysqli_fetch_row($order_item_result);
                $product_name = $order_item_row[1];
                $description = $order_item_row[2];
                $price = $order_item_row[3];
                $img = $order_item_row[4];
                $id_category = $order_item_row[5];
            ?>
            <tr><td>
            <img src="data:image/jpeg;base64,<?=base64_encode($img )?>" height="100" width="100"/>
            </td>
            <td><a href="../product.php?id=<?=$id_product?>"><?=$product_name?></a></td><td><?=number_format($price,2)?> zł.</td><td><?=$quantity?></td><td><?=(int)($price*$quantity)?> zł.</td>
            </tr>
            <?php
            endwhile;
            mysqli_close($connection);
            ?>
        </tbody>
</table>
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