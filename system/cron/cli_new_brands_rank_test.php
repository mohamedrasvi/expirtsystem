<?php

include('db_con.php');
include('phpwhois/whois.main.php');
include('simple_html_dom.php');
include('Logger.php');
include('myfunctions.php');
include 'includes/Paggination.php';
include 'includes/class.phpmailer.php';
require 'facebook/facebookSearcher.class.php';
date_default_timezone_set('Asia/Colombo');

// test do count....
$row_web_link = "http://cran.r-project.org/doc/manuals/R-intro.pdf";
$row_search_key = "test";
$row_added_on = "2014-01-25";
$row_brandId = "1";
$row_search_source = "google";
doCounts($row_web_link, $row_search_key, $row_added_on, $row_brandId, $row_search_source);


//$brandId = 3;
//$row_added_on = '2014-01-25';

//updateSocialMediaRankSummary($brandId, $row_added_on);
exit;

/*

$SQL_BRAND_SUM = "SELECT sum(total_count) As total_count FROM tbl_search_results WHERE tbl_brands_id = '" . $brandId . "' AND search_source NOT IN('facebook.com','twitter.com') AND date_on = '" . $row_added_on . "'";
$RS_BRAND_SUM = mysql_query($SQL_BRAND_SUM) or die(mysql_error());
$ROW_BRAND = mysql_fetch_assoc($RS_BRAND_SUM);
$BRAND_TOTAL_COUNT = $ROW_BRAND['total_count'];

print("\n\n\n Total Count : ".$BRAND_TOTAL_COUNT);

$SQL_TOP_COUNTRY = "SELECT sum(total_count) As tot FROM tbl_search_results WHERE search_source NOT IN('facebook.com','twitter.com') AND tbl_brands_id = '" . $brandId . "' AND country_id = '230' AND date_on = '" . $row_added_on . "'";
$RS_TOP_COUNTRY = mysql_query($SQL_TOP_COUNTRY) or die(mysql_error());
$ROW_TOP_COUNTRY = mysql_fetch_assoc($RS_TOP_COUNTRY);
$total_count = $ROW_TOP_COUNTRY['tot'];
print("\n\n\n  Total in US : ".$total_count."\n\n\n");  


$count_in_persentage = round((($total_count / $BRAND_TOTAL_COUNT) * 100), 2);

print("The persentage : ".$count_in_persentage."\n\n\n\n\n");
 * 
 */
exit;
?>
