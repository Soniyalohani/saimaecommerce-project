<?php 
@session_start(); 
if(!isset($_SESSION['email'])){
  echo "<script>window.open('login.php?not_admin=You are not an Admin!','_self')</script>";
}
else {
?>  
<?php

include("includes/connect.php"); 

$path = 'productimage/';

$pro_id = $_GET['product_id'];

$query = "select * FROM `tbl_product` WHERE product_id = $pro_id ";

$ans = mysqli_query($con, $query);

$row=mysqli_fetch_row($ans);

unlink($path.'/'.$row[5]);

$q = " DELETE FROM `tbl_product` WHERE product_id = $pro_id ";
$query=mysqli_query($con, $q);
header('location:index.php?view_productlist');
?>
 <?php } ?>