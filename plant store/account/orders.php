<?php
//session_start();
include("../db_connection.php");

//Authorize
if (!isset($_SESSION['id'])) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}
//
//Pagination
$results_per_page = 5;
$result=mysqli_query($connection,'SELECT id_order,id_user,phone_number FROM orders WHERE id_user='. $_SESSION['id']) or die ("Blad zapytania select");

$number_of_results = mysqli_num_rows($result);
$number_of_pages = ceil($number_of_results/$results_per_page);

if (!isset($_GET['page'])) {
  $page = 1;
} else {
  $page = $_GET['page'];
}
//
?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nr. </th>
            <th>Data złożenia </th>
            <th>Status </th>
            <th>Wartość </th>
            <th>Szczegóły</th>
        </tr>
    </thead>
        <tbody style="text-align:center">
            <?php 
            $this_page_first_result = ($page-1)*$results_per_page;
            
            
            $sql='SELECT id_order,total_price,order_date,status FROM orders WHERE id_user='. $_SESSION['id'] . ' LIMIT ' . $this_page_first_result . ',' .  $results_per_page;
            $result = mysqli_query($connection, $sql);

            while(list($id_order,$total_price,$order_date,$status)=mysqli_fetch_array($result)): ?>
            <tr>
            <?php 
            if($status=="placed"){
                $status_message = "Złożone";
            }else{
                $status_message = "Wysłane";
            }
            
            ?>
            <td><?=$id_order?></td><td><?=$order_date?></td><td><?=$status_message?></td><td><?=number_format($total_price,2)?> zł.</td>
            <td>
            <a href='orderdetail.php?id_order=<?=$id_order?>' type='button' rel='tooltip' title='' class='btn btn-danger' data-original-title='Detail'>
                    Więcej
                    <div class=''></div></a>
            </td></tr>
            <?php endwhile; 
            mysqli_close($connection);?>
        </tbody>
</table>
<?php 
    for ($page=1;$page<=$number_of_pages;$page++) {
        echo '<button class="btn btn-danger" style="margin-left: 4px"><a href="index.php?page=' . $page . '">' . $page . '</a> </button>';     
        }
?>