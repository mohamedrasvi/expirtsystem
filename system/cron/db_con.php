<?php
ini_set('display_errors', 'On');
//error_reporting(0);

$SERVER_NAME = "localhost";
$USER_NAME = "root";
$PASSWORD_NAME = "root";
$DB_NAME = "yegga_new2";


$db_con = mysql_connect($SERVER_NAME, $USER_NAME, $PASSWORD_NAME) or die(mysql_error());
$db_name = mysql_select_db($DB_NAME, $db_con) or die(mysql_error());

define('DB_CONNECTION', $db_con);

define('max_input_nesting_level', 6000000); 

// get site settings.....
$SQL_SITE_SETTIGS = "SELECT * FROM tbl_site_settings WHERE id = 1";
$RS_SITE_SETTIGS = mysql_query($SQL_SITE_SETTIGS,DB_CONNECTION) or die(mysql_error());
$ROW_SITE_SETTIGS = mysql_fetch_array($RS_SITE_SETTIGS);
$site_name = $ROW_SITE_SETTIGS['site_name'];
$site_email_addresses = $ROW_SITE_SETTIGS['site_email_addresses'];
$site_phone_number = $ROW_SITE_SETTIGS['site_phone_number'];
$site_contact_number = $ROW_SITE_SETTIGS['site_contact_number'];
$site_address = $ROW_SITE_SETTIGS['site_address'];
$site_footer_text = $ROW_SITE_SETTIGS['site_footer_text'];
define('SITE_NAME', $site_name);
define('SITE_EMAIL_ADDRESS', $site_email_addresses);
define('SITE_PHONE_NUMBER', $site_phone_number);
define('SITE_CONTACT_NUMBER', $site_contact_number);
define('SITE_CONTACT_ADDRESS', $site_address);
define('SITE_FOOTER_TEXT', $site_footer_text);



$consumerKey = "MWW0gxvfZvvKgUGUdndA";
$consumerSecret = "6rjmCQKNMjFiR0qHHLF7KACT0Z2Pd5XQ99LWcScEk";
$accessToken = "189920488-6Z4f3zt6BQiFZYqVxRUX8VwCHsgD9mNhxelqg3ML";
$accessTokenSecret = "Ofvv3VFrDs45hAxqVHvhmnOwrW6hC4FxP7KXeEPahl8";

function getCountryId($countryName){
    $SQL_COUNTRY = "SELECT * FROM countries WHERE name LIKE '" . $countryName . "' OR code LIKE '" . $countryName . "' OR code3 LIKE '" . $countryName . "'";
    $RS_COUNTRY = mysql_query($SQL_COUNTRY) or die(mysql_error());
    $ROW_COUNTRY = mysql_fetch_assoc($RS_COUNTRY);
    if ($ROW_COUNTRY) {
          $COUNTRY_ID = $ROW_COUNTRY['id'];
    }
    return $COUNTRY_ID;
}


function getRegionId($regionName,$COUNTRY_ID){
    $SQL_REGION = "SELECT * FROM regions WHERE (name LIKE '" . $regionName . "' OR code LIKE '" . $regionName . "') AND country_id = '" . $COUNTRY_ID . "'";
    $RS_REGION = mysql_query($SQL_REGION) or die(mysql_error());
    $ROW_REGION = mysql_fetch_assoc($RS_REGION);
    if ($ROW_REGION) {
        $REGION_ID = $ROW_REGION['id'];
    }
    return $REGION_ID;
}


function getCityId($CITYNAME,$REGION_ID,$COUNTRY_ID){
     $SQL_CITY = "SELECT * FROM cities WHERE name LIKE '" . $CITYNAME . "' AND region_id = '" . $REGION_ID . "' AND country_id = '" . $COUNTRY_ID . "'";
     $RS_CITY = mysql_query($SQL_CITY) or die(mysql_error());
     $ROW_CITY = mysql_fetch_assoc($RS_CITY);
     if ($ROW_CITY) {
           $CITY_ID = $ROW_CITY['id']; 
      }
      
      return $CITY_ID;
}

$SLEEP_BETWEEN_SEARCH_ENGINES = 300;
define('SLEEP_BETWEEN_SEARCH_ENGINES', $SLEEP_BETWEEN_SEARCH_ENGINES);
$SLEEP_BETWEEN_BRANDS = 300;
define('SLEEP_BETWEEN_BRANDS', $SLEEP_BETWEEN_BRANDS);

// google....
$GOOGLE_SLEEP_AFTER_GET_PAGES = 300;
define('GOOGLE_SLEEP_AFTER_GET_PAGES', $GOOGLE_SLEEP_AFTER_GET_PAGES);
$GOOGLE_SLEEP_BETWEENPAGES = 300;
define('GOOGLE_SLEEP_BETWEENPAGES', $GOOGLE_SLEEP_BETWEENPAGES);

// yahoo....
$YAHOO_SLEEP_AFTER_GET_PAGES = 300;
define('YAHOO_SLEEP_AFTER_GET_PAGES', $YAHOO_SLEEP_AFTER_GET_PAGES);
$YAHOO_SLEEP_BETWEENPAGES = 300;
define('YAHOO_SLEEP_BETWEENPAGES', $YAHOO_SLEEP_BETWEENPAGES);

define('PAGE_LIMIT',5);

$APPID = '237820963058461';
define('APPID',$APPID);
$APPSECRET = '7984f054de9faf468c7cd83889bd5d40';
define('APPSECRET',$APPSECRET);

$report_date = "2014-01-25";//date("Y-m-d");
define("ADDED_ON_DATE",$report_date);
?>
