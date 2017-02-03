<?php
include('db_con.php');
include('phpwhois/whois.main.php');
include('simple_html_dom.php');
include('Logger.php');
include('myfunctions.php');

$currentDate = date('Y-m-d');

$objLogger = new Logger();
$objLogger->write("cli.php started");


//$SQL_BRANDS = "SELECT * FROM tbl_brands WHERE is_status = 'Enabled' LIMIT 0,1"; -- original
$SQL_BRANDS = "SELECT * FROM tbl_brands WHERE is_status = 'Enabled' AND is_new_brand = 'No' ORDER BY added_on Desc";
$RS_BRANDS = mysql_query($SQL_BRANDS) or die(mysql_error());


while ($ROW_BRAND = mysql_fetch_array($RS_BRANDS)) {

    $brandId = $ROW_BRAND['id'];
    $brandName = $ROW_BRAND['brand_name'];
    $brandTags = $ROW_BRAND['brand_tags'];
    $isNewBrand = $ROW_BRAND['is_new_brand'];

    $brandTagsPieces = explode(",", $brandTags);

    print("Featching search results for " . $brandName . ".....\n");

    foreach ($brandTagsPieces As $tIndex => $brandTag) {
        $serachStr = $brandTag;
        getGoogleLinks($serachStr,$brandId);
        getYahooLinks($serachStr,$brandId);
    }



    // the brand completed....update status.....
    $SQL_BRAND = "UPDATE tbl_brands SET last_update_on='" . $currentDate . "' WHERE id = '" . $brandId . "'";
    $RS_BRAND_COMPLETED = mysql_query($SQL_BRAND, DB_CONNECTION) or die(mysql_error());
}



$objLogger->write("cli.php completed");
exit();
?>
