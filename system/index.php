<?php 
include('config/db_con.php');
include 'includes/auth.php';


$mysqldate = REPORT_DATE;
$arrTopBrands = array();


    $arrTopBrands = array();
    $SQL_TOP_BRANDS = "SELECT sum(total_count) as total_count,brand_name,brand_logo,brand_id FROM tbl_search_result_country WHERE report_date = '".$mysqldate."' GROUP BY brand_id ORDER BY total_count Desc";
    $RS_TOP_BRANDS  = mysql_query($SQL_TOP_BRANDS) or die(mysql_error());

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
                        <li><a href="index.php"><i class="icon-home"></i></a></li>
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
                            
                            <?php foreach($arrTopBrands As $bIndex=>$topBrand){ ?>
                            
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