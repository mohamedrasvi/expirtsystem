<?php 
include('config/db_con.php');
include 'includes/auth.php';

$searchQuery = $_GET['q'];

$SQL_TOP_BRANDS = "SELECT b.id as bid,b.brand_name as brandName,b.brand_logo As brandLogo,tb.total_results as totResults,tb.total_countries as totalCountry FROM tbl_top_brands AS tb,tbl_brands AS b WHERE b.id=tb.brand_id AND (b.brand_name LIKE '".'%'.$searchQuery.'%'."' OR b.brand_tags LIKE '".'%'.$searchQuery.'%'."') ORDER BY total_results desc";
$RS_TOP_BRANDS  = mysql_query($SQL_TOP_BRANDS) or die(mysql_error());

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

                <?php 
                $num_rows = mysql_num_rows($RS_TOP_BRANDS);
                ?>
                
                <?php if($num_rows==0) {?>
                <h1><span>Records not found for '<?php print($searchQuery);?>'</span></h1>
                <p>This brand name not existing do you wanna get marketing data for this search brand ? </p>
                
                <a href="<?php print($siteBaseUrl);?>new-brand.php?key=<?php print($searchQuery);?>" class="myButton">Yes</a> <a href="<?php print($siteBaseUrl);?>" class="myButtonDisabled">No</a>
                
                <?php } else {?>
                <h1><span>The search results for '<?php print($searchQuery);?>'</span></h1>
                <p>The search results for '<?php print($searchQuery);?>'. Click on a brand to see more detailed results based on country, state and city. Enter your search key and click on the search button to see other brands. </p>

                <div class="fieldcontainer">



                    <div class="main">
                        <div class="inner">
                            
                            <?php while($TOP_ROW = mysql_fetch_array($RS_TOP_BRANDS)){ ?>
                            
                            <div class="tile">
                                <p><?php print(convertToK($TOP_ROW['totResults']));?> k</p>
                                <a href="country.php?id=<?php print($TOP_ROW['bid']);?>&brand=<?php print($TOP_ROW['brandName']);?>">
                                <p><img src="contents/logos/<?php print($TOP_ROW['brandLogo']);?>" /> </p>
                                </a>
                                <p><?php print($TOP_ROW['totalCountry']);?> Countries</p>
                            </div>
                                
                            <?php } ?>
                            
                            
                           
                            
                            
                       </div>
                    </div>


                </div>
                
                <?php } ?>

            </div><!-- @end #content -->
        </div><!-- @end #w -->
        
         <?php include('includes/footer.tpl'); ?>
    </body>
</html>
