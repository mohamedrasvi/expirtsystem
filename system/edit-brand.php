<?php
include 'config/db_con.php';
include 'includes/auth.php';
include 'includes/class.phpmailer.php';
$currentDate = date('Y-m-d H:i:s');

$updateStatus = $_GET['status'];

$brandId = $_GET['id'];
$SQL_BRAND = "SELECT * FROM tbl_brands WHERE id = '".$brandId."'";
$RS_BRAND = mysql_query($SQL_BRAND) or die(mysql_error());
$ROW_BRAND = mysql_fetch_assoc($RS_BRAND);
$brandId         = $ROW_BRAND['id'];
$brand_name     = $ROW_BRAND['brand_name'];
$brand_logo     = $ROW_BRAND['brand_logo'];
$brand_tags     = $ROW_BRAND['brand_tags'];
$added_on       = $ROW_BRAND['added_on'];
$modified_on    = $ROW_BRAND['modified_on'];
$country_name   = $ROW_BRAND['country_name'];
$sector         = $ROW_BRAND['sector'];
$is_status      = $ROW_BRAND['is_status'];


$SQL_COUNTRY = "SELECT * FROM countries";
$RS_COUNTRY = mysql_query($SQL_COUNTRY);

$SQL_SECTOR = "SELECT * FROM tbl_sector";
$RS_SECTOR = mysql_query($SQL_SECTOR);


if($_POST){
    
    $brandId        = $_POST['txtId'];
    $brand_name     = mysql_escape_string($_POST['txtBrandName']);
    
    $brand_logo     = $_FILES["txtLogo"]["name"];
    
    $brand_tags     = mysql_escape_string($_POST['txtBrandTags']);
    $added_on       = $currentDate;
    $modified_on    = $currentDate;
    $country_name   = $_POST['cmbCountry'];
    $sector         = $_POST['cmbSector'];
    $is_status      = $_POST['cmbStatus'];
    if($brand_logo != ""){
        move_uploaded_file($_FILES["txtLogo"]["tmp_name"],"contents/logos/" . $_FILES["txtLogo"]["name"]);
        
        $SQL_UPDATE = "UPDATE `tbl_brands` SET `brand_name` = '".$brand_name."', `brand_logo` = '".$brand_logo."', `brand_tags` = '".$brand_tags."',`modified_on` = '".$modified_on."', `country_name` = '".$country_name."', `sector` = '".$sector."', `is_status` = '".$is_status."' WHERE `id` = '".$brandId."'";
        
    } else {
        
         $SQL_UPDATE = "UPDATE `tbl_brands` SET `brand_name` = '".$brand_name."', `brand_tags` = '".$brand_tags."',`modified_on` = '".$modified_on."', `country_name` = '".$country_name."', `sector` = '".$sector."', `is_status` = '".$is_status."' WHERE `id` = '".$brandId."'";
        
    }
    
    //print($SQL_UPDATE);exit;
    
    $SQL_NOTIFICATION_EMAILS = "SELECT email_addresses FROM tbl_email_notifications WHERE notification_type = 'New_Brand'";
    $RS_NOTIFICATION_EMAILS  = mysql_query($SQL_NOTIFICATION_EMAILS) or die(mysql_error());
    $ROW_NOTIFICATION_EMAILS = mysql_fetch_assoc($RS_NOTIFICATION_EMAILS);
    $NOTIFICATION_EMAILS     = $ROW_NOTIFICATION_EMAILS['email_addresses'];
    $arrEmails  = explode(',', $NOTIFICATION_EMAILS);
    
    
    $mail = new PHPMailer();
    $mail->IsSendmail(); // telling the class to use SendMail transport
    $mail->AddReplyTo(SITE_EMAIL_ADDRESS, SITE_NAME);
    foreach($arrEmails As $eIndex=>$email){
      $mail->AddAddress($email);  
    }
     
    $mail->SetFrom(SITE_EMAIL_ADDRESS, SITE_NAME);
    $mail->Subject = "A brand edited by ".$_SESSION['userFullName']." - ".SITE_NAME;
    $msg = "The brand name is : ".$brand_name."<BR/> Tags : ".$brand_tags;
    $mail->MsgHTML($msg);

    $mail->Send();
    
    
    $rs_update = mysql_query($SQL_UPDATE) or die(mysql_error());
    header('Location: brands.php?status=updated');
    
}

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
        <li><a href="#"><i class="icon-home"></i></a></li>
        <li><a href="#">Brands</a></li>
        <li class="active"><a href="#">All Brands</a></li>
    </ul>
    <!-- END Navigation info -->








    <h3 class="page-header page-header-top">Edit Brand</h3>
    
     <?php if($updateStatus != ''){?>
                    <div class="push">
                        <?php if($updateStatus == 'updated'){?>
                        <div class="alert alert-success">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        <strong>Success!</strong> The record has been updated successfully!
                        </div>
                        <?php } ?>
                        
                    </div>
                    <?php } ?>

    
              <!-- Text Inputs -->
                    <form class="form-horizontal form-box remove-margin" method="post" action="" id="form-validation" novalidate="novalidate" enctype="multipart/form-data">
                        <h4 class="form-box-header">Brand Details</h4>
                        <div class="form-box-content">
                            
                            
                            
                            <div class="control-group">
                                <label class="control-label" for="firstname-input">Brand Name</label>
                                <div class="controls">
                                    <input type="text" id="txtBrandName" name="txtBrandName" class="input-xlarge" value="<?php print($brand_name);?>" />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="firstname-input">Brand Tags</label>
                                <div class="controls">
                                    <input type="text" id="txtBrandTags" name="txtBrandTags" class="input-xlarge" value="<?php print($brand_tags);?>" />
                                </div>
                            </div>
                            
                            
                            <div class="control-group">
                                <label class="control-label" for="status-input">Country</label>
                                <div class="controls">
                                    <select id="cmbCountry" name="cmbCountry" class="input-xlarge">
                                         <option value=""></option>
                                         <?php while($country_row = mysql_fetch_array($RS_COUNTRY)){?>
                                         <option value="<?php print($country_row['id']);?>" <?php if($country_name == $country_row['id']){?> selected="selected" <?php } ?> ><?php print($country_row['name']);?></option>
                                         <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            
                            <div class="control-group">
                                <label class="control-label" for="status-input">Sector</label>
                                <div class="controls">
                                    <select id="cmbSector" name="cmbSector" class="input-xlarge">
                                         <option value=""></option>
                                         <?php while($sector_row = mysql_fetch_array($RS_SECTOR)){?>
                                         <option value="<?php print($sector_row['id']);?>" <?php if($sector == $sector_row['id']){?> selected="selected" <?php } ?> ><?php print($sector_row['name']);?></option>
                                         <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            
                             <div class="control-group">
                                <label class="control-label" for="status-input">Status</label>
                                <div class="controls">
                                    <select id="cmbStatus" name="cmbStatus" class="input-xlarge">
                                         <option value=""></option>
                                         <option value="Enabled" <?php if($is_status == 'Enabled'){?> selected="selected" <?php } ?> >Enabled</option>
                                         <option value="Disabled" <?php if($is_status == 'Disabled'){?> selected="selected" <?php } ?>>Disabled</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="lastname-input">Logo</label>
                                <div class="controls">
                                    <input type="file" name="txtLogo" value="" />
                                    <img src="<?php print($siteBaseUrl);?>contents/logos/<?php print($brand_logo);?>" height="50px;" width="50px;" />
                                </div>
                            </div>
                       
                            
                            <div class="control-group">
                                <label class="control-label" for="lastname-input">Added On</label>
                                <div class="controls">
                                    <input readonly="readonly" type="text" id="txtAddedOn" name="txtAddedOn" class="input-xlarge" value="<?php print($added_on);?>" />
                                </div>
                            </div>
                            
                            
                            <div class="control-group">
                                <label class="control-label" for="lastname-input">Updated On</label>
                                <div class="controls">
                                    <input readonly="readonly" type="text" id="txtUpdatedOn" name="txtUpdatedOn" class="input-xlarge" value="<?php print($modified_on);?>" />
                                </div>
                            </div>


                            <div class="form-actions">
                                <input type="hidden" name="txtId" value="<?php print($brandId);?>" />
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
<script src="<?php print($siteBaseUrl); ?>contents/home/js/ajscript.js"></script>

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