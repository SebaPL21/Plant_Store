<!DOCTYPE html>
<?php
session_start();
include("../db_connection.php");

//Authorize
if (!isset($_SESSION['id'])) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}else{
    $sql = "SELECT role FROM users WHERE id_user='$_SESSION[id]'";
    $query = mysqli_query($connection,$sql);
    $row=mysqli_fetch_array($query);
    if($row["role"]==""){
        header('HTTP/1.0 403 Forbidden');
        exit;
    }
}
//
//GET
$sql_select_quantity_of_users = "SELECT COUNT(id_user) FROM users";
$result_select_quantity_of_users = mysqli_query($connection,$sql_select_quantity_of_users);

$sql_select_quantity_of_placed_orders = "SELECT COUNT(id_order) FROM orders WHERE status='placed'";
$result_select_quantity_of_placed_orders = mysqli_query($connection,$sql_select_quantity_of_placed_orders);

$sql_select_quantity_of_realized_orders = "SELECT COUNT(id_order) FROM orders WHERE status='Realized'";
$result_select_quantity_of_realized_orders = mysqli_query($connection,$sql_select_quantity_of_realized_orders);

$sql_select_quantity_of_products = "SELECT COUNT(id_product) FROM products";
$result_select_quantity_of_products = mysqli_query($connection,$sql_select_quantity_of_products);
?>
<html lang="pl">
<head><meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>PlantStore</title>
  <link rel="stylesheet" href="../assets_admin/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400|Roboto:300,400,700">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400|Roboto:300,400,700">
  <link rel="stylesheet" href="../assets_admin/fonts/font-awesome.min.css">
  <link rel="stylesheet" href="../assets_admin/css/styles.min.css">
  <link rel="stylesheet" href="../assets_admin/bootstrap/css/adminstyle.css">
  <link rel="stylesheet" href="../assets_admin/bootstrap/css/adminstyle.css">
 
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-success " >
    <a class="navbar-brand" href="#">PlantStore</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Strona Główna <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="orders.php">Zamówienia</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="users.php">Użytkownicy</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="products.php">Produkty</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="payments.php">Płatności</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="category.php">Kategorie</a>
        </li>
      </ul>
    </div>
    <ul class="navbar-nav navbar-right">
     
      <li class="nav-item">
        <a class="nav-link" href="#">Witaj <?=$_SESSION["username"]?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../logout.php">Wyloguj</a>
      </li>
    </ul>
  </nav>
  
  <header id="header">
    <div class="container">
      <div class="row">
        <div class="col-md-10">
          <h1><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
            <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
          </svg>Panel Administratora  <small> - Zarządzaj swoim sklepem online</small></h1>
        </div>
      
      
    </div>
  </header>
  <!-- Left navbar -->
  <section id="main">
   <div class="container-fluid">
<div class="row">
  <div class="col-md-3">
 <div class="list-group">
 
    <a href="index.php" class="list-group-item list-group-item-action active main color bg-success" aria-current="true">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>Strona Główna
    </a>
    <a href="orders.php" class="list-group-item list-group-item-action"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>Zamówienia</a>
    <a href="users.php" class="list-group-item list-group-item-action"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>Użytkownicy</a>
    <a href="products.php" class="list-group-item list-group-item-action"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>Produkty</a>
    <a href="payments.php" class="list-group-item list-group-item-action "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cash" viewBox="0 0 16 16">
      <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
      <path d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2H3z"/>
    </svg>Płatności</a>
    <a href="categories.php" class="list-group-item list-group-item-action"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-card-list" viewBox="0 0 16 16">
      <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
      <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
    </svg>Kategorie</a>
    


    </div>
  </div>
  <div class="col-md-9">
  <div class="card">
    <div class="card-header color bg-success">
      Przegląd Strony
    </div>
    <div class="row">
      <div class="col-sm-3">
        <div class="card">
        <?php
        $row = mysqli_fetch_row($result_select_quantity_of_users);
        ?>
          <div class="card-body">
            <h5 class="card-title">Użytkownicy</h5>
            <h5 class="card-text"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            <?=$row[0]?></h5>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="card">
        <?php
        $row = mysqli_fetch_row($result_select_quantity_of_realized_orders);
        ?>
          <div class="card-body">
            <h5 class="card-title">Zamówienia Zrealizowane</h5>
            <h5 class="card-text"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
              <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
              <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z"/>
            </svg> <?=$row[0]?></h5>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="card">
        <?php
        $row = mysqli_fetch_row($result_select_quantity_of_placed_orders);
        ?>
          <div class="card-body">
            <h5 class="card-title">Zamówienia w trakcie</h5>
            <h5 class="card-text"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
              <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
            </svg> <?=$row[0]?></h5>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="card">
        <?php
        $row = mysqli_fetch_row($result_select_quantity_of_products);
        ?>
          <div class="card-body">
            <h5 class="card-title">Liczba dostępnych produktów</h5>
            <h5 class="card-text"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg> 
            <?=$row[0]?></h5>
          </div>
        </div>
      </div>
     

    </div>
    </div>
  </div>
  </div>
 </div>
</div>

        </section>
    
   <script src="assets/js/jquery.min.js">
  </script>
  <script src="assets/bootstrap/js/bootstrap.min.js">
  </script></body></html>