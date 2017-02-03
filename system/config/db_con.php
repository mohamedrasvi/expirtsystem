<?php

$siteBaseUrl = "http://yegga.com/";
$siteAdminBaseUrl = "http://yegga.com/";
ini_set('display_errors', 'On');
error_reporting(E_ALL);
error_reporting(E_ALL ^ E_DEPRECATED);
//ini_set('session.save_path', "C:/Windows/temp/");

$SERVER_NAME = "localhost";
$USER_NAME = "root";
$PASSWORD_NAME = "Y3gg82014!";
$DB_NAME = "yegga_db";

date_default_timezone_set('Asia/Colombo');

$db_con = mysql_connect($SERVER_NAME, $USER_NAME, $PASSWORD_NAME) or die(mysql_error());
$db_name = mysql_select_db($DB_NAME, $db_con) or die(mysql_error());

// get site settings.....
$SQL_SITE_SETTIGS = "SELECT * FROM tbl_site_settings WHERE id = 1";
$RS_SITE_SETTIGS = mysql_query($SQL_SITE_SETTIGS) or die(mysql_error());
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

function convertToK($totalNumber) {

    $res = $totalNumber / 1000;
    $res_rounded = round($res, 3);
    return $res_rounded;
}

session_start();

function getCountryName($countryId) {
    $countryName = "";
    if ($countryId != "") {
        $SQL_COUNTRY = "SELECT * FROM countries WHERE id = '" . $countryId . "'";
        $RS_COUNTRY = mysql_query($SQL_COUNTRY) or die(mysql_error());
        $ROW_COUNTRY = mysql_fetch_array($RS_COUNTRY);
        $countryName = $ROW_COUNTRY['name'];
    }
    return $countryName;
}

function getRegionName($regionId) {
    $regionName = "";
    if ($regionId != "") {
        $SQL_REGION = "SELECT * FROM regions WHERE id = '" . $regionId . "'";
        $RS_REGION = mysql_query($SQL_REGION) or die(mysql_error());
        $ROW_REGION = mysql_fetch_array($RS_REGION);
        $regionName = $ROW_REGION['name'];
    }
    return $regionName;
}

function getCityName($cityId) {
    $cityName = "";
    if ($cityId != "") {
        $SQL_CITY = "SELECT * FROM cities WHERE id = '" . $cityId . "'";
        $RS_CITY = mysql_query($SQL_CITY) or die(mysql_error());
        $ROW_CITY = mysql_fetch_array($RS_CITY);
        $cityName = $ROW_CITY['name'];
    }
    return $cityName;
}

function getSectorName($sectorId) {
    $sectorName = "";
    if ($sectorId != "") {
        $SQL_SECTOR = "SELECT * FROM tbl_sector WHERE id = '" . $sectorId . "'";
        $RS_SECTOR = mysql_query($SQL_SECTOR) or die(mysql_error());
        $ROW_SECTOR = mysql_fetch_array($RS_SECTOR);
        $sectorName = $ROW_SECTOR['name'];
    }
    return $sectorName;
}

$report_date = "2014-01-25"; //date("Y-m-d");
define("REPORT_DATE", $report_date);


// Connection constants
define('MEMCACHED_HOST', '127.0.0.1');
define('MEMCACHED_PORT', '11211');

// Connection creation
//$memcache = new Memcache();
//$cacheAvailable = $memcache->connect(MEMCACHED_HOST, MEMCACHED_PORT);

function formateUrlString($strUrl) {
    $strUrl = str_replace(' ', '-', $strUrl);
    $strUrl = str_replace('"', '&bdquo;', $strUrl);
    $strUrl = str_replace("'", '&rsquo;', $strUrl);
    $strUrl = str_replace(',', '&sbquo;', $strUrl);
    $strUrl = str_replace('?', '&#63;', $strUrl);
    $strUrl = str_replace("&", '&amp;', $strUrl);
    $strUrl = strtolower($strUrl);
    return $strUrl;
}

function getRankInCountry($brandId, $countryId, $reportDate) {
    $currentBrandRank = '';
    $SQL_BRAND_INFO = "SELECT * FROM tbl_brands WHERE id = '" . $brandId . "'";
    $RS_BRAND_INFO = mysql_query($SQL_BRAND_INFO) or die(mysql_error());
    $brand_sector_id = $RS_BRAND_INFO['sector'];


    $SQL_RELATED_TOP_BRANDS = "SELECT searchResults.tbl_brands_id as brandId,sum(searchResults.total_count) as totalCount,brand.brand_name as brandName,brand.brand_logo As brand_logo FROM tbl_search_results as searchResults,tbl_brands as brand WHERE brand.id = searchResults.tbl_brands_id AND searchResults.date_on = '" . $reportDate . "' AND brand.sector = '" . $brand_sector_id . "' AND searchResults.country_id = '" . $countryId . "' GROUP BY searchResults.tbl_brands_id ORDER BY totalCount Desc";
    $RS_RELATED_TOP_BRANDS = mysql_query($SQL_RELATED_TOP_BRANDS) or die(mysql_error());
    $arrRelatedTopBrands = array();
    $brandNum = 0;
    while ($ROW_RELATED_TOP_BRANDS = mysql_fetch_array($RS_RELATED_TOP_BRANDS)) {
        $brandNum = $brandNum + 1;
        $currentBrandId = $ROW_RELATED_TOP_BRANDS['brandId'];
        if ($brandId == $currentBrandId) {
            $currentBrandRank = $brandNum;
            break;
        }
    }

    return $currentBrandRank;
}

function rfloor($real, $decimals) {
    return substr($real, 0, strrpos($real, '.', 0) + (1 + $decimals));
}

function getTimeAgo($actionTimeAgo) {
    $cur_time = time();
    $time_ago = strtotime($actionTimeAgo);
    $time_elapsed = $cur_time - $time_ago;
    $seconds = $time_elapsed;
    $minutes = round($time_elapsed / 60);
    $hours = round($time_elapsed / 3600);
    $days = round($time_elapsed / 86400);
    $weeks = round($time_elapsed / 604800);
    $months = round($time_elapsed / 2600640);
    $years = round($time_elapsed / 31207680);
// Seconds
    if ($seconds <= 60) {
        echo "$seconds seconds ago";
    }
//Minutes
    else if ($minutes <= 60) {
        if ($minutes == 1) {
            echo "one minute ago";
        } else {
            echo "$minutes minutes ago";
        }
    }
//Hours
    else if ($hours <= 24) {
        if ($hours == 1) {
            echo "an hour ago";
        } else {
            echo "$hours hours ago";
        }
    }
//Days
    else if ($days <= 7) {
        if ($days == 1) {
            echo "yesterday";
        } else {
            echo "$days days ago";
        }
    }
//Weeks
    else if ($weeks <= 4.3) {
        if ($weeks == 1) {
            echo "a week ago";
        } else {
            echo "$weeks weeks ago";
        }
    }
//Months
    else if ($months <= 12) {
        if ($months == 1) {
            echo "a month ago";
        } else {
            echo "$months months ago";
        }
    }
//Years
    else {
        if ($years == 1) {
            echo "one year ago";
        } else {
            echo "$years years ago";
        }
    }
}

function isFileExist($fileName) {
    $file = 'http://yegga.com/contents/logos/' . $fileName;
    $file_headers = @get_headers($file);
    if ($file_headers[0] == 'HTTP/1.1 404 Not Found') {
        $exists = false;
    } else {
        $exists = true;
    }
    return $exists;
}

?>
