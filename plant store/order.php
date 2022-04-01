<!DOCTYPE html>
<?php
session_start();
include("db_connection.php");

//Authorize
if (!isset($_SESSION['id'])) {
    header("location: login.php");
    exit;
}
//GetPaymentListToSelect
$paymentList = mysqli_query($connection, "SELECT * FROM `payments`") or die ("blad zapytania select");
//Discount
if(isset($_COOKIE["discount"])){
     $discount = $_COOKIE["discount"];
} else{
    $discount = 1.0;
}
//TotalPrice
function GetTotalPrice(){
    include("db_connection.php");
    $products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
    $subtotal = 0.00;
    if ($products_in_cart) {
        $ids = array_keys($products_in_cart);
        $sql = 'SELECT * FROM products WHERE id_product IN (' . implode(',', array_map('intval', $ids)) . ')';
        $result=mysqli_query($connection,$sql)or die ("Blad zapytania select");

        while($row = mysqli_fetch_array($result))
        {
            $subtotal += (float)$row['price'] * (int)$products_in_cart[$row['id_product']];
        }
    }
    return  $_SESSION['discount'] * $subtotal;
}

$first_name = $sur_name = $phone_number = $address = $city = $zip_code = $country = $id_address = $id_payment = "";
$first_name_err = $sur_name_err = $phone_number_err = $address_err = $city_err = $zip_code_err = $country_err = $id_payment_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["first_name"]))){
        $first_name_err = "Proszę podać imię.";     
    } else{
        $first_name = trim($_POST["first_name"]);
    }

    if(empty(trim($_POST["sur_name"]))){
        $sur_name_err = "Proszę podać nazwisko.";     
    } else{
        $sur_name = trim($_POST["sur_name"]);
    }

    if(empty(trim($_POST["phone_number"]))){
        $phone_number_err = "Proszę podać numer telefonu.";     
    } else{
        $phone_number = trim($_POST["phone_number"]);
    }
    if(empty(trim($_POST["payment_method"]))){
        $id_payment_err = "Proszę wybrać metode płatności.";     
    } else{
        $id_payment = trim($_POST["payment_method"]);
    }
    if(!isset($_POST["user_address_check_box"])){

        if(empty(trim($_POST["address"]))){
            $address_err = "Proszę podać adres.";     
        } else{
            $address = trim($_POST["address"]);
        }

        if(empty(trim($_POST["city"]))){
            $city_err = "Proszę podać miasto.";     
        } else{
            $city = trim($_POST["city"]);
        }

        if(empty(trim($_POST["zip_code"]))){
            $zip_code_err = "Proszę podać kod pocztowy.";     
        } else{
            $zip_code = trim($_POST["zip_code"]);
        }

        if(empty(trim($_POST["country"]))){
            $country_err = "Proszę podać państwo.";     
        } else{
            $country = trim($_POST["country"]);
        }
    }
    
    if(empty($first_name_err) 
    && empty($sur_name_err) 
    && empty($phone_number_err) 
    && empty($address_err) 
    && empty($city_err)
    && empty($zip_code_err)
    && empty($country_err)){
        
        $sqlAddress = 'INSERT INTO address (address, city, zip_code, country) VALUES (?, ?, ?, ?)';

        if(isset($_POST["user_address_check_box"])){
            $sqlUser = "SELECT id_address FROM users WHERE id_user='$_SESSION[id]'";
            $query = mysqli_query($connection,$sqlUser);
            $row=mysqli_fetch_array($query);
            $id_address = $row[0];
        }
        else{
            $resultCheckAddress = mysqli_query($connection,"SELECT id_address FROM address WHERE (address = '$address' AND city = '$city' AND zip_code = '$zip_code' AND country = '$country') LIMIT 1");
            
            $row = mysqli_fetch_row($resultCheckAddress);
            
            if ($row[0]==null) {
                if($stmt = mysqli_prepare($connection, $sqlAddress)){
                mysqli_stmt_bind_param($stmt, "ssss", $param_address, $param_city, $param_zip_code, $param_country);
                
                $param_address = $address;
                $param_city = $city;
                $param_zip_code = $zip_code;
                $param_country = $country;
                
                if(mysqli_stmt_execute($stmt)){
                } else{
                    echo "Error - Register2";
                }
                mysqli_stmt_close($stmt);
                }
            }else{
                $id_address = $row[0];
            }

            if($id_address == ""){
                $id_address = mysqli_insert_id($connection);
            }
        }

        $sqlOrder = "INSERT INTO orders (first_name, sur_name, phone_number, total_price, id_address, id_payment, id_user) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        if($stmt2 = mysqli_prepare($connection, $sqlOrder)){
            mysqli_stmt_bind_param($stmt2, "ssidiii", $param_first_name, $param_sur_name, $param_phone_number, $param_total_price, $param_id_address, $param_id_payment, $param_id_user);
            
            $param_first_name = $first_name;
            $param_sur_name = $sur_name;
            $param_phone_number = $phone_number;
            $param_total_price = GetTotalPrice();
            $param_id_address = $id_address;
            $param_id_payment = $id_payment;
            $param_id_user = $_SESSION['id'];
            
            if(mysqli_stmt_execute($stmt2)){
            } else{
                echo "Error - Order";
            }
            mysqli_stmt_close($stmt2);
        }
        $id_order = mysqli_insert_id($connection);

        $products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
        if ($products_in_cart) {
            $ids = array_keys($products_in_cart);
            $sql = 'SELECT * FROM products WHERE id_product IN (' . implode(',', array_map('intval', $ids)) . ')';
            $result=mysqli_query($connection,$sql)or die ("Blad zapytania select");

            while($row = mysqli_fetch_array($result))
            {
                $sqlOrderItem = "INSERT INTO order_item (quantity, price, id_product, id_order) VALUES (?, ?, ?, ?)";
                if($stmt3 = mysqli_prepare($connection, $sqlOrderItem)){
                    mysqli_stmt_bind_param($stmt3, "idii", $param_quantity, $param_price, $param_id_product, $param_id_order);
                    
                    $param_quantity = (int)$products_in_cart[$row['id_product']];
                    $param_price = (float)$row['price'];
                    $param_id_product = (int)$row['id_product'];
                    $param_id_order = $id_order;
                    
                    if(mysqli_stmt_execute($stmt3)){
                    } else{
                        echo "Error - OrderItem";
                    }
                    mysqli_stmt_close($stmt3);
                }
            }
            header("location: orderconfirmation.php");
        }
    }
}
    mysqli_close($connection);
?>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Zamówienia</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Berkshire+Swash|Kaushan+Script">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400|Roboto:300,400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400|Roboto:300,400,700">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <script>
    function changeReadonlyFields() {
    var checkBox = document.getElementById("user_address_check_box");
        if (checkBox.checked == true){
            document.getElementById('address').readOnly = true;
            document.getElementById('zip_code').readOnly = true;
            document.getElementById('city').readOnly = true;
            document.getElementById('country').readOnly = true;
        } else {
            document.getElementById('address').readOnly = false;
            document.getElementById('zip_code').readOnly = false;
            document.getElementById('city').readOnly = false;
            document.getElementById('country').readOnly = false;
        }
    }
    function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
    }
    </script>
</head>

<body>
    <?php include("header.php"); ?>
    <div class="container">
        <div class="login-clean">
            <h2>Zamówienie</h2>
        <p>Proszę uzupełnić formularz składania zamówienia.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <input type="text" name="first_name" class="form-control <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>" placeholder="Imię" maxlength="49">
                <span class="invalid-feedback"><?php echo $first_name_err; ?></span>
            </div>    
            <div class="form-group">
                <input type="text" name="sur_name" class="form-control <?php echo (!empty($sur_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $sur_name; ?>"placeholder="Nazwisko" maxlength="49">
                <span class="invalid-feedback"><?php echo $sur_name_err; ?></span>
            </div> 
            <div class="form-group">
                <input type="text" name="phone_number" maxlength="9" onkeypress="return isNumber(event)" class="form-control <?php echo (!empty($phone_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone_number; ?>" placeholder="Numer telefonu">
                <span class="invalid-feedback"><?php echo $phone_number_err; ?></span>
            </div> 
            <div class="form-group">
            <label>Metoda płatności</label>
            <select name="payment_method" class="form-control <?php echo (!empty($id_payment_err)) ? 'is-invalid' : ''; ?>">

                <?php while($row = mysqli_fetch_array($paymentList)):; ?>

                <option value="<?php echo $row[0]; ?>"><?php echo $row[1];?></option>

                <?php endwhile;?>

            </select>
            <span class="invalid-feedback"><?php echo $id_payment_err; ?></span>
            </div> 
            <h3 style="margin-top:30px;">Adres do wysyłki</h3>
            <label style="margin-top:15px;"><input type="checkbox" id="user_address_check_box" name="user_address_check_box" onclick="changeReadonlyFields()">Użyj takiego samego jak podczas rejestracji</label>

            <div class="form-group">
                <input type="text" id="address" name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $address; ?>" placeholder="Adres" maxlength="99">
                <span class="invalid-feedback"><?php echo $address_err; ?></span>
            </div> 
            <div class="form-group">
                <input type="text" id="zip_code" maxlength="5" name="zip_code" onkeypress="return isNumber(event)" id="extra7" class="form-control <?php echo (!empty($zip_code_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $zip_code; ?>" placeholder="Kod pocztowy">
                <span class="invalid-feedback"><?php echo $zip_code_err; ?></span>
            </div> 
            <div class="form-group">
                <input type="text" id="city" name="city" class="form-control <?php echo (!empty($city_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $city; ?>" placeholder="Miasto" maxlength="99">
                <span class="invalid-feedback"><?php echo $city_err; ?></span>
            </div> 
            <div class="form-group">
                <input type="text" id="country" name="country" class="form-control <?php echo (!empty($country_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $country; ?>" placeholder="Państwo" maxlength="49">
                <span class="invalid-feedback"><?php echo $country_err; ?></span>
            </div> 
            <div class="form-group">
                    <button type="submit" class="btn btn-danger" style=" width: 100%;">Złóż zamówienie</button>
                </div>
        </form>
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
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script>
                function isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
                }
                </script>
</body>

</html>