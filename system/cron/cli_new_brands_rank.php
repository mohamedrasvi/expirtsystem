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


$SQL_BRAND = "SELECT * FROM tbl_brands";
$RS_BRAND = mysql_query($SQL_BRAND) or die(mysql_error());

while($row_brand = mysql_fetch_assoc($RS_BRAND)){
    $brandId = $row_brand['id'];
    print("Brand ID ".$brandId."\n");


//sendEmail("Domain update started","Domain update started");
$SQL_DOMAIN = "SELECT id,result_from_link_domain_name,result_link,result_from_link FROM tbl_search_results WHERE `result_from_link` NOT IN ('facebook-page','facebook-post') AND search_source != 'facebook.com' AND tbl_brands_id = '".$brandId."' ORDER BY id Asc";
$RS_DOMAINS = mysql_query($SQL_DOMAIN) or die(mysql_error());
while($ROW_DOMAIN = mysql_fetch_assoc($RS_DOMAINS)){
    
    $srId = $ROW_DOMAIN['id'];
    $DOMAIN_ID = $ROW_DOMAIN['result_from_link_domain_name'];
    print("Domain ID - ". $DOMAIN_ID." \n");
    if($DOMAIN_ID == ""){
        print("Link - ". $ROW_DOMAIN['result_link']." Link from : ".$ROW_DOMAIN['result_from_link']." \n"); 
    }
    

    // get the domain info
    $SQL_DOMAIN_INFO = "SELECT * FROM tbl_domains WHERE id = '".$DOMAIN_ID."'";
    $RS_DOMAIN_INFO = mysql_query($SQL_DOMAIN_INFO) or die(mysql_error());
    $ROW_DOAMIN_INFO = mysql_fetch_assoc($RS_DOMAIN_INFO);
    
    $city_id  = $ROW_DOAMIN_INFO['city_id'];	
    $region_id 	= $ROW_DOAMIN_INFO['region_id'];	
    $country_id = $ROW_DOAMIN_INFO['country_id'];
    
    $SQL_UPDATE = "UPDATE tbl_search_results SET city_id = '".$city_id."',region_id = '".$region_id."',country_id = '".$country_id."' WHERE id = '".$srId."'";
    $RS_UPDATE = mysql_query($SQL_UPDATE) or die(mysql_error());
    print("Updated : ".$srId." City : ".$city_id." Region : ".$region_id." Country : ".$country_id."\n");
   
    
}


}

sendEmail("Domain update completed","Domain update completed");

exit;
/*
sendEmail("updateRankSummary Started","updateRankSummary Started");
$row_added_on = ADDED_ON_DATE;
$SQL_BRAND = "SELECT * FROM tbl_brands";
$RS_BRAND = mysql_query($SQL_BRAND) or die(mysql_error());

while($row_brand = mysql_fetch_assoc($RS_BRAND)){
    $brandId = $row_brand['id'];
    print("Brand ID ".$brandId."\n");
$brandId = $brandId;
updateRankSummary($brandId, $row_added_on); // brand id starting from 7
}
sendEmail("updateRankSummary completed","updateRankSummary completed");
exit;
*/
?>
