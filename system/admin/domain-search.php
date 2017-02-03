<?php
include '../config/db_con.php';
include 'includes/auth.php';
include 'includes/Paggination.php';

$page = '';
$orderBy = '';
$arrWhere = array();

$city_id        = $_GET['cmbCity']; 
$region_id      = $_GET['cmbRegion']; 
$country_id     = $_GET['cmbCountry']; 

if($country_id == 'na'){
    array_push($arrWhere, " (country_id = '' OR country_id = '0' OR country_id IS NULL) ");
}elseif($region_id == 'na'){
    array_push($arrWhere, " (region_id = '' OR region_id = '0' OR region_id IS NULL) ");
} else {
    
    if ($country_id != '')
                array_push($arrWhere, "country_id = '" . $country_id . "'");

    if ($region_id != '')
                    array_push($arrWhere, "region_id = '" . $region_id . "'");

    if ($city_id != '')
                    array_push($arrWhere, "city_id = '" . $city_id . "'");
    
}




if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
if ($page == '') {
    $page = 1;
}

$objPaggination = new Paggination();

$SQL_DOMAINS_COUNT = "SELECT count(id) as tot FROM tbl_domains";

if (count($arrWhere) > 0)
                $SQL_DOMAINS_COUNT.= " WHERE ".implode('AND ', $arrWhere);

$RS_DOMAINS_COUNT = mysql_query($SQL_DOMAINS_COUNT) or die(mysql_error());
$ROW_DOMAIN_COUNT = mysql_fetch_assoc($RS_DOMAINS_COUNT);
$totalResult = $ROW_DOMAIN_COUNT['tot'];
$objPaggination->CurrentPage = $page;
$objPaggination->TotalResults = $totalResult;
$paginationData = $objPaggination->getPaggingData();
$pageLimit1 = $paginationData['MYSQL_LIMIT1'];
$pageLimit2 = $paginationData['MYSQL_LIMIT2'];

$limit = " LIMIT $pageLimit1,$pageLimit2";

if ($page == '') {
    $page = 1;
}

$SQL_DOMAINS = "SELECT * FROM tbl_domains";

if (count($arrWhere) > 0)
                $SQL_DOMAINS.= " WHERE ".implode('AND ', $arrWhere);


$SQL_DOMAINS = $SQL_DOMAINS.$limit;


$RS_DOMAINS = mysql_query($SQL_DOMAINS) or die(mysql_error());

$SQL_COUNTRY = "SELECT * FROM countries";
$RS_COUNTRY = mysql_query($SQL_COUNTRY);


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
        <li><a href="#"><i class="icon-home"></i></a></li>
        <li><a href="#">Domains</a></li>
        <li class="active"><a href="#">All Domains</a></li>
    </ul>
    <!-- END Navigation info -->


 <h3 class="page-header page-header-top">Search Domain</h3>

    
              <!-- Text Inputs -->
                    <form class="form-horizontal form-box remove-margin" method="get" action="" id="form-validation" >
                      
                        <div class="form-box-content">
                            
                            
                            
                            <div class="control-group">
                                <label class="control-label" for="firstname-input">Domain Name</label>
                                <div class="controls">
                                    <input type="text" id="txtDomainName" name="txtDomainName" class="input-xlarge" />
                                </div>
                            </div>
                            
                            
                            <div class="control-group">
                                <label class="control-label" for="status-input">Country</label>
                                <div class="controls">
                                    <select id="cmbCountry" name="cmbCountry" class="input-xlarge" onchange="showRegion();">
                                         <option value="">-- All Country --</option>
                                         <option value="0">-- Country Not Found --</option>
                                         <?php while($country_row = mysql_fetch_array($RS_COUNTRY)){?>
                                         <option value="<?php print($country_row['id']);?>"><?php print($country_row['name']);?></option>
                                         <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="status-input">Region</label>
                                <div class="controls">
                                    <span id="div_region">
                                    <select id="cmbRegion" name="cmbRegion" class="input-xlarge" onchange="showCity();">
                                         <option value="">-- All Region --</option>
                                         <option value="0">-- Region Not Found --</option>
                                         <?php while($region_row = mysql_fetch_array($RS_REGION)){?>
                                         <option value="<?php print($region_row['id']);?>"><?php print($region_row['name']);?></option>
                                         <?php } ?>
                                    </select>
                                        </span>
                                   
                                </div>
                                
                                
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="status-input">City</label>
                                <div class="controls">
                                    <span id="div_city">
                                    <select id="cmbCity" name="cmbCity" class="input-xlarge">
                                         <option value="">-- All City --</option>
                                         <option value="0">-- City Not Found --</option>
                                         <?php while($city_row = mysql_fetch_array($RS_CITY)){?>
                                         <option value="<?php print($city_row['id']);?>"><?php print($city_row['name']);?></option>
                                         <?php } ?>
                                    </select>
                                    </span>
                                    
                                </div>
                            </div>
                            
                            
                   
                            
                      
                            
                           


                            <div class="form-actions">
                                <button class="btn btn-success"><i class="icon-search"></i> Search</button>
                                
                            </div>
                        </div>
                    </form>



<BR/>
<BR/>
<BR/>

    <h3 class="page-header page-header-top">Domains</h3>

    <table class="table">
        <thead>
            <tr>
                <th class="span1 text-center" data-toggle="tooltip" title="Toggle all!"><input type="checkbox" id="check1-all" name="check1-all"></th>
                <th class="span1 text-center">#</th>
                <th>Domain Name</th>
                <th class="hidden-phone">Post Code</th>
                <th class="hidden-phone">City</th>
                <th class="hidden-phone">State</th>
                <th class="hidden-phone">Country </th>
                <th class="span3 text-center"><i class="icon-bolt"></i> Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $row_id = 1;
            while ($DOMAIN_ROW = mysql_fetch_array($RS_DOMAINS)) {
                ?>
                <tr>
                    <td class="span1 text-center"><input type="checkbox" id="check1-td1" name="check1-td1"></td>
                    <td class="span1 text-center"><?php print($row_id); ?></td>
                    <td><a href="#"><?php print($DOMAIN_ROW['domain_name']); ?></a></td>
                    <td class="hidden-phone"><?php print($DOMAIN_ROW['post_code']); ?></td>
                    <td class="hidden-phone"><?php print(getCityName($DOMAIN_ROW['city_id'])); ?></td>
                    <td class="hidden-phone"><?php print(getRegionName($DOMAIN_ROW['region_id'])); ?></td>
                    <td class="hidden-phone"><?php print(getCountryName($DOMAIN_ROW['country_id'])); ?></td>
                    <td class="span3 text-center">

                        <div class="btn-group">
                            <a href="edit-domain.php?id=<?php print($DOMAIN_ROW['id']); ?>" data-toggle="tooltip" title="Edit" class="btn btn-mini btn-success"><i class="icon-pencil"></i></a>
                            <a href="delete-domain.php?id=<?php print($DOMAIN_ROW['id']); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger"><i class="icon-remove"></i></a>
                        </div>
                    </td>
                </tr>
                <?php
                $row_id = $row_id + 1;
            }
            ?>


        </tbody>
    </table>

    <div class="row-fluid">
        <div class="span5">
            <div class="dataTables_info" id="example-datatables_info">
                <strong><?php print($objPaggination->ResultArray['START_OFFSET']);?></strong>-<strong><?php print($objPaggination->ResultArray['END_OFFSET']);?></strong> of <strong><?php print($objPaggination->TotalResults);?></strong>
            </div>
        </div>
        <div class="span7">
            <div class="dataTables_paginate paging_bootstrap pagination">
                <ul>
                    
                        <?php if (isset($objPaggination->ResultArray['PREV_PAGE']) && $objPaggination->ResultArray['PREV_PAGE'] != ""): ?>
                        <li class="prev">
                        <a href="?page=<?php print($objPaggination->ResultArray['PREV_PAGE']);?>&cmbCity=<?php print($city_id);?>&cmbRegion=<?php print($region_id);?>&cmbCountry=<?php print($country_id);?>">
                            <i class="icon-chevron-left"></i> 
                        </a>
                        </li>
                        <?php else: ?>
                        <li class="prev">
                        <a href="#">
                            <i class="icon-chevron-left"></i> 
                        </a>
                        </li>
                        <?php endif; ?>
                        
                    <?php if(count($objPaggination->numbers)>0){?>
                        <?php foreach ($objPaggination->numbers as $page): ?>
                            <?php if ($page != $objPaggination->ResultArray['CURRENT_PAGE']): ?>
                        <li><a href="?page=<?php print($page);?>&cmbCity=<?php print($city_id);?>&cmbRegion=<?php print($region_id);?>&cmbCountry=<?php print($country_id);?>"><?= $page; ?></a></li>
                        <?php else: ?>
                        <li class="active"><a href="#"><?= $page; ?></a></li>
                        <?php endif; ?>
                        <?php endforeach; ?>
                        <?php } ?>
                    
                    
                        <!-- Next page link -->
	<?php if (isset($objPaggination->ResultArray['NEXT_PAGE']) && $objPaggination->ResultArray['NEXT_PAGE'] != ""): ?>
         <li class="next"><a href="?page=<?php print($page);?>&cmbCity=<?php print($city_id);?>&cmbRegion=<?php print($region_id);?>&cmbCountry=<?php print($country_id);?>"> <i class="icon-chevron-right"></i></a></li>
	<?php else: ?>
	 <li class="next"><a href="#"> <i class="icon-chevron-right"></i></a></li>
	<?php endif; ?>
                   
                    
                    
                </ul>
            </div>
        </div>
    </div>














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
<!--[if lte IE 8]><script src="<?php print($siteBaseUrl); ?>contents/admin/js/helpers/excanvas.min.js"></script><![endif]-->

<!-- Jquery library from Google ... -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<!-- ... but if something goes wrong get Jquery from local file -->
<script>!window.jQuery && document.write(unescape('%3Cscript src="<?php print($siteBaseUrl); ?>contents/admin/js/vendor/jquery-1.9.1.min.js"%3E%3C/script%3E'));</script>

<!-- Bootstrap.js -->
<script src="<?php print($siteBaseUrl); ?>contents/admin/js/vendor/bootstrap.min.js"></script>

<!--
Include Google Maps API for global use.
If you don't want to use  Google Maps API globally, just remove this line and the gmaps.js plugin from <?php print($siteBaseUrl); ?>contents/admin/js/plugins.js (you can put it in a seperate file)
Then iclude them both in the pages you would like to use the google maps functionality
-->
<script src="http://maps.google.com/maps/api/js?sensor=true"></script>

<!-- Jquery plugins and custom javascript code -->
<script src="<?php print($siteBaseUrl); ?>contents/admin/js/plugins.js"></script>
<script src="<?php print($siteBaseUrl); ?>contents/admin/js/main.js"></script>
<!-- Javascript code only for this page -->

<script src="<?php print($siteBaseUrl); ?>contents/admin/js/ajscript.js"></script>


</body>
</html>