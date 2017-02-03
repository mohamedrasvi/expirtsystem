<?php 
include('config/db_con.php');
include 'includes/auth.php';

$brandId = $_GET['id'];
$brandName = $_GET['brand'];
$countryId = $_GET['cId'];

$topBrandInSector = "";
$topBrandInAllSector = "";

$SQL_BRAND_SECTOR = "SELECT name FROM tbl_sector WHERE id IN (SELECT sector FROM tbl_brands WHERE id = '".$brandId."')";
$RS_BRAND_SECTOR = mysql_query($SQL_BRAND_SECTOR) or die(mysql_error());
$BRAND_SECTOR_INFO = mysql_fetch_assoc($RS_BRAND_SECTOR);
$SECTOR_NAME = $BRAND_SECTOR_INFO['name'];

$mysqldate = REPORT_DATE;
$arrTopRegionResults = array();


//if ($cacheAvailable == true)
//{
//    $memCacheKey = "state_".$brandId."_".$countryId;
//    $arrTopRegionResults = $memcache->get($memCacheKey);
//}


$SQL_COUNTRY = "SELECT * FROM countries WHERE id = '".$countryId."'";
$RS_COUNTRY = mysql_query($SQL_COUNTRY) or die(mysql_error());
$ROW_COUNTRY_NAME = mysql_fetch_assoc($RS_COUNTRY);

$country_name = $ROW_COUNTRY_NAME['name'];
$country_latitude = $ROW_COUNTRY_NAME['latitude'];
$country_longitude = $ROW_COUNTRY_NAME['longitude'];


$arrTopRegionResults = array();
$SQL_TOP_REGION_SEARCH = "SELECT * FROM tbl_search_result_region WHERE report_date = '".$mysqldate."' AND brand_id = '".$brandId."' AND country_id = '".$countryId."' ORDER BY total_count Desc";
$RS_TOP_REGION_SEARCH  = mysql_query($SQL_TOP_REGION_SEARCH) or die(mysql_error());


while($ROW_TOP_REGION_SEARCH = mysql_fetch_array($RS_TOP_REGION_SEARCH)){
    $objRegion = new stdClass();
    $objRegion->brandId = $ROW_TOP_REGION_SEARCH['brand_id'];
    $objRegion->totalCount = $ROW_TOP_REGION_SEARCH['total_count'];
    $objRegion->totalCountInPercentage = $ROW_TOP_REGION_SEARCH['count_in_persentage'];
    $objRegion->brandName = formateUrlString($ROW_TOP_REGION_SEARCH['brand_name']);
    $objRegion->brandLogo = $ROW_TOP_REGION_SEARCH['brand_logo'];
    $objRegion->countryId = $ROW_TOP_REGION_SEARCH['country_id'];
    $objRegion->regionId = $ROW_TOP_REGION_SEARCH['region_id'];
    $objRegion->regionName = formateUrlString($ROW_TOP_REGION_SEARCH['region_name']);
    $objRegion->latitude = $ROW_TOP_REGION_SEARCH['region_latitude'];
    $objRegion->longitude = $ROW_TOP_REGION_SEARCH['region_longitude'];
    $objRegion->clickable = 'Yes';
    
    array_push($arrTopRegionResults, $objRegion);
}



// get the brand information....
$SQL_BRAND_INFO = "SELECT * FROM tbl_brands WHERE id = '".$brandId."'";
$RS_BRAND_INFO = mysql_query($SQL_BRAND_INFO) or die(mysql_error());
$ROW_BRAND_INFO = mysql_fetch_assoc($RS_BRAND_INFO);
$brand_sector_id = $ROW_BRAND_INFO['sector']; 



//*********** GET THE TOP 20 RELATED BRANDS ****************
$SQL_RELATED_TOP_BRANDS = "SELECT sum(total_count) as total_count,brand_name,brand_logo,brand_id FROM tbl_search_result_country WHERE report_date = '".$mysqldate."' AND sector = '".$brand_sector_id."' AND country_id = '".$countryId."' GROUP BY brand_id ORDER BY total_count Desc LIMIT 0,15";
$RS_RELATED_TOP_BRANDS  = mysql_query($SQL_RELATED_TOP_BRANDS) or die(mysql_error());
$arrRelatedTopBrands = array();
$top_state_index = 1;
while($ROW_RELATED_TOP_BRANDS = mysql_fetch_array($RS_RELATED_TOP_BRANDS)){
    $objTopBrand = new stdClass();
    $objTopBrand->brandId = $ROW_RELATED_TOP_BRANDS['brand_id'];
    $objTopBrand->brandName = $ROW_RELATED_TOP_BRANDS['brand_name'];
    $objTopBrand->brandLogo = $ROW_RELATED_TOP_BRANDS['brand_logo'];
    $objTopBrand->totalCount = $ROW_RELATED_TOP_BRANDS['total_count'];
    
    $SQL_COUNT_REGION = "SELECT count(DISTINCT region_id) as totalRegion FROM tbl_search_result_region WHERE report_date = '".$mysqldate."' AND brand_id = '".$ROW_RELATED_TOP_BRANDS['brand_id']."' AND country_id = '".$countryId."'";
    $RS_COUNT_REGION  = mysql_query($SQL_COUNT_REGION) or die(mysql_error());
    $ROW_COUNT_REGION = mysql_fetch_assoc($RS_COUNT_REGION);
    $objTopBrand->numberOfRegion = $ROW_COUNT_REGION['totalRegion'];
    array_push($arrRelatedTopBrands, $objTopBrand);
    
    if($top_state_index == 1){
                $topBrandInSector = $objTopBrand;
         }
         
    $top_state_index = $top_state_index + 1;
}

//*********** END GET THE TOP 20 RELATED BRANDS ************



// *********** GET THE TOP 20 BRANDS ************************

$SQL_TOP_BRANDS = "SELECT sum(total_count) as total_count,brand_name,brand_logo,brand_id FROM tbl_search_result_country WHERE report_date = '".$mysqldate."' AND country_id = '".$countryId."' GROUP BY brand_id ORDER BY total_count Desc LIMIT 0,15";
$RS_TOP_BRANDS  = mysql_query($SQL_TOP_BRANDS) or die(mysql_error());

$arrTopBrands = array();
$top_brand_index = 1;
while($ROW_TOP_BRANDS = mysql_fetch_array($RS_TOP_BRANDS)){
    $objTopBrand = new stdClass();
    $objTopBrand->brandId = $ROW_TOP_BRANDS['brand_id'];
    $objTopBrand->brandName = $ROW_TOP_BRANDS['brand_name'];
    $objTopBrand->brandLogo = $ROW_TOP_BRANDS['brand_logo'];
    $objTopBrand->totalCount = $ROW_TOP_BRANDS['total_count'];
    
    $SQL_COUNT_REGION = "SELECT count(DISTINCT region_id) as totalRegion FROM `tbl_search_result_region` WHERE `brand_id` = '".$ROW_TOP_BRANDS['brand_id']."' AND report_date = '".$mysqldate."' AND country_id = '".$countryId."'";
    $RS_COUNT_REGION  = mysql_query($SQL_COUNT_REGION) or die(mysql_error());
    $ROW_COUNT_REGION = mysql_fetch_assoc($RS_COUNT_REGION);
    $objTopBrand->numberOfRegion = $ROW_COUNT_REGION['totalRegion'];
    array_push($arrTopBrands, $objTopBrand);
    
         if($top_brand_index == 1){
                $topBrandInAllSector = $objTopBrand;
         }
        $top_brand_index = $top_brand_index + 1;
}

//************ END GET TOP 20 BRANDS ***********************

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>Welcome to yegga.com - Corprate Branding</title>

        <meta name="description" content="Welcome to yegga.com - Corprate Branding">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">

        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="icon" href="<?php print($siteBaseUrl);?>favicon.ico" type="image/x-icon"/>
        
        <?php include('includes/assets.php'); ?>
    </head>

    <!-- Add the class .fixed to <body> for a fixed layout on large resolutions (min: 1200px) -->
    <!-- <body class="fixed"> -->
    <body>
        <!-- Page Container -->
        <div id="page-container">
            <!-- Header -->
            <!-- Add the class .navbar-fixed-top or .navbar-fixed-bottom for a fixed header on top or bottom respectively -->
            <!-- <header class="navbar navbar-inverse navbar-fixed-top"> -->
            <!-- <header class="navbar navbar-inverse navbar-fixed-bottom"> -->
           <?php include('includes/header.tpl'); ?>

            <!-- Inner Container -->
            <div id="inner-container"><!-- Sidebar -->

                <!-- END Sidebar -->
                <!-- Page Content -->
                <div id="page-content">
                    <!-- Navigation info -->
                    <ul id="nav-info" class="clearfix">
                        <li><a href="index.php"><i class="icon-home"></i></a></li>
                        <li><a href="index.php">Top Brands</a></li>
                        <li><a href="country.php?id=<?php print($brandId);?>&brand=<?php print($brandName);?>"><?php print($brandName);?></a></li>
                        <li class="active"><a href="#"><?php print($country_name);?></a></li>
                    </ul>
                    <!-- END Navigation info -->

<?php include('includes/brand_waiting_notification.php');?>


                    <!-- Google Maps -->
                    <div class="row-fluid">   
                        
                        <form id="searchform" name="searchform" method="get" action="search.php">
                        <div class="row-fluid grid-boxes">
                        <div class="span9">
                            <input type="text" name="q" id="q" style="width: 100%;" placeholder="Keywords..." tabindex="1">
                        </div>
                        <div class="span3">
                           <button id="searchBoxIcon" class="btn btn-success">
                                <i class="glyphicons white search"></i> 
                                Search
                            </button>
                        </div>
                    </div>
                            </form>

                        
                        
                             <table class="table mytable table-borderless">
                            <tbody>
                                <tr>                                               
                                    <td style="text-align: center;" >
                                        <h3>The "<?php print($topBrandInAllSector->brandName);?>" is the top brand in all the sectors.</h3>
                                    </td>                     
                               </tr>
                                <tr>                                               
                                    <td style="text-align: center;" >
                                        <h3>The "<?php print($topBrandInSector->brandName);?>" is the top brand in "<?php print($SECTOR_NAME);?>"</h3>
                                    </td>                     
                               </tr>
                                            </tbody> 
                                        </table>


                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="span3">
                                        
                                        <table class="table table-hover mytable table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="mybackground">
                                                        Related top brands
                                                    </th>
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                                
                                                
                                               <?php foreach($arrRelatedTopBrands As $tbIndex=>$topBrand){?>
                                                <tr>
                                                    <td>
                                                        
                                                        <div class="row-fluid grid-boxes myborder" <?php if($topBrand->brandId == $brandId){?> id="blink" <?php } ?>>
                                                            <div class="span6">
                                                                <a href="state.php?id=<?php print($topBrand->brandId);?>&brand=<?php print($topBrand->brandName);?>&cId=<?php print($countryId);?>">
                                                                 <?php print($tbIndex+1);?>.&nbsp;<img src="contents/logos/<?php print($topBrand->brandLogo);?>"  style="border:0px;" height="50px" width="50px;" />
                                                        </a>
                                                                
                                                            </div>
                                                             <div class="span6">
                                                                <?php print($topBrand->brandName);?> Brand
                                                             </div>
                                                            <div class="clear"></div>
                                                            <div class="span12">
                                                                &ldquo;<?php print(convertToK($topBrand->totalCount));?> K&ldquo; in <?php print($topBrand->numberOfRegion);?> regions
                                                             </div>
                                                            
                                                        </div>
                                                    </td>
                                                </tr>
                                                 <?php } ?>
                                                
                                                
                                                
                                                
                                            </tbody>
                                            
                                        </table>
                                        
                                        
                                        
                                        
                                    
                                    
                                    </td>
                                    <td>



                                        <!-- Google Maps General Tile -->
                                        <div class="dash-tile dash-tile-dark no-opacity">
                                            <div class="dash-tile-content">
                                                <div id="example-gmap-general" class="gmap-con"></div>
                                            </div>
                                        </div>
                                        <!-- END Google Maps General Tile -->



                                    </td>
                                    <td class="span3">
                                        
                                     
                                        
                                         <table class="table table-hover mytable table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="mybackground">
                                                        Top Brands
                                                    </th>
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                                
                                                
                                                <?php foreach($arrTopBrands As $tbIndex=>$topBrand){?>
                                                <tr>
                                                    <td>
                                                        
                                                        <div class="row-fluid grid-boxes myborder">
                                                            <div class="span6">
                                                                <a href="state.php?id=<?php print($topBrand->brandId);?>&brand=<?php print($topBrand->brandName);?>&cId=<?php print($countryId);?>">
                                                                    <?php print($tbIndex+1);?>.&nbsp;<img src="contents/logos/<?php print($topBrand->brandLogo);?>"  style="border:0px;" height="50px" width="50px;" />
                                                        </a>
                                                                
                                                            </div>
                                                             <div class="span6">
                                                                <?php print($topBrand->brandName);?> Brand
                                                             </div>
                                                            <div class="clear"></div>
                                                            <div class="span12">
                                                                &ldquo;<?php print(convertToK($topBrand->totalCount));?> K&ldquo; in <?php print($topBrand->numberOfRegion);?> regions
                                                             </div>
                                                            
                                                        </div>
                                                    </td>
                                                </tr>
                                                 <?php } ?>
                                                
                                                
                                                
                                                
                                            </tbody>
                                            
                                        </table>
                                        
                                    
                                    
                                    
                                    </td>                                    
                                </tr>
                            </tbody>

                        </table>


           
                        
                    


                    </div>



                    <!-- END Google Maps -->
                </div>
                <!-- END Page Content -->

                <?php include('includes/footer.tpl'); ?>
            </div>
            <!-- END Inner Container -->
        </div>
        <!-- END Page Container -->

        <!-- Scroll to top link, check main.js - scrollToTop() -->
        <a href="#" id="to-top"><i class="icon-chevron-up"></i></a>

         <script src="contents/front/js/helpers/jqvmap.maps.js"></script>

        <!-- Javascript code only for this page -->
        <script>
           // var map;
            $(function() {
                // Default Maps Height
                var mapHeight = '400px';

                // Set default height to all Google Maps Containers
                $('#example-gmap-general')
                .css('height', mapHeight);

                map = new GMaps({
                    div: '#example-gmap-general',
                    lat: <?php print($country_latitude);?>,
                    lng: <?php print($country_longitude);?>,
                    zoom: 4
                });
      
      
            // loop this using php....
               

<?php 
if($arrTopRegionResults){
foreach($arrTopRegionResults As $tIndex=>$topRegionResult){?>
        
         map.drawOverlay({
                     lat: <?php print($topRegionResult->latitude);?>,
                    lng: <?php print($topRegionResult->longitude);?>,
                    content: '<div class="overlay"><?php print(rfloor($topRegionResult->totalCountInPercentage,2));?>%</div>',
                    verticalAlign: 'top',
                    horizontalAlign: 'center'
                });
        
                map.addMarkers([
                    {lat: <?php print($topRegionResult->latitude);?>, lng: <?php print($topRegionResult->longitude);?>, title: '55%',  infoWindow: {
                        content: '<div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<h1 id="firstHeading" class="firstHeading"><?php print($topRegionResult->brandName);?></h1>'+
      '<h1 id="firstHeading" class="firstHeading"><?php print(convertToK($topRegionResult->totalCount));?>k (<?php print(rfloor($topRegionResult->totalCountInPercentage,2));?>%)</h1>'+
      '<div id="bodyContent">'+
      "<p> Click on the follwing link to see the <b><?php print($topRegionResult->brandName);?></b>&#180;s popularity in <b>this area</b></p><p>" +
       <?php if($topRegionResult->clickable == 'Yes'){?>
      "<a href='state_results.php?id=<?php print($topRegionResult->brandId);?>&brand=<?php print($topRegionResult->brandName);?>&cId=<?php print($topRegionResult->countryId);?>&sId=<?php print($topRegionResult->regionId);?>'>"+
      "popularity in <b>this area</b></a>"+
       <?php } ?>
      '<BR/>(Generated on <?php print(date('l, F d y',strtotime($mysqldate)));?>).</p>'+
      '</div>'+
      '</div>'
                    }}
                ]);
                <?php }} ?>
            // loop ends.....
                
            });
        </script>
    </body>
</html>