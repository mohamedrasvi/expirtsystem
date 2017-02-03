<?php 
include('config/db_con.php');

$mysqldate = REPORT_DATE;
$topBrandInSector = "";
$topBrandInAllSector = "";

$brandId = $_GET['id'];
$brandName = $_GET['brand'];

$SQL_BRAND_SECTOR = "SELECT name FROM tbl_sector WHERE id IN (SELECT sector FROM tbl_brands WHERE id = '".$brandId."')";
$RS_BRAND_SECTOR = mysql_query($SQL_BRAND_SECTOR) or die(mysql_error());
$BRAND_SECTOR_INFO = mysql_fetch_assoc($RS_BRAND_SECTOR);
$SECTOR_NAME = $BRAND_SECTOR_INFO['name'];



$arrTopCountryResults = array();


$SQL_TOP_COUNTRY = "SELECT * FROM tbl_search_result_country WHERE report_date = '".$mysqldate."' AND brand_id = '".$brandId."' ORDER BY total_count Desc";
$RS_TOP_COUNTRY  = mysql_query($SQL_TOP_COUNTRY) or die(mysql_error());


while($ROW_TOP_COUNTRY = mysql_fetch_array($RS_TOP_COUNTRY)){
    $objCountry = new stdClass();
    $objCountry->brandId = $ROW_TOP_COUNTRY['brand_id'];
    $objCountry->totalCount = $ROW_TOP_COUNTRY['total_count'];
    $objCountry->totalCountInPercentage = $ROW_TOP_COUNTRY['count_in_persentage'];
    $objCountry->brandName = $ROW_TOP_COUNTRY['brand_name'];
    $objCountry->brandLogo = $ROW_TOP_COUNTRY['brand_logo'];
    $objCountry->countryId = $ROW_TOP_COUNTRY['country_id'];
    $objCountry->countryName = $ROW_TOP_COUNTRY['country_name'];
    $objCountry->countryLogo = $ROW_TOP_COUNTRY['country_logo'];
    $objCountry->latitude = $ROW_TOP_COUNTRY['country_latitude'];
    $objCountry->longitude = $ROW_TOP_COUNTRY['country_longitude'];
    $objCountry->rank = $ROW_TOP_COUNTRY['rank'];
    
    
    $SQL_TOP_REGION = "SELECT count(id) as tot FROM tbl_search_result_region WHERE report_date = '".$mysqldate."' AND brand_id = '".$brandId."' AND country_id = '".$ROW_TOP_COUNTRY['country_id']."'";
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





    $arrRelatedTopBrands = array();
    // get the brand information....
    $SQL_BRAND_INFO = "SELECT * FROM tbl_brands WHERE id = '".$brandId."'";
    $RS_BRAND_INFO = mysql_query($SQL_BRAND_INFO) or die(mysql_error());
    $ROW_BRAND_INFO = mysql_fetch_assoc($RS_BRAND_INFO);
    $brand_sector_id = $ROW_BRAND_INFO['sector']; 


    //*********** GET THE TOP 20 RELATED BRANDS ****************
    $SQL_RELATED_TOP_BRANDS = "SELECT sum(total_count) as total_count,brand_name,brand_logo,brand_id FROM tbl_search_result_country WHERE report_date = '".$mysqldate."' AND sector = '".$brand_sector_id."' GROUP BY brand_id ORDER BY total_count Desc LIMIT 0,15";
    $RS_RELATED_TOP_BRANDS  = mysql_query($SQL_RELATED_TOP_BRANDS) or die(mysql_error());
    $top_country_index = 1;
    while($ROW_RELATED_TOP_BRANDS = mysql_fetch_array($RS_RELATED_TOP_BRANDS)){
        $objTopBrand = new stdClass();
        $objTopBrand->brandId = $ROW_RELATED_TOP_BRANDS['brand_id'];
        $objTopBrand->brandName = $ROW_RELATED_TOP_BRANDS['brand_name'];
        $objTopBrand->brandLogo = $ROW_RELATED_TOP_BRANDS['brand_logo'];
        $objTopBrand->totalCount = $ROW_RELATED_TOP_BRANDS['total_count'];

        $SQL_COUNT_COUNTRY = "SELECT count(DISTINCT country_id) as totalCountry FROM tbl_search_result_country WHERE report_date = '".$mysqldate."' AND brand_id = '".$ROW_RELATED_TOP_BRANDS['brand_id']."'";
        $RS_COUNT_COUNTRY  = mysql_query($SQL_COUNT_COUNTRY) or die(mysql_error());
        $ROW_COUNT_COUNTRY = mysql_fetch_assoc($RS_COUNT_COUNTRY);
        $objTopBrand->numberOfCountry = $ROW_COUNT_COUNTRY['totalCountry'];
        array_push($arrRelatedTopBrands, $objTopBrand);
         if($top_country_index == 1){
                $topBrandInSector = $objTopBrand;
         }
         $top_country_index = $top_country_index + 1;
    }


//*********** END GET THE TOP 20 RELATED BRANDS ************



// *********** GET THE TOP 20 BRANDS ************************


    $arrTopBrands = array();
    $SQL_TOP_BRANDS = "SELECT sum(total_count) as total_count,brand_name,brand_logo,brand_id FROM tbl_search_result_country WHERE report_date = '".$mysqldate."' GROUP BY brand_id ORDER BY total_count Desc LIMIT 0,15";
    $RS_TOP_BRANDS  = mysql_query($SQL_TOP_BRANDS) or die(mysql_error());

    $top_brand_index = 1;
    while($ROW_TOP_BRANDS = mysql_fetch_array($RS_TOP_BRANDS)){
        $objTopBrand = new stdClass();
        $objTopBrand->brandId = $ROW_TOP_BRANDS['brand_id'];
        $objTopBrand->brandName = $ROW_TOP_BRANDS['brand_name'];
        $objTopBrand->brandLogo = $ROW_TOP_BRANDS['brand_logo'];
        $objTopBrand->totalCount = $ROW_TOP_BRANDS['total_count'];

        $SQL_COUNT_COUNTRY = "SELECT count(DISTINCT country_id) as totalCountry FROM `tbl_search_result_country` WHERE `brand_id` = '".$ROW_TOP_BRANDS['brand_id']."' AND report_date = '".$mysqldate."'";
        $RS_COUNT_COUNTRY  = mysql_query($SQL_COUNT_COUNTRY) or die(mysql_error());
        $ROW_COUNT_COUNTRY = mysql_fetch_assoc($RS_COUNT_COUNTRY);
        $objTopBrand->numberOfCountry = $ROW_COUNT_COUNTRY['totalCountry'];
        array_push($arrTopBrands, $objTopBrand);
        if($top_brand_index == 1){
                $topBrandInAllSector = $objTopBrand;
         }
        $top_brand_index = $top_brand_index + 1;
    }


//************ END GET TOP 20 BRANDS ***********************


// count facebook .....



    $SQL_FACEBOOK = "SELECT total_count FROM tbl_search_result_social_media WHERE media_source = 'Facebook' AND brand_id = '".$brandId."' AND report_date='".$mysqldate."'";
    $RS_TOP_FACEBOOK  = mysql_query($SQL_FACEBOOK) or die(mysql_error());
    $ROW_TOP_FACEBOOK = mysql_fetch_assoc($RS_TOP_FACEBOOK);
    $TOTAL_FACEBOOK   = $ROW_TOP_FACEBOOK['total_count'];


// count twitter


//$SQL_TWITTER = "SELECT sum(total_count) As tot FROM tbl_search_results WHERE search_source = 'twitter.com' AND tbl_brands_id = '".$brandId."' AND date_on='".$mysqldate."'";
//$RS_TOP_TWITTER  = mysql_query($SQL_TWITTER) or die(mysql_error());
//$ROW_TOP_TWITTER = mysql_fetch_assoc($RS_TOP_TWITTER);
$TOTAL_TWITTER   = 0;

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
                        <li class="active"><a href="#"><?php print($brandName);?></a></li>
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


                        
                              <table class="table mytable table-borderless socialNetworkRow">
                                            
                                            <tbody>
                                                
                                                
                                                <tr>
                                                    <?php if($TOTAL_FACEBOOK>0){?>
                                                    <td class="text-right">
                                                        <img src="contents/logos/facebook_icon.jpeg" />
                                                    </td>
                                                    <td class="text-left">
                                                       &nbsp;&nbsp;&nbsp;&nbsp;<h1><?php print(convertToK($TOTAL_FACEBOOK));?> K</h1>
                                                    </td>
                                                    <?php } ?>
                                                    
                                                    
                                                    <?php if($TOTAL_TWITTER>0){?>
                                                    <td class="text-right">
                                                        <img src="contents/logos/twitter-snow-sports-nz.jpg" />
                                                    </td>
                                                    <td class="text-left">
                                                       &nbsp;&nbsp;&nbsp;&nbsp;<h1><?php print(convertToK($TOTAL_TWITTER));?> K</h1>
                                                    </td>
                                                    <?php } ?>
                                                    
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
                                                                <a href="country.php?id=<?php print($topBrand->brandId);?>&brand=<?php print($topBrand->brandName);?>">
                                                                 <?php print($tbIndex+1);?>.&nbsp;<img src="contents/logos/<?php print($topBrand->brandLogo);?>"  style="border:0px;" height="50px" width="50px;" />
                                                        </a>
                                                                
                                                            </div>
                                                             <div class="span6">
                                                                <?php print($topBrand->brandName);?> Brand
                                                             </div>
                                                            <div class="clear"></div>
                                                            <div class="span12">
                                                                &ldquo;<?php print(convertToK($topBrand->totalCount));?> K&ldquo; in <?php print($topBrand->numberOfCountry);?> countries
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
                                                                <a href="country.php?id=<?php print($topBrand->brandId);?>&brand=<?php print($topBrand->brandName);?>">
                                                                    <?php print($tbIndex+1);?>.&nbsp;<img src="contents/logos/<?php print($topBrand->brandLogo);?>"  style="border:0px;" height="50px" width="50px;" />
                                                        </a>
                                                                
                                                            </div>
                                                             <div class="span6">
                                                                <?php print($topBrand->brandName);?> Brand
                                                             </div>
                                                            <div class="clear"></div>
                                                            <div class="span12">
                                                                &ldquo;<?php print(convertToK($topBrand->totalCount));?> K&ldquo; in <?php print($topBrand->numberOfCountry);?> countries
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
                var mapHeight = '600px';

                // Set default height to all Google Maps Containers
                $('#example-gmap-general')
                .css('height', mapHeight);

                map = new GMaps({
                    div: '#example-gmap-general',
                    lat: 36.7941,
                    lng: 12.0973,
                     zoomControl : false,
                     zoomControlOpt: {
            style : 'SMALL',
            position: 'TOP_LEFT'
        },
                    zoom: 2
                });
      
      
      // loop this using php....
      <?php foreach($arrTopCountryResults As $cIndex=>$countryRes){ ?>
                map.drawOverlay({
                    lat: <?php print($countryRes->latitude);?>,
                    lng: <?php print($countryRes->longitude);?>,
                    content: '<div class="overlay"><?php print(rfloor($countryRes->totalCountInPercentage,2));?>%</div>',
                    verticalAlign: 'top',
                    horizontalAlign: 'center'
                });

                map.addMarkers([
                    {lat: <?php print($countryRes->latitude);?>, lng: <?php print($countryRes->longitude);?>, title: '<?php print($countryRes->totalCountInPercentage);?>%',  infoWindow: {
                        content: '<div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<h1 id="firstHeading" class="firstHeading"><?php print($countryRes->brandName);?></h1>'+
      '<h1 id="firstHeading" class="firstHeading"><?php print(convertToK($countryRes->totalCount));?>k <?php print(rfloor($countryRes->totalCountInPercentage,2));?>%</h1>'+
      '<div id="bodyContent">'+
      '<p> Click on the follwing link to see the <b>"<?php print($countryRes->brandName);?>"</b>&#180;s popularity in <b><?php print($countryRes->countryName);?></b></p><p>' +
       <?php if($countryRes->clickable == 'Yes'){?>
      '<a href="state.php?id=<?php print($countryRes->brandId);?>&brand=<?php print($countryRes->brandName);?>&cId=<?php print($countryRes->countryId);?>">'+
      'popularity in <b><?php print($countryRes->countryName);?></b></a>'+
       <?php } else{ ?>
      "<a href='state_results.php?id=<?php print($countryRes->brandId);?>&brand=<?php print($countryRes->brandName);?>&cId=<?php print($countryRes->countryId);?>&sId=NA'>"+
      "popularity in <b>this area</b></a>"+
      <?php } ?>
      '<BR/>(Generated on <?php print(date('l, F d y',strtotime($mysqldate)));?>).</p>'+
      '</div>'+
      '</div>'
                    }}
                ]);
 <?php } ?>
            // loop ends.....
                
            });
        </script>
    </body>
</html>