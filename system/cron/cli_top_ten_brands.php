<?php
    
include('phpwhois/whois.main.php');
include('myfunctions.php');
include('simple_html_dom.php');
include('db_con.php');
include('Logger.php');

$currentDate = date('Y-m-d H:i:s');
$objLogger = new Logger();
$objLogger->write("cli-top-ten-brands script started");


//$rs = mysql_query("DELETE FROM tbl_top_brands") or die(mysql_error());

$SQL_RES = "SELECT sum(total_count) as total_count,tbl_brands_id FROM tbl_search_results GROUP BY tbl_brands_id ORDER BY total_count desc";
$RS_RES  = mysql_query($SQL_RES) or die(mysql_error());

while($ROW_TOP_SEARCH_RES = mysql_fetch_array($RS_RES)){
    
    $brandId = $ROW_TOP_SEARCH_RES['tbl_brands_id'];
    $totalCount = $ROW_TOP_SEARCH_RES['total_count'];
    
    // count country id .....
    $SQL_COUNTRY_COUNT = "SELECT country_id FROM tbl_search_results WHERE tbl_brands_id = '".$brandId."'";
    $RS_COUNTRY_COUNT  = mysql_query($SQL_COUNTRY_COUNT) or die(mysql_error());
    
    $arrCountry = array();
    while($ROW_COUNTRY = mysql_fetch_array($RS_COUNTRY_COUNT)){
        $countryId = $ROW_COUNTRY['country_id'];
        if($countryId != 0){
        if (!in_array($countryId, $arrCountry, true)) {
                array_push($arrCountry, $countryId);
        } 
        }
    }
    
    $totalCountry = count($arrCountry);
    
    $SQL_TOP_RESULTS = "INSERT INTO `tbl_top_brands` (`id`, `brand_id`, `total_results`, `total_countries`, `date_on`) VALUES (
        NULL, 
        '".$brandId."', 
        '".$totalCount."', 
        '".$totalCountry."', 
        '".$currentDate."')";
    
    $RS_TOP_INSERT = mysql_query($SQL_TOP_RESULTS) or die(mysql_error());
    print("Exported \n");
    
}
$objLogger->write("cli-top-ten-brands script completed");
?>