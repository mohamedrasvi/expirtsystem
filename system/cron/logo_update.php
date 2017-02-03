<?php
    
include('phpwhois/whois.main.php');
include('myfunctions.php');
include('simple_html_dom.php');
include('db_con.php');

$currentDate = date('Y-m-d H:i:s');


$SQL_RES = "SELECT * FROM countries";
$RS_RES  = mysql_query($SQL_RES) or die(mysql_error());


while($ROW_RES = mysql_fetch_array($RS_RES)){

   
    $id     = $ROW_RES['id'];
    $code   = $ROW_RES['code'];
    $logo = strtolower($code).".png";
    
    $SQL_UPDATE_LOGO = "UPDATE countries SET country_logo = '".$logo."' WHERE id = '".$id."'";
    $rs = mysql_query($SQL_UPDATE_LOGO) or die(mysql_error());
    print("Updated ".$logo."\n");
    
    
}
?>