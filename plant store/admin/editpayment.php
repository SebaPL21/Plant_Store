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

$id_payment=$_REQUEST['id_payment'];

$result=mysqli_query($connection,"select id_payment,method_name from payments where id_payment='$id_payment'")or die ("Zapytanie select niepoprawne");

list($id_payment,$method_name)=mysqli_fetch_array($result);

if($method_name == ""){
    header('location: notfound.php');
}

if(isset($_POST['btn_save'])) 
{

$method_name=$_POST['method_name'];

mysqli_query($connection,"UPDATE payments SET method_name='$method_name' WHERE id_payment='$id_payment'")or die("Zapytanie Update niepoprawne");


header("location: payments.php");
mysqli_close($connection);
}
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

 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

<script
src="http://code.jquery.com/jquery-3.3.1.min.js"
integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" ></script>
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
          <a class="nav-link" href="index.php">Strona G????wna <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="orders.php">Zam??wienia</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="users.php">U??ytkownicy</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="products.php">Produkty</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="payments.php">P??atno??ci</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="categoires.php">Kategorie</a>
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
          </svg>Panel Administratora  <small> - Edycja Metody P??atno??ci</small></h1>
        </div>
       
      </div>
    </div>
  </header>
  <!-- Left navbar -->
  

  <section id="main">
   <div class="container-fluid">
<div class="row">
  <div class="col-md-3">
 <div class="list-group">
 
    <a href="index.php" class="list-group-item list-group-item-action" >
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>Strona G????wna
    </a>
    <a href="orders.php" class="list-group-item list-group-item-action"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>Zam??wienia</a>
    <a href="users.php" class="list-group-item list-group-item-action " aria-current="true"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>U??ytkownicy</a>
    <a href="products.php" class="list-group-item list-group-item-action "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>Produkty</a>
    <a href="payments.php" class="list-group-item list-group-item-action active main color bg-success"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cash" viewBox="0 0 16 16">
      <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
      <path d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2H3z"/>
    </svg>P??atno??ci</a>
    <a href="categories.php" class="list-group-item list-group-item-action"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-card-list" viewBox="0 0 16 16">
      <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
      <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
    </svg>Kategorie</a>
    </div>
  </div>
  <!-- Kart-->
  <div class="col-md-9">
  <div class="card">
    <div class="card-header color bg-success ">     
      <h2>Edytuj</h2>
    </div>
    <div class="row">
      <div class="col-sm-12">
       
        <div class="card">
          <div class="card-body">        
            <form action="" method="post" name="form">
            <table class="table">
<thead>
</thead>
<tbody>
<tr>
            <td><label>Nazwa metody platnosci</label></td>
            <td> <input type="text" id="method_name" name="method_name" value="<?=$method_name?>" required maxlength="49"></br></td>
            </tr>
            <tr>
            
            <td> <button type="submit" name="btn_save" id="btn_save">Aktualizuj metod?? platno??ci</button></td>
            </tr>
            </tbody>
            </table>
            </form>
    </div>
    <script>
      $(document).ready( function () {
      $('#myTable').DataTable();
  } );
      </script>
    </div>
  </div>
  </div>
 </div>
</div>

        </section>
  
  </script></body></html>