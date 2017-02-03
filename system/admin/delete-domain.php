<?php
include '../config/db_con.php';
include 'includes/auth.php';
$currentDate = date('Y-m-d H:i:s');

$dmianId = $_GET['id'];
$SQL_DOMAIN = "DELETE FROM tbl_domains WHERE id = '".$dmianId."'";
$RS_DOMAIN = mysql_query($SQL_DOMAIN) or die(mysql_error());
header('Location: domains.php');
?>