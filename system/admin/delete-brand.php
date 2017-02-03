<?php

include '../config/db_con.php';
include 'includes/auth.php';
$currentDate = date('Y-m-d H:i:s');

$brandId = $_GET['id'];
$SQL_BRAND = "DELETE FROM tbl_brands WHERE id = '" . $brandId . "'";
$RS_BRAND = mysql_query($SQL_BRAND) or die(mysql_error());

$memCacheKey = "relatedBrand_" . $brandId;
$memcache->delete($memCacheKey);

// delete...
// state results.....
$SQL_COUNTRIES = "SELECT * FROM countries";
$RS_COUNTRIES = mysql_query($SQL_COUNTRIES) or die(mysql_error());
while ($ROW_COUNTRY = mysql_fetch_array($RS_COUNTRIES)) {

    $countryId = $ROW_COUNTRY['id'];
    $memCacheKey = "state_" . $brandId . "_" . $countryId;
    $memcache->delete($memCacheKey);
}

header('Location: brands.php');
?>