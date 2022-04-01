<!DOCTYPE html>
<?php
include("db_connection.php");

$sql='SELECT id_product,name,price,img FROM products WHERE id_category=11 LIMIT 3';
$sql2='SELECT id_product,name,price,img FROM products WHERE id_category=11 LIMIT 3,6';
?>
<html>
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid" style="margin-bottom:80px">
	<div class="row">
		<div class="col-sm-12">
			<div id="inam" class="carousel slide" data-ride="carousel" data-interval="15000">
				<div class="carousel-inner">
					<div class="carousel-item active">
						 <div class="container">
						 	<div class="row">
                                <?php
                                $result = mysqli_query($connection, $sql);
                                while(list($id_product,$product_name,$price,$img)=mysqli_fetch_array($result)):
                                ?>
						 		<div class="col-sm-12 col-lg-4">
                                    <a href="product.php?id=<?=$id_product?>" style="text-decoration:none; color:black">
						 			<div class="card" style="width: 300px;margin: auto;">
						 				<img src="data:image/jpeg;base64,<?=base64_encode($img )?>" class="card-img-top" height="250" width="200"/>
						 				<div class="card-body">
						 					<h4 class="card-title"><?=$product_name?></h4>
						 					<p class="card-text"><?=number_format($price,2)?> zł.</p>

						 				</div>
						 				
						 			</div>
						 			</a>
						 		</div>
                                <?php
                                endwhile;
                                ?>
						 		
						 	</div>
						 	
						 </div>

						
					</div>
					<div class="carousel-item">
						 <div class="container">
						 	<div class="row">
                             <?php
                            $result = mysqli_query($connection, $sql2);
                            while(list($id_product,$product_name,$price,$img)=mysqli_fetch_array($result)):
                                ?>
						 		<div class="col-sm-12 col-lg-4">
                                    <a href="product.php?id=<?=$id_product?>" style="text-decoration:none; color:black">
						 			<div class="card" style="width: 300px;margin: auto;">
						 				<img src="data:image/jpeg;base64,<?=base64_encode($img )?>" class="card-img-top" height="250" width="200"/>
						 				<div class="card-body">
						 					<h4 class="card-title"><?=$product_name?></h4>
						 					<p class="card-text"><?=$price?> zł.</p>

						 				</div>
						 				
						 			</div>
						 		</div>
                                 </a>
                            <?php
                            endwhile;
                            mysqli_close($connection);
                            ?>
						 		
						 	</div>
						 	
						 </div>

						
					</div>
					
				</div>

				
			</div>
			
		</div>
		
	</div>
	
</div>
</body>
</html>