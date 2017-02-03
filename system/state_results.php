<?php 
include('config/db_con.php');
include 'includes/auth.php';

$brandId = $_GET['id'];
$brandName = $_GET['brand'];
$countryId = $_GET['cId'];
$regionId = $_GET['sId'];

$mysqldate = REPORT_DATE;

// the country information....
$SQL_COUNTRY = "SELECT * FROM countries WHERE id = '".$countryId."'";
$RS_COUNTRY = mysql_query($SQL_COUNTRY) or die(mysql_error());
$ROW_COUNTRY_NAME = mysql_fetch_assoc($RS_COUNTRY);
$country_name = $ROW_COUNTRY_NAME['name'];

$SQL_REGION = "SELECT * FROM regions WHERE id = '".$regionId."'";
$RS_REGION = mysql_query($SQL_REGION) or die(mysql_error());
$ROW_REGION_NAME = mysql_fetch_assoc($RS_REGION);
$region_name = $ROW_REGION_NAME['name'];

if($regionId != 'NA'){
$SQL_REGION_RESULTS = "SELECT * FROM tbl_search_results WHERE region_id = '".$regionId."' AND tbl_brands_id = '".$brandId."' AND date_on = '".$mysqldate."' AND search_source NOT IN('facebook.com','twitter.com') ORDER BY total_count Desc,result_from_link_domain_name";
$RS_REGION_RESULTS  = mysql_query($SQL_REGION_RESULTS) or die(mysql_error());


$SQL_COUNTRY_RESULTS = "SELECT * FROM tbl_search_results WHERE region_id != '".$regionId."' AND country_id = '".$countryId."' AND tbl_brands_id = '".$brandId."' AND date_on = '".$mysqldate."' AND search_source NOT IN('facebook.com','twitter.com') ORDER BY total_count Desc,result_from_link_domain_name";
$RS_COUNTRY_RESULTS  = mysql_query($SQL_COUNTRY_RESULTS) or die(mysql_error());
} else {
    $SQL_COUNTRY_RESULTS = "SELECT * FROM tbl_search_results WHERE country_id = '".$countryId."' AND tbl_brands_id = '".$brandId."' AND date_on = '".$mysqldate."' AND search_source NOT IN('facebook.com','twitter.com') ORDER BY total_count Desc,result_from_link_domain_name";
$RS_COUNTRY_RESULTS  = mysql_query($SQL_COUNTRY_RESULTS) or die(mysql_error());
}

$SQL_WORLD_RESULTS = "SELECT * FROM tbl_search_results WHERE country_id != '".$countryId."' AND tbl_brands_id = '".$brandId."' AND date_on = '".$mysqldate."' AND search_source NOT IN('facebook.com','twitter.com') ORDER BY total_count Desc,result_from_link_domain_name";
$RS_WORLD_RESULTS  = mysql_query($SQL_WORLD_RESULTS) or die(mysql_error());

// count facebook .....
//$SQL_FACEBOOK = "SELECT sum(total_count) As tot FROM tbl_search_results WHERE search_source = 'facebook.com' AND tbl_brands_id = '".$brandId."' AND date_on='".$mysqldate."'";
//$RS_TOP_FACEBOOK  = mysql_query($SQL_FACEBOOK) or die(mysql_error());
//$ROW_TOP_FACEBOOK = mysql_fetch_assoc($RS_TOP_FACEBOOK);
$TOTAL_FACEBOOK   = 0;


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
        
        <link type="text/css" href="http://jscrollpane.kelvinluck.com/style/jquery.jscrollpane.css" rel="stylesheet" media="all" />
		<style type="text/css" id="page-css">
			/* Styles specific to this particular page */
			.scroll-pane
			{
				width: 100%;
				height: 300px;
				overflow: auto;
			}
			.horizontal-only
			{
				height: auto;
				max-height: 200px;
			}
		</style>

		<!-- latest jQuery direct from google's CDN -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<!-- the mousewheel plugin -->
		<script type="text/javascript" src="http://jscrollpane.kelvinluck.com/script/jquery.mousewheel.js"></script>
		<!-- the jScrollPane script -->
		<script type="text/javascript" src="http://jscrollpane.kelvinluck.com/script/jquery.jscrollpane.min.js"></script>

		<script type="text/javascript" id="sourcecode">
			$(function()
			{
				//$('#scroll-pane').jScrollPane();
                                //$('#scroll-pane_country').jScrollPane();
                               // $('#scroll-pane_world').jScrollPane();
			});
		</script>
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
                        <li class="active"><a href="#">Website Links</a></li>
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
                        
                        
                                        <?php if(mysql_num_rows($RS_REGION_RESULTS)>0){?>
                                        <div id="scroll-pane">
                                            
                                            <form name="form1" id="form1" method="post" action="complain.php">
                                            <table class="table table-bordered table-hover">
		<thead>
		<tr>
                    <th id="source_name">Website Links in <?php print($region_name);?></th>
                    <th id="source_results">Rating</th>
			
		</tr>
		</thead>
		<tbody>
                    
                    <?php 
                    $final_total = 0;
                    while($row_region_results = mysql_fetch_array($RS_REGION_RESULTS)){?>
		<tr>
			<td>
                            <input type="checkbox" name="chkLink[]" value="<?php print($row_region_results['id']);?>"/>&nbsp;&nbsp;
                            <a href="<?php print($row_region_results['result_link']);?>" target="_blank">
                            <?php print($row_region_results['result_link']);?>
                            </a>
                        </td>
			<td><?php print($row_region_results['total_count']);?></td>
			
		</tr>
                <?php 
                $final_total = $final_total + $row_region_results['total_count'];
                } ?>
                
		
                <tr>
                    <th id="source_name">Total </th>
                    <th id="source_results"><?php print($final_total);?></th>
			
		</tr>
                
		
		</tbody>
	</table>
                                                
                                                
                                                
                                                <button class="btn btn-danger"><i class="icon-remove"></i> Complain about the link</button>
                                                </form>
                       </div>  
                         <BR/>
                        <BR/>
                        <BR/>
                         <?php } ?>               
                                    
                                    
                                    
                                  

                        
                   
                       
                        <div id="scroll-pane_country">
                                            
                                            <form name="form1" id="form1" method="post" action="complain.php">
                                            <table class="table table-bordered table-hover">
		<thead>
		<tr>
                    <th id="source_name">Other website Links in <?php print($country_name);?> </th>
                    <th id="source_results">Rating</th>
			
		</tr>
		</thead>
		<tbody>
                    
                    <?php 
                    $final_total = 0;
                    while($row_region_results = mysql_fetch_array($RS_COUNTRY_RESULTS)){?>
		<tr>
			<td>
                            <input type="checkbox" name="chkLink[]" value="<?php print($row_region_results['id']);?>"/>&nbsp;&nbsp;
                            <a href="<?php print($row_region_results['result_link']);?>" target="_blank">
                            <?php print($row_region_results['result_link']);?>
                            </a>
                        </td>
			<td><?php print($row_region_results['total_count']);?></td>
			
		</tr>
                <?php 
                $final_total = $final_total + $row_region_results['total_count'];
                } ?>
                
		
                
                
		<tr>
            
                    <th colspan="2"><button class="btn btn-danger"><i class="icon-remove"></i> Complain about the link</button></th>
			
		</tr>
		</tbody>
	</table>
                                                
                                                
                                                
                                           
                                                </form>
                       </div>     
                        
                        
                        
                        
                        
                             <BR/>
                        <BR/>
                        <BR/>
                        <div id="scroll-pane_world">
                                            
                                            <form name="form1" id="form1" method="post" action="complain.php">
                                            <table class="table table-bordered table-hover">
		<thead>
		<tr>
                    <th id="source_name">Other website Links in other country </th>
                    <th id="source_results">Rating</th>
			
		</tr>
		</thead>
		<tbody>
                    
                    <?php 
                    $final_total = 0;
                    while($row_region_results = mysql_fetch_array($RS_WORLD_RESULTS)){?>
		<tr>
			<td>
                            <input type="checkbox" name="chkLink[]" value="<?php print($row_region_results['id']);?>"/>&nbsp;&nbsp;
                            <a href="<?php print($row_region_results['result_link']);?>" target="_blank">
                            <?php print($row_region_results['result_link']);?>
                            </a>
                        </td>
			<td><?php print($row_region_results['total_count']);?></td>
			
		</tr>
                <?php 
                $final_total = $final_total + $row_region_results['total_count'];
                } ?>
                
		
                
                <tr>
            
                    <th colspan="2"><button class="btn btn-danger"><i class="icon-remove"></i> Complain about the link</button></th>
			
		</tr>
		
		</tbody>
	</table>
                                                
                                                
                                                
                                                
                                                </form>
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