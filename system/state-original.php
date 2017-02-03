<?php 
include('config/db_con.php');
include 'includes/auth.php';

$brandId = $_GET['id'];
$brandName = $_GET['brand'];
$countryId = $_GET['cId'];

$SQL_TOP_REGION = "SELECT sr.region_id As region_id,rg.name as regionName,sum(sr.total_count) As total_count,sr.tbl_brands_id As brandId FROM tbl_search_results As sr,regions as rg WHERE tbl_brands_id = '".$brandId."' AND rg.id=sr.region_id AND rg.country_id = '".$countryId."' GROUP BY sr.region_id ORDER BY total_count Desc";
//print($SQL_TOP_COUNTRY);exit;
$RS_TOP_REGION  = mysql_query($SQL_TOP_REGION) or die(mysql_error());

?>
<!doctype html>
<html lang="en-US">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <title>Welcome to yegga.com</title>
        <meta name="author" content="yegga.com">

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
                           
                            <table>
		<thead>
		<tr>
                    <th id="source_name">Region/State Name</th>
                    <th id="source_results">Rating</th>
                    <th id="source_results">View</th>
		</tr>
		</thead>
		<tbody>
                    
                    <?php 
                    $final_total = 0;
                    while($row_region = mysql_fetch_array($RS_TOP_REGION)){?>
		<tr>
			<td><?php print($row_region['regionName']);?></td>
			<td><?php print($row_region['total_count']);?></td>
			<td>
                            <a href="state_results.php?id=<?php print($brandId);?>&brand=<?php print($brandName);?>&cId=<?php print($countryId);?>&sId=<?php print($row_region['region_id']);?>">
                            View
                            </a>
                        </td>
		</tr>
                <?php 
                $final_total = $final_total + $row_region['total_count'];
                } ?>
                
		<tr>
			<td></td>
                        <td><strong> <?php print($final_total);?> </strong></td>
			<td></td>
		</tr>
                
                
		
		</tbody>
	</table>
                            
                            
                       </div>
                    </div>


                </div>

            </div><!-- @end #content -->
        </div><!-- @end #w -->
        
         <?php include('includes/footer.tpl'); ?>
    </body>
</html>
