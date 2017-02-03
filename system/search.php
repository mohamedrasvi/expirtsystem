<?php 
include('config/db_con.php');
include 'includes/auth.php';
$currentDate = date('Y-m-d H:i:s');

$mysqldate = REPORT_DATE;
$searchQueryOriginal = $_GET['q'];
$searchQuery = mysql_escape_string($searchQueryOriginal);
$isRecordFound = 'No';

$SQL_TOP_BRANDS = "SELECT sum(total_count) as total_count,brand_name,brand_logo,brand_id FROM tbl_search_result_country WHERE report_date = '".$mysqldate."' AND brand_id IN(SELECT id FROM tbl_brands WHERE brand_tags LIKE '".'%'.$searchQuery.'%'."' OR brand_name LIKE '".'%'.$searchQuery.'%'."') GROUP BY brand_id ORDER BY total_count Desc";
$RS_TOP_BRANDS  = mysql_query($SQL_TOP_BRANDS) or die(mysql_error());

$arrTopBrands = array();
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
    $isRecordFound = 'Yes';
}

// insert the search log information....
$userId = $_SESSION['userId'];
$remoteIp = $_SERVER['REMOTE_ADDR'];
$SQL_SEARCH_LOG = "INSERT INTO tbl_search_logs(searched_by,ip_address,date_and_time,search_key,results_found) VALUES('".$userId."','".$remoteIp."','".$currentDate."','".  mysql_escape_string($searchQuery)."','".$isRecordFound."')";
$INSERT_SEARCH_LOG = mysql_query($SQL_SEARCH_LOG) or die(mysql_error());

$isProcessing = '';
if($isRecordFound != 'Yes'){
    
    // search the status only in that brand table....
    $SQL_BRAND_SEARCH_PRO = "SELECT count(id) As totalPbrands FROM tbl_brands WHERE (brand_name LIKE '%$searchQuery%' OR brand_tags LIKE '%$searchQuery%')";
    $RS_BRAND_SEARCH_PRO  = mysql_query($SQL_BRAND_SEARCH_PRO) or die(mysql_error());
    $ROW_BARND_PROCESSING = mysql_fetch_assoc($RS_BRAND_SEARCH_PRO);
    $total_count_proccessing = $ROW_BARND_PROCESSING['totalPbrands'];
    if($total_count_proccessing>0){
        $isProcessing = 'Yes';
    }
}

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
                        <li><a href="index.html"><i class="icon-home"></i></a></li>
                        <li class="active"><a href="">Top Brands</a></li>
                    </ul>
                    <!-- END Navigation info -->




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

                        <div class="row-fluid grid-boxes">
                            
                            <?php 
                            if(count($arrTopBrands)>0){
                            foreach($arrTopBrands As $bIndex=>$topBrand){ ?>
                            
                            <?php if($bIndex%4 == 0){?>
                            <div class="clear"></div>
                            <?php } ?>
                                <div class="span3">
                                  
                                     <p><code><?php print(convertToK($topBrand->totalCount));?> k</code></p>
                                    <a href="country.php?id=<?php print($topBrand->brandId);?>&brand=<?php print($topBrand->brandName);?>">
                                <p>
                                    <?php if(isFileExist($topBrand->brandLogo)){?>
                                    <img src="contents/logos/<?php print($topBrand->brandLogo);?>" />
                                    <?php } else {?>
                                    <img src="http://www.directbeautysupplies.co.uk/includes/tng/styles/img_not_found.gif" />
                                    <?php } ?>
                                </p>
                                </a>
                                    
                                    <p><?php print($topBrand->numberOfCountry);?> Countries</p>
                                    
                                    
                                </div>
                            
                            
                            <?php } } elseif($isProcessing == 'Yes') {?>
                            
                            
                            <div class="col-md-10" style="text-align: center;padding-left: 50px;padding-right:50px;">
                            
                                <div class=" error-container">
<div class="error-code"><i class="fa fa-exclamation-triangle"></i><?php print($searchQueryOriginal);?></div>
<div class="error-text">Processing! <strong>The brand is on processing. Please try again later.</strong>!</div>
</div>
                                
                                
                                
                            </div>
                            
                            <?php } else {?>
                            
                            <div class="col-md-10" style="text-align: center;padding-left: 50px;padding-right:50px;">
                            
                                <div class=" error-container">
<div class="error-code"><i class="fa fa-exclamation-triangle"></i><?php print($searchQueryOriginal);?></div>
<div class="error-text">Ooops.. <strong>Records not found</strong>!</div>
<div class="error-text">This brand name not existing do you wanna get marketing data for this search brand ?</div>


<BR/>

                                
                                 <a href="<?php print($siteBaseUrl);?>new-brand.php?key=<?php print($searchQueryOriginal);?>" class="btn btn-success">Yes</a> 
                                 <a href="<?php print($siteBaseUrl);?>" class="btn btn-inverse">No</a>
</div>
                                
                                
                                
                            </div>

                            <?php } ?>
                    </div>


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

    </body>
</html>