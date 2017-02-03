<?php
include 'config/db_con.php';
include 'includes/auth.php';
include 'includes/class.phpmailer.php';
$currentDate = date('Y-m-d H:i:s');

$linkIds = $_POST['txtLinkId']; 
$message = $_POST['message'];
$userId = $_SESSION['userId'];
$remoteIp = $_SERVER['REMOTE_ADDR'];

foreach($linkIds As $lMessage=>$link){

    $SQL_INSERT_COMPLAIN = "INSERT INTO `tbl_complains`(
        `id`, 
        `link_id`, 
        `ip_address`, 
        `date_and_time`, 
        `reported_by`,
        `message`) VALUES (
        NULL, 
        '".$link."', 
        '".$remoteIp."', 
        '".$currentDate."', 
        '".$userId."', 
        '".$message."')";
    
    $RS_COMPLAIN = mysql_query($SQL_INSERT_COMPLAIN) or die(mysql_error());
    
}
 header('Location: action_page.php?status=updated');

?>