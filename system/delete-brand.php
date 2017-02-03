<?php 
include 'config/db_con.php';
include 'includes/auth.php';
$currentDate = date('Y-m-d H:i:s');

$brandId = $_GET['id'];
$SQL_BRAND = "DELETE FROM tbl_brands WHERE id = '".$brandId."'";
$RS_BRAND = mysql_query($SQL_BRAND) or die(mysql_error());
    header('Location: brands.php?status=deleted');
?>