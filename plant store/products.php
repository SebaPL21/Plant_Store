<!DOCTYPE html>
<?php
session_start();
include("db_connection.php");

//Pagination
$results_per_page = 9;

if (isset($_GET['category'])) {
    $categoryId = $_GET['category'];
    $sql = 'SELECT * FROM products WHERE id_category='. $categoryId;
    $result=mysqli_query($connection,$sql)or die ("Blad zapytania select");
}else{
    $result=mysqli_query($connection,"select * from products")or die ("Blad zapytania select");
}


$number_of_results = mysqli_num_rows($result);
$number_of_pages = ceil($number_of_results/$results_per_page);

if (!isset($_GET['page'])) {
  $page = 1;
} else {
  $page = $_GET['page'];
}
//
if (isset($_GET['sortby'])) {
    $sortby = $_GET['sortby'];
    if ($sortby == 'priceD') {
        $sortOrder = "price DESC";
    }
    elseif ($sortby == 'priceA') {
        $sortOrder = "price ASC";
    }
    elseif ($sortby == 'name') {
        $sortOrder = "name";
    }
}else{
    $sortOrder = "name ASC";
}
?>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <title>PlantStore - Produkty</title>
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
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
    
    
</head>

<body>
    <?php include("header.php"); ?>

    <div class="container" style="margin-bottom:60px">
		<h2 class="text-center" style="margin-top: 30px">Wszystkie Produkty</h2>
		<p class="text-center">PlantStore > Sklep</p>
		<div class="container">
			<div class="row ">

				<div class="col-md-10">
					<!-- Sortowanie po kategoriach-->
					Kategorie:&nbsp;&nbsp;
					<a style="font-weight:bold" href="products.php?page=<?=$page?>">Wszystkie</a>&nbsp;&nbsp;&nbsp;
					<?php
					$result=mysqli_query($connection,"SELECT id_category,name FROM categories")or die ("Blad zapytania select");
					while(list($id_category,$name)=mysqli_fetch_array($result)):?>
						<a style="font-weight:bold" href="products.php?page=<?=$page?>&category=<?=$id_category?>"><?=$name?></a>&nbsp;&nbsp;&nbsp;
					<?php endwhile; ?>
				</div>

				<div class="col-md-2">
					<div class="dropdown show">
						<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Sortowanie
						</button>

						<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
						<!-- Sortowanie-->
							<a class="dropdown-item" href="products.php?page=<?=$page?>&sortby=priceD">Cena Malejąco</a>
							<a class="dropdown-item" href="products.php?page=<?=$page?>&sortby=priceA">Cena Rosnąco</a>
							<a class="dropdown-item" href="products.php?page=<?=$page?>&sortby=name">Nazwa</a>
						</div>
					</div>
				</div>
			</div>
		</div>
			<?php 
				$this_page_first_result = ($page-1)*$results_per_page;

				if (isset($_GET['category'])) {
					$categoryId = $_GET['category'];
					$sql='SELECT id_product,name,description,price,img,id_category FROM products WHERE id_category='. $categoryId .' ORDER BY ' . $sortOrder . ' LIMIT ' . $this_page_first_result . ',' .  $results_per_page;
				}else{
					$sql='SELECT id_product,name,description,price,img,id_category FROM products ORDER BY ' . $sortOrder . ' LIMIT ' . $this_page_first_result . ',' .  $results_per_page;
				}
			?>
		<hr>

		<div class="row">
			<?php
				if(isset($_GET['option'])){
					$option = $_GET['option'];
					if($option == '1'){
						$sql = 'SELECT * FROM PRODUCTS WHERE difficulty_of_growing<3 AND difficulty_of_growing >0';
					}
					if($option == '2'){
						$sql = 'SELECT * FROM PRODUCTS WHERE insolation >3';
					}
					if($option == '3'){
						$sql = 'SELECT * FROM PRODUCTS WHERE watering_frequency >3 AND difficulty_of_growing >3';
					}
					$result=mysqli_query($connection,$sql)or die ("Blad zapytania select");
					$number_of_results = mysqli_num_rows($result);
					$number_of_pages = ceil($number_of_results/$results_per_page);
				}


			$result = mysqli_query($connection, $sql);
			while(list($id_product,$product_name,$description,$price,$img,$id_category)=mysqli_fetch_array($result)):
			?>
			<div class="col-md-4 product-grid">
				<div class="image">
					<a href="product.php?id=<?=$id_product?>">
						<img src="data:image/jpeg;base64,<?=base64_encode($img )?>" class="w-100"/>
						<div class="overlay">
							<div class="detail">Zobacz szczegóły</div>
						</div>
					</a>
				</div>
				<h5 class="text-center"><?=$product_name?></h5>
				<h5 class="text-center">Cena: <?=number_format($price,2)?> zł.</h5>
			</div>
			<?php
				endwhile;
				mysqli_close($connection);
			?>
		</div>
	<?php 
	if (isset($_GET['sortby'])) {
		$sortby = $_GET['sortby'];

		if (isset($_GET['category'])) {
			$categoryId = $_GET['category'];
			
			for ($page=1;$page<=$number_of_pages;$page++) {
			echo '<a class="btn btn-light" href="products.php?page=' . $page . '&sortby='. $sortby .'&category='. $categoryId .'">' . $page . '</a> ';     
			}
		}
		else{
			for ($page=1;$page<=$number_of_pages;$page++) {
			echo '<a class="btn btn-light" href="products.php?page=' . $page . '&sortby='. $sortby .'">' . $page . '</a> ';     
			}
		}
	}else{
		if (isset($_GET['category'])) {
			$categoryId = $_GET['category'];
			
			for ($page=1;$page<=$number_of_pages;$page++) {
			echo '<a class="btn btn-light" href="products.php?page=' . $page . '&category='. $categoryId .'">' . $page . '</a> ';     
			}
			}
		else if (isset($_GET['option'])) {
			$option = $_GET['option'];	
			for ($page=1;$page<=$number_of_pages;$page++) {
			echo '<a class="btn btn-light" href="products.php?page=' . $page . '&option='. $option .'">' . $page . '</a> ';     
			}
			}
		else{
			for ($page=1;$page<=$number_of_pages;$page++) {
				echo '<a class="btn btn-light" href="products.php?page=' . $page . '">' . $page . '</a> ';     
				}
		}
		}
	?>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js"></script>
    <script src="assets/js/script.min.js"></script>
</body>
</html>