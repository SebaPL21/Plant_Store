<!DOCTYPE html>
<?php
session_start();
include("db_connection.php");
 
$username = $password = $confirm_password = $email = $phone_number = $address = $city = $zip_code = $country = $id_address = "";
$username_err = $password_err = $confirm_password_err = $email_err = $phone_number_err = $address_err = $city_err = $zip_code_err = $country_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["username"]))){
        $username_err = "Proszę podać nazwę użytkownika.";
    } else{
        $sql = "SELECT id_user FROM users WHERE nickname = ?";
        
        if($stmt = mysqli_prepare($connection, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = trim($_POST["username"]);

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Nazwa użytkownika jest już używana";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Error - Register";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Proszę podać hasło.";     
    } elseif(strlen(trim($_POST["password"])) < 5){
        $password_err = "Hasło musi mieć wiecej niż 5 znaków.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Proszę potwierdzić hasło.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Hasła nie pasują";
        }
    }

    if(empty(trim($_POST["email"]))){
        $email_err = "Proszę podać adres mailowy.";     
    } else{
        $email = trim($_POST["email"]);
    }

    if(empty(trim($_POST["phone_number"]))){
        $phone_number_err = "Proszę podać numer telefonu.";     
    } else{
        $phone_number = trim($_POST["phone_number"]);
    }

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
    
    if(empty($username_err) 
    && empty($password_err) 
    && empty($confirm_password_err) 
    && empty($email_err) 
    && empty($phone_number_err) 
    && empty($address_err) 
    && empty($city_err)
    && empty($zip_code_err)
    && empty($country_err)){
        
        $sqlAddress = 'INSERT INTO address (address, city, zip_code, country) VALUES (?, ?, ?, ?)';
        $sqlUser = "INSERT INTO users (nickname, password, role, status, email, phone_number, id_address) VALUES (?, ?, ?, ?, ?, ?, ?)";

        
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
        

        if($stmt2 = mysqli_prepare($connection, $sqlUser)){
            mysqli_stmt_bind_param($stmt2, "sssssii", $param_username, $param_password, $param_role, $param_status, $param_email, $param_phone_number, $param_id_address);
            
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); 
            $param_role = "";
            $param_status = "0";
            $param_email = $email;
            $param_phone_number = $phone_number;
            $param_id_address = $id_address;
            
            if(mysqli_stmt_execute($stmt2)){
                header("location: emailconfirmation.php");
            } else{
                echo "Error - Register-Final";
            }
            mysqli_stmt_close($stmt2);
        }
    }
    
    mysqli_close($connection);
}
?>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>PlantStore - Rejestracja</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400|Roboto:300,400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400|Roboto:300,400,700">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/css/swiper.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
</head>
<body>
    <?php include("header.php"); ?>
    <div class="container" style="padding-top:30px">
        <div class="login-clean">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2 class=" sr-only ">Rejestracja</h2>
            <div class=" illustration "><i class=" icon fa fa-user " style=" color: rgb(227,19,19); "></i></div>
            <h2 class=" sr-only ">Rejestracja</h2>
            <div class="form-group">
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="Nazwa użytkownika" maxlength="49">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" placeholder=" Email" maxlength="49">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div> 
            <div class="form-group">
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" placeholder="Hasło" maxlength="254">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>" placeholder="Potwierdz hasło" maxlength="254">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="text" name="phone_number" maxlength="9" onkeypress="return isNumber(event)" id="extra7" class="form-control textfield <?php echo (!empty($phone_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone_number; ?>" placeholder="Numer telefonu">
                <span class="invalid-feedback"><?php echo $phone_number_err; ?></span>
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
            </div> 
            <div class="form-group">
                <input type="text" name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $address; ?>" placeholder="Adres" maxlength="99">
                <span class="invalid-feedback"><?php echo $address_err; ?></span>
            </div> 
            <div class="form-group">
                <input type="text" id="zip_code" maxlength="5" onkeypress="return isNumber(event)" id="extra7"  name="zip_code" class="form-control <?php echo (!empty($zip_code_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $zip_code; ?>" placeholder="Kod pocztowy">
                <span class="invalid-feedback"><?php echo $zip_code_err; ?></span>
            </div> 
            <div class="form-group">
                <input type="text" name="city" class="form-control <?php echo (!empty($city_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $city; ?>" placeholder="Miasto" maxlength="99">
                <span class="invalid-feedback"><?php echo $city_err; ?></span>
            </div> 
            <div class="form-group">
                <input type="text" name="country" class="form-control <?php echo (!empty($country_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $country; ?>" placeholder="Państwo" maxlength="49">
                <span class="invalid-feedback"><?php echo $country_err; ?></span>
            </div> 
            <div class="form-group">
                <div class=" form-group "><button class=" btn btn-primary btn-block " type=" submit "
                    style=" background: rgb(227,19,19); ">Zarejestruj</button>
            </div>
            </div>
            <a class="forgot" href="login.php">Masz konto? Zaloguj się tutaj.</a>

        </form>
        </div>
    </div>
    <br>
    <div class=" footer ">
        <div class=" container ">
            <div class=" row ">
                <div class=" col-8 col-sm-6 col-md-6 ">
                    <p class=" text-left ">© 2021 PlantStore</p>
                </div>
                <div class="col-12 col-sm-6 col-md-6">
                    <p class="text-right">Kontakt:&nbsp;&nbsp;<i class="fa fa-facebook"></i>&nbsp; &nbsp;<i class="fab fa-discord"></i> &nbsp; &nbsp;&nbsp;
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script src=" assets/js/jquery.min.js "></script>
    <script src=" assets/bootstrap/js/bootstrap.min.js "></script>
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js "></script>
    <script src=" assets/js/script.min.js "></script>
</body>

</html>