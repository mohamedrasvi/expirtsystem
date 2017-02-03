<?php 
include('config/db_con.php');

$brandId = $_GET['id'];
$brandName = $_GET['brand'];

$SQL_TOP_COUNTRY = "SELECT sr.country_id as countryId,c.name as countryName,c.country_logo as country_logo,c.latitude as latitude,c.longitude as longitude,sum(sr.total_count) As total_count,sr.tbl_brands_id As brandId FROM tbl_search_results As sr,countries as c WHERE tbl_brands_id = '".$brandId."' AND c.id=sr.country_id GROUP BY country_id ORDER BY total_count Desc";
//print($SQL_TOP_COUNTRY);exit;
$RS_TOP_COUNTRY  = mysql_query($SQL_TOP_COUNTRY) or die(mysql_error());

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
                            
                            <?php while($TOP_ROW = mysql_fetch_array($RS_TOP_COUNTRY)){ ?>
                            
                            <div class="tile">
                                <p><?php print(convertToK($TOP_ROW['total_count']));?> k</p>
                                <a href="state.php?id=<?php print($TOP_ROW['brandId']);?>&brand=<?php print($brandName);?>&cId=<?php print($TOP_ROW['countryId']);?>">
                                <p><img src="contents/country/<?php print($TOP_ROW['country_logo']);?>" /> </p>
                                </a>
                                <p><?php print($TOP_ROW['countryName']);?></p>
                            </div>
                                
                            <?php } ?>
                            
                            
                           
                            
                            
                       </div>
                    </div>


                </div>

            </div><!-- @end #content -->
        </div><!-- @end #w -->
        
         <?php include('includes/footer.tpl'); ?>
    </body>
</html>
