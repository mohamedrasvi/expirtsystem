<?php 
include('config/db_con.php');
include 'includes/auth.php';

$brandId = $_GET['id'];
$brandName = $_GET['brand'];
$countryId = $_GET['cId'];
$regionId = $_GET['sId'];

$SQL_REGION_RESULTS = "SELECT sr.result_from_link_domain_name as domainId,domains.domain_name as domainName,sum(sr.total_count) As total_count,sr.region_id as region FROM tbl_search_results As sr,tbl_domains as domains WHERE sr.region_id = '".$regionId."' AND sr.tbl_brands_id = '".$brandId."' AND sr.result_from_link_domain_name = domains.id  GROUP BY domainname ORDER BY total_count Desc";
//print($SQL_TOP_COUNTRY);exit;
$RS_REGION_RESULTS  = mysql_query($SQL_REGION_RESULTS) or die(mysql_error());

?>
<!doctype html>
<html lang="en-US">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <title>Welcome to yegga.com</title>
        <meta name="author" content="yegga.com">

        <link rel="stylesheet" type="text/css" media="all" href="contents/styles.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        
        
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
				$('.scroll-pane').jScrollPane();
			});
		</script>
        
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
                           
                            <div class="scroll-pane">
                            <table>
		<thead>
		<tr>
                    <th id="source_name">Region/State Name</th>
                    <th id="source_results">Rating</th>
			
		</tr>
		</thead>
		<tbody>
                    
                    <?php 
                    $final_total = 0;
                    while($row_region_results = mysql_fetch_array($RS_REGION_RESULTS)){?>
		<tr>
			<td>
                            <a href="http://<?php print($row_region_results['domainName']);?>" target="_blank">
                            <?php print($row_region_results['domainName']);?>
                            </a>
                        </td>
			<td><?php print($row_region_results['total_count']);?></td>
			
		</tr>
                <?php 
                $final_total = $final_total + $row_region_results['total_count'];
                } ?>
                
		
                <tr>
			<td></td>
			<td><?php print($final_total);?></td>
			
		</tr>
                
		
		</tbody>
	</table>
                       </div>     
                            
                       </div>
                    </div>


                </div>

            </div><!-- @end #content -->
        </div><!-- @end #w -->
        
         <?php include('includes/footer.tpl'); ?>
    </body>
</html>
