<?php
include '../config/db_con.php';
include 'includes/auth.php';




$SQL_BRANDS = "SELECT * FROM tbl_brands ORDER BY added_on Desc";
$RS_BRANDS  = mysql_query($SQL_BRANDS) or die(mysql_error());

if($_GET['brand']){
    $brandName = $_GET['brand'];
    $SQL_BRANDS = "SELECT * FROM tbl_brands WHERE brand_name LIKE '".'%'.$brandName.'%'."'  ORDER BY added_on Desc";
$RS_BRANDS  = mysql_query($SQL_BRANDS) or die(mysql_error());
}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

                    
                     <?php include 'includes/header.php'; ?>
                    <?php include 'includes/side_nav.php'; ?>
                    

                  
                    <!-- END Demo Theme Options -->
                </aside>
                <!-- END Sidebar -->
                <!-- Page Content -->
                <div id="page-content">
                    <!-- Navigation info -->
                    <ul id="nav-info" class="clearfix">
                        <li><a href="<?php print($siteAdminBaseUrl);?>domains.php"><i class="icon-home"></i></a></li>
                        <li class="active"><a href="<?php print($siteAdminBaseUrl);?>">Dashboard</a></li>
                    </ul>
                    <!-- END Navigation info -->

                    <h3 class="page-header page-header-top">Our latest brands</h3>
                    <h4 class="sub-header error_color">Needs Attention
                        <small>
                            Country missing in <a href="domain-search.php?txtDomainName=&cmbCountry=na&cmbRegion=&cmbCity=" style="text-decoration: underline;"> 
                                <?php 
                                // country missing
                                $totalResult_country_missing = 0;
                                $SQL_DOMAINS_COUNT = "SELECT count(id) as tot FROM tbl_domains WHERE country_id = '' OR country_id = '0' OR country_id IS NULL";
                                $RS_DOMAINS_COUNT = mysql_query($SQL_DOMAINS_COUNT) or die(mysql_error());
                                $ROW_DOMAIN_COUNT = mysql_fetch_assoc($RS_DOMAINS_COUNT);
                                $totalResult_country_missing = $ROW_DOMAIN_COUNT['tot'];
                                
                                // state missing....
                                $totalResult_state_missing = 0;
                                $SQL_DOMAINS_COUNT_STATES = "SELECT count(id) as tot FROM tbl_domains WHERE region_id = '' OR region_id = '0' OR region_id IS NULL";
                                $RS_DOMAINS_COUNT_STATES = mysql_query($SQL_DOMAINS_COUNT_STATES) or die(mysql_error());
                                $ROW_DOMAIN_COUNT_STATES = mysql_fetch_assoc($RS_DOMAINS_COUNT_STATES);
                                $totalResult_state_missing = $ROW_DOMAIN_COUNT_STATES['tot'];
                                ?>
                                <?php print($totalResult_country_missing);?> Domains
                            </a>, 
                            States missing in <a href="domain-search.php?txtDomainName=&cmbCountry=&cmbRegion=na&cmbCity=" style="text-decoration: underline;">
                                <?php print($totalResult_state_missing);?> Domains
                            </a>. Please update the details ASAP to get the report properly.
                        </small>
                    </h4>

                   
 
                    <!-- Tiles -->
                    <!-- Row 1 -->
                    <div class="dash-tiles row-fluid">
                        <!-- Column 1 of Row 1 -->
                        
                            
                            <?php while($ROW_BRAND = mysql_fetch_array($RS_BRANDS)){?>
                        <div class="span3 dashboardBox">
                            <!-- Total Users Tile -->
                            <div class="dash-tile dash-tile-dark clearfix">
                                <div class="dash-tile-header">
                                    <div class="dash-tile-options">
                                        <div class="btn-group">
                                            <a href="edit-brand.php?id=<?php print($ROW_BRAND['id']);?>" class="btn" data-toggle="tooltip" title="Modify brand details"><i class="icon-cog"></i></a>
                                            <a target="_blank" href="<?php print($siteBaseUrl);?>country.php?id=<?php print($ROW_BRAND['id']);?>&brand=<?php print($ROW_BRAND['brand_name']);?>" class="btn" data-toggle="tooltip" title="Statistics"><i class="icon-bar-chart"></i></a>
                                        </div>
                                    </div>
                                   <?php print($ROW_BRAND['brand_name']);?>
                                </div>
                                <div class="dash-tile-icon">
                                    <img  src="<?php print($siteBaseUrl);?>contents/logos/<?php print($ROW_BRAND['brand_logo']);?>" height="100px;" width="100px;" style="height: 100px !important;" />
                                </div>
                                <div class="dash-tile-text">
                                <?php 
                                $SQL_TOTALCOUNT = "SELECT sum(total_count) as totalcount FROM tbl_search_result_country WHERE brand_id = '".$ROW_BRAND['id']."' AND report_date = '".REPORT_DATE."'";
                                $RS_TOTALCOUNT = mysql_query($SQL_TOTALCOUNT) or die(mysql_error());
                                $ROW_BRAND_TOTAL = mysql_fetch_assoc($RS_TOTALCOUNT);
                                print(convertToK($ROW_BRAND_TOTAL['totalcount']));
                                ?> k
                                </div>
                            </div>
                            <!-- END Total Users Tile -->
                              </div>
                           <?php } ?>
                            <!-- Total Profit Tile -->
                        
                      

                        <!-- END Column 4 of Row 1 -->
                    </div>
                    <!-- END Row 1 -->

                    
                   

                       
                        
                        
                     
                        <!-- END Column 2 of Row 3 -->
                    </div>
                    
                    
                    
                    <!-- END Row 3 -->
                    <!-- END Tiles -->
                </div>
                <!-- END Page Content -->

               
                 <?php include 'includes/footer.php'; ?>
                
            </div>
            <!-- END Inner Container -->
        </div>
        <!-- END Page Container -->

        <!-- Scroll to top link, check main.js - scrollToTop() -->
        <a href="#" id="to-top"><i class="icon-chevron-up"></i></a>

        
        
        
       
        <!-- END User Modal Settings -->

        <!-- Excanvas for Flot (Charts plugin) support on IE8 -->
        <!--[if lte IE 8]><script src="<?php print($siteBaseUrl);?>contents/admin/js/helpers/excanvas.min.js"></script><![endif]-->

        <!-- Jquery library from Google ... -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <!-- ... but if something goes wrong get Jquery from local file -->
        <script>!window.jQuery && document.write(unescape('%3Cscript src="<?php print($siteBaseUrl);?>contents/admin/js/vendor/jquery-1.9.1.min.js"%3E%3C/script%3E'));</script>

        <!-- Bootstrap.js -->
        <script src="<?php print($siteBaseUrl);?>contents/admin/js/vendor/bootstrap.min.js"></script>

        <!--
        Include Google Maps API for global use.
        If you don't want to use  Google Maps API globally, just remove this line and the gmaps.js plugin from <?php print($siteBaseUrl);?>contents/admin/js/plugins.js (you can put it in a seperate file)
        Then iclude them both in the pages you would like to use the google maps functionality
        -->
        <script src="http://maps.google.com/maps/api/js?sensor=true"></script>

        <!-- Jquery plugins and custom javascript code -->
        <script src="<?php print($siteBaseUrl);?>contents/admin/js/plugins.js"></script>
        <script src="<?php print($siteBaseUrl);?>contents/admin/js/main.js"></script>
        <!-- Javascript code only for this page -->
       

    </body>
</html>