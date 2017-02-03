<?php 
include('config/db_con.php');

$mysqldate = REPORT_DATE;
// set top 10 brands to the memcache....
$memcache->set('topTenBrands', "");

$SQL_TOP_BRANDS = "SELECT searchResults.tbl_brands_id as brandId,sum(searchResults.total_count) as totalCount,brand.brand_name as brandName,brand.brand_logo As brand_logo FROM tbl_search_results as searchResults,tbl_brands as brand WHERE brand.id = searchResults.tbl_brands_id AND searchResults.date_on = '".$mysqldate."' GROUP BY searchResults.tbl_brands_id ORDER BY totalCount Desc";
$RS_TOP_BRANDS  = mysql_query($SQL_TOP_BRANDS) or die(mysql_error());

$arrTopBrands = array();
while($ROW_TOP_BRANDS = mysql_fetch_array($RS_TOP_BRANDS)){
    $objTopBrand = new stdClass();
    $objTopBrand->brandId = $ROW_TOP_BRANDS['brandId'];
    $objTopBrand->brandName = $ROW_TOP_BRANDS['brandName'];
    $objTopBrand->brandLogo = $ROW_TOP_BRANDS['brand_logo'];
    $objTopBrand->totalCount = $ROW_TOP_BRANDS['totalCount'];
    
    $SQL_COUNT_COUNTRY = "SELECT count(DISTINCT country_id) as totalCountry FROM `tbl_search_results` WHERE `tbl_brands_id` = '".$ROW_TOP_BRANDS['brandId']."' AND date_on = '".$mysqldate."'";
    $RS_COUNT_COUNTRY  = mysql_query($SQL_COUNT_COUNTRY) or die(mysql_error());
    $ROW_COUNT_COUNTRY = mysql_fetch_assoc($RS_COUNT_COUNTRY);
    $objTopBrand->numberOfCountry = $ROW_COUNT_COUNTRY['totalCountry'];
    array_push($arrTopBrands, $objTopBrand);
}

$memcache->set('topTenBrands', $arrTopBrands);
print("cache added to top brand \n");


// get all brands twitter and facebook...
$SQL_BRANDS = "SELECT * FROM tbl_brands";
$RS_BRAND = mysql_query($SQL_BRANDS) or die(mysql_error());
while($ROW_BRAND = mysql_fetch_array($RS_BRAND)){
 
    $brandId = $ROW_BRAND['id'];
    
    $SQL_FACEBOOK = "SELECT sum(total_count) As tot FROM tbl_search_results WHERE search_source = 'facebook.com' AND tbl_brands_id = '".$brandId."' AND date_on='".$mysqldate."'";
    $RS_TOP_FACEBOOK  = mysql_query($SQL_FACEBOOK) or die(mysql_error());
    $ROW_TOP_FACEBOOK = mysql_fetch_assoc($RS_TOP_FACEBOOK);
    $TOTAL_FACEBOOK   = $ROW_TOP_FACEBOOK['tot'];
    
    $memCacheKey = "facebook.com_".$brandId;
    $memcache->set($memCacheKey, $TOTAL_FACEBOOK);
    
    
    $SQL_TWITTER = "SELECT sum(total_count) As tot FROM tbl_search_results WHERE search_source = 'twitter.com' AND tbl_brands_id = '".$brandId."' AND date_on='".$mysqldate."'";
    $RS_TOP_TWITTER  = mysql_query($SQL_TWITTER) or die(mysql_error());
    $ROW_TOP_TWITTER = mysql_fetch_assoc($RS_TOP_TWITTER);
    $TOTAL_TWITTER   = $ROW_TOP_TWITTER['tot'];
    
    $memCacheKey = "twitter.com_".$brandId;
    $memcache->set($memCacheKey, $TOTAL_TWITTER);
    print("cache added to social network $memCacheKey \n");
}




// country results by brand....
$SQL_BRANDS = "SELECT * FROM tbl_brands";
$RS_BRAND = mysql_query($SQL_BRANDS) or die(mysql_error());
while($ROW_BRAND = mysql_fetch_array($RS_BRAND)){
    
    $brandId = $ROW_BRAND['id'];
    $memCacheKey = "country_".$brandId;
    
    
    $SQL_BRAND_SUM = "SELECT sum(total_count) As total_count FROM tbl_search_results WHERE tbl_brands_id = '".$brandId."' AND search_source NOT IN('facebook.com','twitter.com')";
$RS_BRAND_SUM = mysql_query($SQL_BRAND_SUM) or die(mysql_error());
$ROW_BRAND = mysql_fetch_assoc($RS_BRAND_SUM);
$TOTAL_COUNT = $ROW_BRAND['total_count'];



$SQL_TOP_COUNTRY = "SELECT searchResults.tbl_brands_id as brandId,
    sum(searchResults.total_count) as totalCount,
    brand.brand_name as brandName,
    brand.brand_logo As brand_logo,
    searchResults.country_id As countryId,
    country.name as countryName,
    country.country_logo as country_logo,
    country.latitude as latitude,
    country.longitude as longitude 
    FROM tbl_search_results as searchResults,
    tbl_brands as brand,countries as country 
    WHERE brand.id = searchResults.tbl_brands_id 
    AND brand.id = '".$brandId."' 
        AND searchResults.country_id = country.id 
        AND searchResults.date_on = '".$mysqldate."' 
            AND searchResults.search_source NOT IN('facebook.com','twitter.com')
            GROUP BY countryId ORDER BY totalCount Desc";

$RS_TOP_COUNTRY  = mysql_query($SQL_TOP_COUNTRY) or die(mysql_error());

$arrTopCountryResults = array();
while($ROW_TOP_COUNTRY = mysql_fetch_array($RS_TOP_COUNTRY)){
    $objCountry = new stdClass();
    $objCountry->brandId = $ROW_TOP_COUNTRY['brandId'];
    $objCountry->totalCount = $ROW_TOP_COUNTRY['totalCount'];
    $objCountry->totalCountInPercentage = round((($ROW_TOP_COUNTRY['totalCount']/$TOTAL_COUNT)*100),2);
    $objCountry->brandName = $ROW_TOP_COUNTRY['brandName'];
    $objCountry->brandLogo = $ROW_TOP_COUNTRY['brand_logo'];
    $objCountry->countryId = $ROW_TOP_COUNTRY['countryId'];
    $objCountry->countryName = $ROW_TOP_COUNTRY['countryName'];
    $objCountry->countryLogo = $ROW_TOP_COUNTRY['country_logo'];
    $objCountry->latitude = $ROW_TOP_COUNTRY['latitude'];
    $objCountry->longitude = $ROW_TOP_COUNTRY['longitude'];
    
    
    $SQL_TOP_REGION = "SELECT count(searchResults.id) as tot, searchResults.tbl_brands_id as brandId,
    sum(searchResults.total_count) as totalCount,
    brand.brand_name as brandName,
    brand.brand_logo As brand_logo,
    searchResults.country_id As countryId,
    searchResults.region_id As searchRegionId,
    region.id As regionId,
    region.name As regionName,
    region.latitude As latitude,
    region.longitude As longitude
    FROM tbl_search_results as searchResults,
    tbl_brands as brand,regions as region 
    WHERE brand.id = searchResults.tbl_brands_id 
    AND brand.id = '".$ROW_TOP_COUNTRY['brandId']."' 
        AND searchResults.region_id = region.id 
         AND searchResults.country_id = '".$ROW_TOP_COUNTRY['countryId']."' 
        AND searchResults.date_on = '".$mysqldate."' 
             AND searchResults.search_source NOT IN('facebook.com','twitter.com')
            GROUP BY regionId ORDER BY totalCount Desc";

    $RS_TOP_REGION  = mysql_query($SQL_TOP_REGION) or die(mysql_error());
    $ROW_TOP_REGION = mysql_fetch_assoc($RS_TOP_REGION);
    $objCountry->totRegionResult = $ROW_TOP_REGION['tot'];
    if($ROW_TOP_REGION['tot']>0){
        $objCountry->clickable = 'Yes';
    } else {
       $objCountry->clickable = 'No'; 
    }

    $RS_TOP_REGION  = mysql_query($SQL_TOP_REGION) or die(mysql_error());
    
    
    array_push($arrTopCountryResults, $objCountry);
}
    
    
$memcache->set($memCacheKey, $arrTopCountryResults);
    
    print("cache added to country $memCacheKey \n");
}



// get realated brands....
$SQL_BRANDS = "SELECT * FROM tbl_brands";
$RS_BRAND = mysql_query($SQL_BRANDS) or die(mysql_error());
while($ROW_BRAND = mysql_fetch_array($RS_BRAND)){
    
        $brandId = $ROW_BRAND['id'];
    
    
    // get the brand information....
        $SQL_BRAND_INFO = "SELECT * FROM tbl_brands WHERE id = '".$brandId."'";
        $RS_BRAND_INFO = mysql_query($SQL_BRAND_INFO) or die(mysql_error());
        $ROW_BRAND_INFO = mysql_fetch_assoc($RS_BRAND_INFO);
        $brand_sector_id = $ROW_BRAND_INFO['sector']; 
        //// get top brands in this country for selected sector..........
        //$SQL_RELATED_BRANDS = "SELECT sr.country_id as countryId,c.name as countryName,c.country_logo as country_logo,sum(sr.total_count) As total_count,sr.tbl_brands_id As brandId,b.brand_name As brand_name,b.brand_logo As brand_logo FROM tbl_search_results As sr,countries as c,tbl_brands as b WHERE b.id = sr.tbl_brands_id AND tbl_brands_id != '".$brandId."' AND b.sector = '".$brand_sector_id."' AND c.id=sr.country_id GROUP BY country_id ORDER BY total_count Desc LIMIT 0,10";
        ////print($SQL_TOP_COUNTRY);exit;
        //$RS_RELATED_BRANDS  = mysql_query($SQL_RELATED_BRANDS) or die(mysql_error());

        //*********** GET THE TOP 20 RELATED BRANDS ****************
        $SQL_RELATED_TOP_BRANDS = "SELECT searchResults.tbl_brands_id as brandId,sum(searchResults.total_count) as totalCount,brand.brand_name as brandName,brand.brand_logo As brand_logo FROM tbl_search_results as searchResults,tbl_brands as brand WHERE brand.id = searchResults.tbl_brands_id AND searchResults.date_on = '".$mysqldate."' AND brand.sector = '".$brand_sector_id."' GROUP BY searchResults.tbl_brands_id ORDER BY totalCount Desc LIMIT  0,20";
        $RS_RELATED_TOP_BRANDS  = mysql_query($SQL_RELATED_TOP_BRANDS) or die(mysql_error());
        $arrRelatedTopBrands = array();
        while($ROW_RELATED_TOP_BRANDS = mysql_fetch_array($RS_RELATED_TOP_BRANDS)){
            $objTopBrand = new stdClass();
            $objTopBrand->brandId = $ROW_RELATED_TOP_BRANDS['brandId'];
            $objTopBrand->brandName = $ROW_RELATED_TOP_BRANDS['brandName'];
            $objTopBrand->brandLogo = $ROW_RELATED_TOP_BRANDS['brand_logo'];
            $objTopBrand->totalCount = $ROW_RELATED_TOP_BRANDS['totalCount'];

            $SQL_COUNT_COUNTRY = "SELECT count(DISTINCT country_id) as totalCountry FROM `tbl_search_results` WHERE `tbl_brands_id` = '".$ROW_RELATED_TOP_BRANDS['brandId']."' AND date_on = '".$mysqldate."'";
            $RS_COUNT_COUNTRY  = mysql_query($SQL_COUNT_COUNTRY) or die(mysql_error());
            $ROW_COUNT_COUNTRY = mysql_fetch_assoc($RS_COUNT_COUNTRY);
            $objTopBrand->numberOfCountry = $ROW_COUNT_COUNTRY['totalCountry'];
            array_push($arrRelatedTopBrands, $objTopBrand);
        }
        
        
        $memCacheKey = "relatedBrand_".$brandId;
        $memcache->set($memCacheKey, $arrRelatedTopBrands);
        
        print("cache added to related brand $memCacheKey \n");
    
}


// get top brands....
$SQL_TOP_BRANDS = "SELECT searchResults.tbl_brands_id as brandId,sum(searchResults.total_count) as totalCount,brand.brand_name as brandName,brand.brand_logo As brand_logo FROM tbl_search_results as searchResults,tbl_brands as brand WHERE brand.id = searchResults.tbl_brands_id AND searchResults.date_on = '".$mysqldate."' GROUP BY searchResults.tbl_brands_id ORDER BY totalCount Desc LIMIT  0,20";
$RS_TOP_BRANDS  = mysql_query($SQL_TOP_BRANDS) or die(mysql_error());

$arrTopBrands = array();
while($ROW_TOP_BRANDS = mysql_fetch_array($RS_TOP_BRANDS)){
    $objTopBrand = new stdClass();
    $objTopBrand->brandId = $ROW_TOP_BRANDS['brandId'];
    $objTopBrand->brandName = $ROW_TOP_BRANDS['brandName'];
    $objTopBrand->brandLogo = $ROW_TOP_BRANDS['brand_logo'];
    $objTopBrand->totalCount = $ROW_TOP_BRANDS['totalCount'];
    
    $SQL_COUNT_COUNTRY = "SELECT count(DISTINCT country_id) as totalCountry FROM `tbl_search_results` WHERE `tbl_brands_id` = '".$ROW_TOP_BRANDS['brandId']."' AND date_on = '".$mysqldate."'";
    $RS_COUNT_COUNTRY  = mysql_query($SQL_COUNT_COUNTRY) or die(mysql_error());
    $ROW_COUNT_COUNTRY = mysql_fetch_assoc($RS_COUNT_COUNTRY);
    $objTopBrand->numberOfCountry = $ROW_COUNT_COUNTRY['totalCountry'];
    array_push($arrTopBrands, $objTopBrand);
}

$memCacheKey = "topBrand";
$memcache->set($memCacheKey, $arrTopBrands);

print("cache added to top brand $memCacheKey \n");


// state results.....
$SQL_COUNTRIES = "SELECT * FROM countries";
$RS_COUNTRIES = mysql_query($SQL_COUNTRIES) or die(mysql_error());
while($ROW_COUNTRY = mysql_fetch_array($RS_COUNTRIES)){
 
    $countryId = $ROW_COUNTRY['id'];
    
    $SQL_BRANDS = "SELECT * FROM tbl_brands";
    $RS_BRAND = mysql_query($SQL_BRANDS) or die(mysql_error());
    while($ROW_BRAND = mysql_fetch_array($RS_BRAND)){
    
        $brandId = $ROW_BRAND['id'];
        
        
        
        $arrTopRegionResults = array();
$SQL_COUNTRY = "SELECT * FROM countries WHERE id = '".$countryId."'";
$RS_COUNTRY = mysql_query($SQL_COUNTRY) or die(mysql_error());
$ROW_COUNTRY_NAME = mysql_fetch_assoc($RS_COUNTRY);

$country_name = $ROW_COUNTRY_NAME['name'];
$country_latitude = $ROW_COUNTRY_NAME['latitude'];
$country_longitude = $ROW_COUNTRY_NAME['longitude'];


$SQL_BRAND_SUM = "SELECT sum(total_count) As total_count FROM tbl_search_results WHERE tbl_brands_id = '".$brandId."' AND country_id = '".$countryId."'  AND search_source NOT IN('facebook.com','twitter.com')";
$RS_BRAND_SUM = mysql_query($SQL_BRAND_SUM) or die(mysql_error());
$ROW_BRAND = mysql_fetch_assoc($RS_BRAND_SUM);
$TOTAL_COUNT = $ROW_BRAND['total_count'];

$SQL_TOP_REGION = "SELECT searchResults.tbl_brands_id as brandId,
    sum(searchResults.total_count) as totalCount,
    brand.brand_name as brandName,
    brand.brand_logo As brand_logo,
    searchResults.country_id As countryId,
    searchResults.region_id As searchRegionId,
    region.id As regionId,
    region.name As regionName,
    region.latitude As latitude,
    region.longitude As longitude
    FROM tbl_search_results as searchResults,
    tbl_brands as brand,regions as region 
    WHERE brand.id = searchResults.tbl_brands_id 
    AND brand.id = '".$brandId."' 
        AND searchResults.region_id = region.id 
         AND searchResults.country_id = '".$countryId."' 
        AND searchResults.date_on = '".$mysqldate."' 
             AND searchResults.search_source NOT IN('facebook.com','twitter.com')
            GROUP BY regionId ORDER BY totalCount Desc";


$RS_TOP_REGION  = mysql_query($SQL_TOP_REGION) or die(mysql_error());


while($ROW_TOP_REGION = mysql_fetch_array($RS_TOP_REGION)){
    $objRegion = new stdClass();
    $objRegion->brandId = $ROW_TOP_REGION['brandId'];
    $objRegion->totalCount = $ROW_TOP_REGION['totalCount'];
    $objRegion->totalCountInPercentage = round((($ROW_TOP_REGION['totalCount']/$TOTAL_COUNT)*100),5);
    $objRegion->brandName = $ROW_TOP_REGION['brandName'];
    $objRegion->brandLogo = $ROW_TOP_REGION['brand_logo'];
    $objRegion->countryId = $ROW_TOP_REGION['countryId'];
    $objRegion->regionId = $ROW_TOP_REGION['regionId'];
    $objRegion->regionName = $ROW_TOP_REGION['regionName'];
    $objRegion->latitude = $ROW_TOP_REGION['latitude'];
    $objRegion->longitude = $ROW_TOP_REGION['longitude'];
    
    array_push($arrTopRegionResults, $objRegion);
}


$memCacheKey = "state_".$brandId."_".$countryId;
$memcache->set($memCacheKey, $arrTopRegionResults);

        print("cache added to state $memCacheKey \n");
        
    }
    
    
    
}
?>