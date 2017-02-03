<?php 
include('config/db_con.php');
include 'includes/auth.php';

$brandId = $_GET['id'];
$brandName = $_GET['brand'];
$countryId = $_GET['cId'];

$mysqldate = REPORT_DATE;

$SQL_COUNTRY = "SELECT * FROM countries WHERE id = '".$countryId."'";
$RS_COUNTRY = mysql_query($SQL_COUNTRY) or die(mysql_error());
$ROW_COUNTRY_NAME = mysql_fetch_assoc($RS_COUNTRY);

$country_latitude = $ROW_COUNTRY_NAME['latitude'];
$country_longitude = $ROW_COUNTRY_NAME['longitude'];


$SQL_BRAND_SUM = "SELECT sum(total_count) As total_count FROM tbl_search_results WHERE tbl_brands_id = '".$brandId."' AND country_id = '".$countryId."'";
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
            GROUP BY regionId ORDER BY totalCount Desc";


$RS_TOP_REGION  = mysql_query($SQL_TOP_REGION) or die(mysql_error());

$arrTopRegionResults = array();
while($ROW_TOP_REGION = mysql_fetch_array($RS_TOP_REGION)){
    $objRegion = new stdClass();
    $objRegion->brandId = $ROW_TOP_REGION['brandId'];
    $objRegion->totalCount = $ROW_TOP_REGION['totalCount'];
    $objRegion->totalCountInPercentage = round((($ROW_TOP_REGION['totalCount']/$TOTAL_COUNT)*100),2);
    $objRegion->brandName = $ROW_TOP_REGION['brandName'];
    $objRegion->brandLogo = $ROW_TOP_REGION['brand_logo'];
    $objRegion->countryId = $ROW_TOP_REGION['countryId'];
    $objRegion->regionId = $ROW_TOP_REGION['regionId'];
    $objRegion->regionName = $ROW_TOP_REGION['regionName'];
    $objRegion->latitude = $ROW_TOP_REGION['latitude'];
    $objRegion->longitude = $ROW_TOP_REGION['longitude'];
    
    array_push($arrTopRegionResults, $objRegion);
}


// get the brand information....
$SQL_BRAND_INFO = "SELECT * FROM tbl_brands WHERE id = '".$brandId."'";
$RS_BRAND_INFO = mysql_query($SQL_BRAND_INFO) or die(mysql_error());
$ROW_BRAND_INFO = mysql_fetch_assoc($RS_BRAND_INFO);
$brand_sector_id = $ROW_BRAND_INFO['sector']; 
// get top brands in this country for selected sector..........
$SQL_RELATED_BRANDS = "SELECT sr.region_id As region_id,rg.name as regionName,sum(sr.total_count) As total_count,sr.tbl_brands_id As brandId,b.brand_name As brand_name,b.brand_logo As brand_logo FROM tbl_search_results As sr,regions as rg,tbl_brands as b WHERE b.id = sr.tbl_brands_id AND tbl_brands_id != '".$brandId."' AND b.sector = '".$brand_sector_id."' AND rg.id=sr.region_id AND rg.country_id = '".$countryId."' GROUP BY sr.region_id ORDER BY total_count Desc";
//print($SQL_TOP_COUNTRY);exit;
$RS_RELATED_BRANDS  = mysql_query($SQL_RELATED_BRANDS) or die(mysql_error());

// get top brands in this country for selected sector..........
$SQL_TOP_BRANDS = "SELECT sr.country_id as countryId,c.name as countryName,c.country_logo as country_logo,sum(sr.total_count) As total_count,sr.tbl_brands_id As brandId,b.brand_name As brand_name,b.brand_logo As brand_logo FROM tbl_search_results As sr,countries as c,tbl_brands as b WHERE b.id = sr.tbl_brands_id AND c.id=sr.country_id GROUP BY country_id ORDER BY total_count Desc LIMIT 0,10";
$RS_TOP_BRANDS  = mysql_query($SQL_TOP_BRANDS) or die(mysql_error());

?>
<!DOCTYPE>
<html>
  <head>
     <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <title>Welcome to yegga.com</title>
        <meta name="author" content="yegga.com">
<link rel="stylesheet" type="text/css" media="all" href="contents/styles.css">
 <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
 <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/tags/markerwithlabel/1.1.8/src/markerwithlabel.js"></script>
 
 
     <script type="text/javascript">
      function initialize() {
        var center = new google.maps.LatLng(<?php print($country_latitude);?>,<?php print($country_longitude);?>);

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 5,
          center: center,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });


     <?php foreach($arrTopRegionResults As $cIndex=>$countryRes){ ?>
            google.maps.event.addListener(new MarkerWithLabel({
            position: new google.maps.LatLng(<?php print($countryRes->latitude);?>,<?php print($countryRes->longitude);?>),
            draggable: false,
            raiseOnDrag: true,
            map: map,
            url: "state_results.php?id=<?php print($countryRes->brandId);?>&brand=<?php print($countryRes->brandName);?>&cId=<?php print($countryRes->countryId);?>&sId=<?php print($countryRes->regionId);?>",
            labelContent: "<?php print($countryRes->totalCountInPercentage);?>%",
            labelAnchor: new google.maps.Point(22, 0),
            labelClass: "labels", // the CSS class for the label
            labelStyle: {opacity: 1.0}
                }), 'click', function() {
                    window.location.href = this.url;
                });
           <?php } ?>
       
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>

        <link rel="stylesheet" type="text/css" media="all" href="contents/styles.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    </head>

    <body>
       <?php include('includes/header.tpl'); ?>
        <div id="w">
            <div id="content">
                <h1><span>Corprate Branding</span></h1>

                <form id="searchform" name="searchform" method="get" action="search.php">
                    <div class="fieldcontainer">
                        <input type="text" name="q" id="q" class="searchfield" placeholder="Keywords..." tabindex="1">
                        <input type="submit" name="searchbtn" id="searchbtn" value=""> 
                    </div><!-- @end .fieldcontainer -->
                </form>

                <br><br>

                        <h1><span>The best in Country based on yegga ratings</span></h1>
                <p>We've picked out the results based on our rating in country. Click on a brand to see more detailed results.</p>

                <div class="fieldcontainer">



                    <div class="main">
                        <div class="inner">
                           <div class="container1">    
                                <div id="map-container"><div id="map"></div></div>
                           </div>
<div class="container2">

    <table>
	 <thead>
		<tr>
                    <th colspan="2">Related  Top Brands</th>
		</tr>
		</thead>
		<tbody>
                    
                    <?php while($relatedRows = mysql_fetch_array($RS_RELATED_BRANDS)){?>
                    <tr>
                        <td style="width: 30px;">
                            <a href="country.php?id=<?php print($relatedRows['brandId']);?>&brand=<?php print($relatedRows['brand_name']);?>">
                                <img src="contents/logos/<?php print($relatedRows['brand_logo']);?>" height="30" style="border:0px;"/>
                            </a>
                        </td>
                        <td class="related_tems_font"><?php print($relatedRows['brand_name']);?></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="related_tems_font"> &ldquo;<?php print(convertToK($relatedRows['total_count']));?> K&ldquo; in <?php print($relatedRows['regionName']);?></td>
                    </tr>
		<?php } ?>




		</tbody>
	</table>


</div>
                            
                            
                                                        <div class="container3">
                                
                           

    <table>
        
                <thead>
		<tr>
                    <th colspan="2">Top Brands</th>
		</tr>
		</thead>
	
		<tbody>
                    
                    <?php while($top_brands = mysql_fetch_array($RS_TOP_BRANDS)){?>
                    <tr>
                        <td style="width: 30px;">
                            <a href="country.php?id=<?php print($top_brands['brandId']);?>&brand=<?php print($top_brands['brand_name']);?>">
                                <img src="contents/logos/<?php print($top_brands['brand_logo']);?>" height="30" style="border: 0px;"/>
                            </a>
                        </td>
                        <td class="related_tems_font"><?php print($top_brands['brand_name']);?></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="related_tems_font"> 
                            &ldquo;<?php print(convertToK($top_brands['total_count']));?> K&ldquo; in 
                                <?php print($top_brands['countryName']);?> - 
                                <img src="contents/country/<?php print($top_brands['country_logo']);?>" height="15" /></td>
                    </tr>
		<?php } ?>




		</tbody>
	</table>


</div>
<div class="clear"></div>
                            
                            
                       </div>
                    </div>


                </div>

            </div><!-- @end #content -->
        </div><!-- @end #w -->
        
         <?php include('includes/footer.tpl'); ?>
    </body>
</html>
