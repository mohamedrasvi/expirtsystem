<?php
include '../config/db_con.php';
include 'includes/auth.php';
include 'includes/Paggination.php';

$page = '';
$orderBy = '';

if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
if ($page == '') {
    $page = 1;
}

$objPaggination = new Paggination();

$SQL_SEARCH_LOGS_COUNT = "SELECT count(id) as tot FROM tbl_search_logs WHERE results_found = 'No'";
$RS_SEARCH_LOGS_COUNT = mysql_query($SQL_SEARCH_LOGS_COUNT) or die(mysql_error());
$ROW_BRAND_COUNT = mysql_fetch_assoc($RS_SEARCH_LOGS_COUNT);
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

$SQL_SEARCH_LOGS = "SELECT * FROM tbl_search_logs WHERE results_found = 'No' " . $limit;
$RS_SEARCH_LOGS = mysql_query($SQL_SEARCH_LOGS) or die(mysql_error());
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
        <li><a href="index.php"><i class="icon-home"></i></a></li>
        <li class="active"><a href="searchlogs.php">All Search Logs</a></li>
    </ul>
    <!-- END Navigation info -->








    <h3 class="page-header page-header-top">Search Logs</h3>

    <table class="table">
        <thead>
            <tr>
                <th class="span1 text-center">#</th>
                <th>Search Key</th>
                <th class="hidden-phone">Searched On</th>
                <th class="hidden-phone">Searched From</th>
                <th class="hidden-phone">Searched By</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $row_id = 1;
            while ($SEARCH_ROW = mysql_fetch_array($RS_SEARCH_LOGS)) {
                ?>
                <tr>
                    <td class="span1 text-center"><?php print($row_id); ?></td>
                    <td><?php print($SEARCH_ROW['search_key']); ?></td>
                    <td class="hidden-phone"><?php print($SEARCH_ROW['date_and_time']); ?></td>
                    <td class="hidden-phone"><?php print($SEARCH_ROW['ip_address']); ?></td>
                    <td class="hidden-phone">
                        <?php 
                        $SQL_USER = "SELECT * FROM tbl_members WHERE id = '".$SEARCH_ROW['searched_by']."'";
                        $RS_USER = mysql_query($SQL_USER) or die(mysql_error());
                        $ROW_USER_INFO = mysql_fetch_assoc($RS_USER);
                        print($ROW_USER_INFO['full_name']);
                        ?></td>
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


</body>
</html>