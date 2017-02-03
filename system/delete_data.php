<?php 
include('config/db_con.php');

$mysqldate = "2013-11-11";//date("Y-m-d");


$arrBrands = array('4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27');

foreach($arrBrands As $bIndex=>$bId){
    $brandId = $bId;
  


$searchSource = 'facebook.com';//'facebook.com';

$SQL_GET_DATA = "SELECT id FROM tbl_search_results WHERE tbl_brands_id='".$brandId."' AND search_source='".$searchSource."' LIMIT 0,100";
$RS_GET_DATE = mysql_query($SQL_GET_DATA) or die(mysql_error());
$arrData = array();
while($ROW_DATA = mysql_fetch_array($RS_GET_DATE)){
    array_push($arrData, $ROW_DATA['id']);
}
$str = "'".implode ("','",$arrData)."'";

$SQL_DEL = "DELETE FROM tbl_search_results WHERE id NOT IN($str) AND tbl_brands_id='".$brandId."' AND search_source='".$searchSource."'";
$RS_DEL = mysql_query($SQL_DEL) or die(mysql_error());
print("Record deleted - ".$searchSource."\n");
print("\n");
print("\n");


$searchSource = 'YAHOO';//'facebook.com';

$SQL_GET_DATA = "SELECT id FROM tbl_search_results WHERE tbl_brands_id='".$brandId."' AND search_source='".$searchSource."' LIMIT 0,100";
$RS_GET_DATE = mysql_query($SQL_GET_DATA) or die(mysql_error());
$arrData = array();
while($ROW_DATA = mysql_fetch_array($RS_GET_DATE)){
    array_push($arrData, $ROW_DATA['id']);
}
$str = "'".implode ("','",$arrData)."'";

$SQL_DEL = "DELETE FROM tbl_search_results WHERE id NOT IN($str) AND tbl_brands_id='".$brandId."' AND search_source='".$searchSource."'";
$RS_DEL = mysql_query($SQL_DEL) or die(mysql_error());
print("Record deleted - ".$searchSource."\n");
print("\n");
print("\n");


$searchSource = 'GOOGLE';//'facebook.com';

$SQL_GET_DATA = "SELECT id FROM tbl_search_results WHERE tbl_brands_id='".$brandId."' AND search_source='".$searchSource."' LIMIT 0,100";
$RS_GET_DATE = mysql_query($SQL_GET_DATA) or die(mysql_error());
$arrData = array();
while($ROW_DATA = mysql_fetch_array($RS_GET_DATE)){
    array_push($arrData, $ROW_DATA['id']);
}
$str = "'".implode ("','",$arrData)."'";

$SQL_DEL = "DELETE FROM tbl_search_results WHERE id NOT IN($str) AND tbl_brands_id='".$brandId."' AND search_source='".$searchSource."'";
$RS_DEL = mysql_query($SQL_DEL) or die(mysql_error());
print("Record deleted - ".$searchSource."\n");
print("\n");
print("\n");


$searchSource = 'twitter.com';//'facebook.com';

$SQL_GET_DATA = "SELECT id FROM tbl_search_results WHERE tbl_brands_id='".$brandId."' AND search_source='".$searchSource."' LIMIT 0,100";
$RS_GET_DATE = mysql_query($SQL_GET_DATA) or die(mysql_error());
$arrData = array();
while($ROW_DATA = mysql_fetch_array($RS_GET_DATE)){
    array_push($arrData, $ROW_DATA['id']);
}
$str = "'".implode ("','",$arrData)."'";

$SQL_DEL = "DELETE FROM tbl_search_results WHERE id NOT IN($str) AND tbl_brands_id='".$brandId."' AND search_source='".$searchSource."'";
$RS_DEL = mysql_query($SQL_DEL) or die(mysql_error());
print("Record deleted - ".$searchSource."\n");
print("\n");
print("\n");

}
exit;

?>