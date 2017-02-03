<?php
include 'config/db_con.php';
include 'includes/auth.php';
include 'includes/Paggination.php';

$userId = $_SESSION['userId'];
$updateStatus = $_GET['status'];

$page = '';
$orderBy = '';

if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
if ($page == '') {
    $page = 1;
}

$objPaggination = new Paggination();

$SQL_BRANDS_COUNT = "SELECT count(id) as tot FROM tbl_brands WHERE tbl_member_id = '".$userId."'";
$RS_BRANDS_COUNT = mysql_query($SQL_BRANDS_COUNT) or die(mysql_error());
$ROW_BRAND_COUNT = mysql_fetch_assoc($RS_BRANDS_COUNT);
$totalResult = $ROW_BRAND_COUNT['tot'];
$objPaggination->CurrentPage = $page;
$objPaggination->TotalResults = $totalResult;
$paginationData = $objPaggination->getPaggingData();
$pageLimit1 = $paginationData['MYSQL_LIMIT1'];
$pageLimit2 = $paginationData['MYSQL_LIMIT2'];

$limit = " LIMIT $pageLimit1,$pageLimit2";

if ($page == '') {
    $page = 1;
}

$SQL_BRANDS = "SELECT * FROM tbl_brands WHERE tbl_member_id = '".$userId."'" . $limit;
$RS_BRANDS = mysql_query($SQL_BRANDS) or die(mysql_error());
?>


<?php include 'includes/panel/header.php'; ?>
<?php include 'includes/panel/side_nav.php'; ?>



<!-- END Demo Theme Options -->
</aside>
<!-- END Sidebar -->
<!-- Page Content -->


<div id="page-content">
    <!-- Navigation info -->
    <ul id="nav-info" class="clearfix">
        <li><a href="index.php"><i class="icon-home"></i></a></li>
        <li class="active"><a href="brands.php">All Brands</a></li>
    </ul>
    <!-- END Navigation info -->








    <h3 class="page-header page-header-top">Brands</h3>
<?php if($updateStatus != ''){?>
                    <div class="push">
                        <?php if($updateStatus == 'updated'){?>
                        <div class="alert alert-success">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        <strong>Success!</strong> The record has been updated successfully!
                        </div>
                        <?php } elseif($updateStatus == 'deleted'){?>
                        <div class="alert alert-success">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        <strong>Success!</strong> The record has been deleted successfully!
                        </div>
                        <?php } ?>
                        
                    </div>
                    <?php } ?>
    <table class="table">
        <thead>
            <tr>
                <th class="span1 text-center" data-toggle="tooltip" title="Toggle all!"><input type="checkbox" id="check1-all" name="check1-all"></th>
                <th class="span1 text-center">#</th>
                <th>Brand Name</th>
                <th class="hidden-phone">Sector</th>
                <th class="hidden-phone">Country</th>
                <th class="hidden-phone">Status</th>
                <th class="span3 text-center"><i class="icon-bolt"></i> Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $row_id = 1;
            while ($BRAND_ROW = mysql_fetch_array($RS_BRANDS)) {
                ?>
                <tr>
                    <td class="span1 text-center"><input type="checkbox" id="check1-td1" name="check1-td1"></td>
                    <td class="span1 text-center"><?php print($row_id); ?></td>
                    <td><a href="#"><?php print($BRAND_ROW['brand_name']); ?></a></td>
                    <td class="hidden-phone"><?php print(getSectorName($BRAND_ROW['sector'])); ?></td>
                    <td class="hidden-phone"><?php print(getCountryName($BRAND_ROW['country_name'])); ?></td>
                    <td class="hidden-phone">
                        <?php if($BRAND_ROW['is_status'] == 'Enabled') { ?>
                        <span class="label label-success">Enabled</span>
                        <?php } else {?>
                        <span class="label label-danger">Disabled</span>
                        <?php } ?>
                    </td>
                    <td class="span3 text-center">

                        <div class="btn-group">
                            <a href="edit-brand.php?id=<?php print($BRAND_ROW['id']); ?>" data-toggle="tooltip" title="Edit" class="btn btn-mini btn-success"><i class="icon-pencil"></i></a>
                            <a href="delete-brand.php?id=<?php print($BRAND_ROW['id']); ?>" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger"><i class="icon-remove"></i></a>
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
                        <a href="?page=<?php print($objPaggination->ResultArray['PREV_PAGE']);?>">
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
                        <li><a href="?page=<?php print($page);?>"><?= $page; ?></a></li>
                        <?php else: ?>
                        <li class="active"><a href="#"><?= $page; ?></a></li>
                        <?php endif; ?>
                        <?php endforeach; ?>
                        <?php } ?>
                    
                    
                        <!-- Next page link -->
	<?php if (isset($objPaggination->ResultArray['NEXT_PAGE']) && $objPaggination->ResultArray['NEXT_PAGE'] != ""): ?>
         <li class="next"><a href="?page=<?php print($page);?>"> <i class="icon-chevron-right"></i></a></li>
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
<!--[if lte IE 8]><script src="<?php print($siteBaseUrl); ?>contents/home/js/helpers/excanvas.min.js"></script><![endif]-->

<!-- Jquery library from Google ... -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<!-- ... but if something goes wrong get Jquery from local file -->
<script>!window.jQuery && document.write(unescape('%3Cscript src="<?php print($siteBaseUrl); ?>contents/home/js/vendor/jquery-1.9.1.min.js"%3E%3C/script%3E'));</script>

<!-- Bootstrap.js -->
<script src="<?php print($siteBaseUrl); ?>contents/home/js/vendor/bootstrap.min.js"></script>

<!--
Include Google Maps API for global use.
If you don't want to use  Google Maps API globally, just remove this line and the gmaps.js plugin from <?php print($siteBaseUrl); ?>contents/home/js/plugins.js (you can put it in a seperate file)
Then iclude them both in the pages you would like to use the google maps functionality
-->
<script src="http://maps.google.com/maps/api/js?sensor=true"></script>

<!-- Jquery plugins and custom javascript code -->
<script src="<?php print($siteBaseUrl); ?>contents/home/js/plugins.js"></script>
<script src="<?php print($siteBaseUrl); ?>contents/home/js/main.js"></script>
<!-- Javascript code only for this page -->


</body>
</html>