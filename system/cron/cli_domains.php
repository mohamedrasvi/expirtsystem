<?php
    
include('phpwhois/whois.main.php');
include('myfunctions.php');
include('simple_html_dom.php');
include('db_con.php');

$currentDate = date('Y-m-d H:i:s');


$SQL_RES = "SELECT * FROM tbl_search_results";
$RS_RES  = mysql_query($SQL_RES) or die(mysql_error());


while($ROW_RES = mysql_fetch_array($RS_RES)){

    $domainName = $ROW_RES['result_from_link_domain_name'];
    $cityId = $ROW_RES['city_id'];
    $regionId = $ROW_RES['region_id'];
    $countryId = $ROW_RES['country_id'];
    
    $SQL_DOMAIN_EXISTS = "SELECT * FROM tbl_domains WHERE domain_name LIKE '".$domainName."'";
    $RS_DOMAIN_EXISTS = mysql_query($SQL_DOMAIN_EXISTS) or die(mysql_error());
    $ROW_DOMAIN_EXISTS_ROW = mysql_fetch_array($RS_DOMAIN_EXISTS);
    if($ROW_DOMAIN_EXISTS_ROW){
        print("Domain name '$domainName' already exists.... \n");
        
        $DOMAIN_ID = $ROW_DOMAIN_EXISTS_ROW['id'];
        $SQL_DOMAIN = "UPDATE tbl_search_results set result_from_link_domain_name = '".$DOMAIN_ID."'  WHERE result_from_link_domain_name LIKE '" . $domainName . "'";
        $RS_DOMAIN = mysql_query($SQL_DOMAIN) or die(mysql_error());

        
        
        
        
    } else {
        $SQL_INSERT = "INSERT INTO `tbl_domains` (
            `id`, 
            `domain_name`, 
            `post_code`, 
            `city_id`, 
            `region_id`, 
            `country_id`, 
            `added_on`, 
            `updated_on`) VALUES (
            NULL, 
            '".$domainName."', 
            NULL, 
            '".$cityId."', 
            '".$regionId."', 
            '".$countryId."', 
            '".$currentDate."', 
            '".$currentDate."')";
        
         $RS_DOMAIN = mysql_query($SQL_INSERT) or die(mysql_error());
        
         print("The new domain name '$domainName' inserted.... \n");
    }
    
    
}
?>