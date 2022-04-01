<!DOCTYPE html>
<?php
session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
include("db_connection.php");
 
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["username"]))){
        $username_err = "Proszę wprowadz nazwę użytkownika";
    } else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Proszę wprowadz hasło";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id_user, nickname, password FROM users WHERE nickname = ?";
        
        if($stmt = mysqli_prepare($connection, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = $username;

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            header("location: index.php");
                        } else{
                            $login_err = "Niepoprawna nazwa użytkownika lub hasło.";
                        }
                    }
                } else{
                    $login_err = "Niepoprawna nazwa użytkownika lub hasło.";
                }
            } else{
                echo "Error - Login";
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($connection);
}
?>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <title>PlantStore - Logowanie</title>
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
        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="illustration">
                    <i class="icon ion-log-in" style="color: rgb(227,19,19);">
                    </i>
                </div>
            <div class="form-group">
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="Nazwa użytkownika">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Hasło">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">Zaloguj się</button>
            </div>
            <a class="forgot" href="register.php">Nie masz jeszcze konta? Stwórz je.</a>
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

</body>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js"></script>
<script src="assets/js/script.min.js"></script>

</html>