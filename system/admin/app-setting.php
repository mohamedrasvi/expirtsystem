<?php
include '../config/db_con.php';
include 'includes/auth.php';
$currentDate = date('Y-m-d H:i:s');

$SQL_SETTINGS = "SELECT * FROM tbl_site_settings WHERE id = 1";
$RS_SETTINGS = mysql_query($SQL_SETTINGS) or die(mysql_error());
$ROW_SETTINGS = mysql_fetch_assoc($RS_SETTINGS);
$id = $ROW_SETTINGS['id'];
$site_name = $ROW_SETTINGS['site_name'];
$site_email_addresses = $ROW_SETTINGS['site_email_addresses'];
$site_phone_number = $ROW_SETTINGS['site_phone_number'];
$site_contact_number = $ROW_SETTINGS['site_contact_number'];
$site_address = $ROW_SETTINGS['site_address'];
$site_footer_text = $ROW_SETTINGS['site_footer_text'];


if($_POST){
    
    $id                     = $_POST['txtId'];
    $site_name              = $_POST['txtSiteName'];
    $site_email_addresses   = $_POST['txtEmailAddress'];
    $site_phone_number      = $_POST['txtPhoneNumbers'];
    $site_contact_number    = $_POST['txtContactNumber'];
    $site_address           = $_POST['txtAddress'];
    $site_footer_text       = $_POST['txtFooterText'];
    
    $SQL_UPDATE = "UPDATE `tbl_site_settings` SET 
        `site_name` = '".$site_name."', 
        `site_email_addresses` = '".$site_email_addresses."', 
        `site_phone_number` = '".$site_phone_number."', 
        `site_contact_number` = '".$site_contact_number."', 
        `site_address` = '".$site_address."', 
        `site_footer_text` = '".$site_footer_text."' 
        WHERE `id` = '".$id."'";
    
    $RS_SETTING = mysql_query($SQL_UPDATE) or die(mysql_error());
    header('Location: app-setting.php?status=updated');
} else {
    
    $status = "";
    
    if($_GET['status']){
        $status = $_GET['status'];
    }
    
}

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
        <li><a href="#">Manage Settings</a></li>
        <li class="active"><a href="#">Update App Settings</a></li>
    </ul>
    <!-- END Navigation info -->








    <h3 class="page-header page-header-top"> App Settings</h3>

    
    <div class="push">
                        
                        <?php if($status == 'updated'){?>
                        <div class="alert alert-success">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        <strong>Success!</strong> The record has been edited successfully!
                        </div>
                        <?php } ?>
                        
                    </div>
    
              <!-- Text Inputs -->
                    <form class="form-horizontal form-box remove-margin" method="post" action="" id="form-validation" novalidate="novalidate" enctype="multipart/form-data">
                        <h4 class="form-box-header">App Settings</h4>
                        <div class="form-box-content">
                            
                            
                            
                            <div class="control-group">
                                <label class="control-label" for="firstname-input">Site Name </label>
                                <div class="controls">
                                    <input type="text" id="txtSiteName" name="txtSiteName" class="input-xxlarge" value="<?php print($site_name);?>" />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="emailaddress-input">Site E-Mail Address</label>
                                <div class="controls">
                                    <input type="text" id="txtEmailAddress" name="txtEmailAddress" class="input-xxlarge" value="<?php print($site_email_addresses);?>" />
                                </div>
                            </div>
                            
                          <div class="control-group">
                                <label class="control-label" for="emailaddress-input">Site telephone numbers</label>
                                <div class="controls">
                                    <input type="text" id="txtPhoneNumbers" name="txtPhoneNumbers" class="input-xxlarge" value="<?php print($site_phone_number);?>" />
                                </div>
                            </div>
                            
                              <div class="control-group">
                                <label class="control-label" for="emailaddress-input">Site contact number</label>
                                <div class="controls">
                                    <input type="text" id="txtContactNumber" name="txtContactNumber" class="input-xxlarge" value="<?php print($site_contact_number);?>" />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="emailaddress-input">Site address</label>
                                <div class="controls">
                                    <textarea id="txtAddress" name="txtAddress" class="input-xxlarge"><?php print($site_address);?></textarea>
                                </div>
                            </div>
                            
                              <div class="control-group">
                                <label class="control-label" for="emailaddress-input">Footer Text</label>
                                <div class="controls">
                                    <textarea id="txtFooterText" name="txtFooterText" class="input-xxlarge"><?php print($site_footer_text);?></textarea>
                                </div>
                            </div>
                            
                            

                            <div class="form-actions">
                                <input type="hidden" name="txtId" id="txtId" value="<?php print($id);?>" />
                                <button class="btn btn-success"><i class="icon-save"></i> Save</button>
                                <button class="btn btn-danger"><i class="icon-remove"></i> Delete</button>
                            </div>
                        </div>
                    </form>


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

<script type="text/javascript">
function showRegion(){
	var countryId = document.getElementById('cmbCountry').value;
	show("<?php print($siteBaseUrl); ?>/admin/ajex/region.php?cId="+countryId,"div_region");
}

function showCity(){
	var cityId = document.getElementById('cmbRegion').value;
	show("<?php print($siteBaseUrl); ?>/admin/ajex/city.php?rId="+cityId,"div_city");
}


</script>
</body>
</html>