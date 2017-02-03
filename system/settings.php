<?php
include 'config/db_con.php';
include 'includes/auth.php';
$currentDate = date('Y-m-d H:i:s');

$updateStatus = $_GET['status'];

$userId = $_SESSION['userId'];
$SQL_USER = "SELECT * FROM tbl_members WHERE id = '".$userId."'";
$RS_USER = mysql_query($SQL_USER) or die(mysql_error());
$ROW_USER_INFO = mysql_fetch_assoc($RS_USER);


$SQL_COUNTRY = "SELECT * FROM countries";
$RS_COUNTRY = mysql_query($SQL_COUNTRY);

$memberId           = $ROW_USER_INFO['id']; 
$full_name          = $ROW_USER_INFO['full_name']; 
$email_address      = $ROW_USER_INFO['email_address']; 
$password_2         = $ROW_USER_INFO['password_2']; 
$telephone_no       = $ROW_USER_INFO['telephone_no']; 
$contact_no         = $ROW_USER_INFO['contact_no']; 
$address_line1      = $ROW_USER_INFO['address_line1']; 
$address_line2      = $ROW_USER_INFO['address_line2']; 
$post_code          = $ROW_USER_INFO['post_code'];
$city_id            = $ROW_USER_INFO['city_id']; 
$state_id           = $ROW_USER_INFO['state_id']; 
$country_id         = $ROW_USER_INFO['country_id']; 
$company_name       = $ROW_USER_INFO['company_name']; 
$registered_on      = $ROW_USER_INFO['registered_on']; 
$updated_on         = $ROW_USER_INFO['updated_on']; 
$last_login         = $ROW_USER_INFO['last_login'];


if($_POST){
    
    $memberId           = $_POST['txtMemberId']; 
    $full_name          = $_POST['txtFullName']; 
    $email_address      = $_POST['txtEmailAddress']; 
    $password_2         = $_POST['txtPassword']; 
    $telephone_no       = $_POST['txtTelephoneNumber']; 
    $contact_no         = $_POST['txtContactNumber']; 
    $address_line1      = $_POST['txtAddressLine1']; 
    $address_line2      = $_POST['txtAddressLine2']; 
    $postCode           = $_POST['txtPostCode']; 
    $city_id            = $_POST['cmbCity']; 
    $regionId           = $_POST['cmbRegion']; 
    $country_id         = $_POST['cmbCountry']; 
    $countryId          = $country_id;
    //------------------------------------
    
    $theRegionId = "";
    $theCityId = "";
    
    $newRegion = $_POST['txtRegion'];
    if($regionId == ""){
        if($newRegion != ""){
          
            $SQL_NEW_REGION = "INSERT INTO regions(country_id,name) values('".$countryId."','".$newRegion."')";
            $RS_NEW_REGION = mysql_query($SQL_NEW_REGION) or die(mysql_error());
            $theRegionId = mysql_insert_id();
        } else {
            $theRegionId = $regionId;
        }
    } else {
        $theRegionId = $regionId;
    }
    
    $newCity = $_POST['txtCity'];
    if($city_id == ""){
        if($newCity != ""){
            
            $SQL_NEW_CITY = "INSERT INTO `cities` (
                `id`, 
                `country_id`, 
                `region_id`, 
                `url`, 
                `name`, 
                `latitude`, 
                `longitude`) VALUES (
                NULL, 
                '".$countryId."', 
                '".$theRegionId."', 
                '', 
                '".$newCity."', 
                '', 
                '')";
            $RS_NEW_CITY = mysql_query($SQL_NEW_CITY) or die(mysql_error());
            $theCityId = mysql_insert_id();
        } else {
            $theCityId = $city_id;
        }
        
    } else {
        $theCityId = $city_id;
    }
    
    //-----------------------------------
    
    
    
    
    
    $company_name       = $_POST['txtCompanyName']; 
    $registered_on      = $currentDate; 
    $updated_on         = NULL; 
    $last_login         = NULL;
    
    if($password_2 != ""){
    $SQL_INSERT = "UPDATE `tbl_members` SET 
        `full_name` = '".$full_name."', 
        `email_address` = '".$email_address."', 
        `password_2` = '".md5($password_2)."', 
        `telephone_no` = '".$telephone_no."', 
        `contact_no` = '".$contact_no."', 
        `address_line1` = '".$address_line1."', 
        `address_line2` = '".$address_line2."', 
        `city_id` = '".$city_id."', 
        `state_id` = '".$regionId."', 
        `country_id` = '".$countryId."', 
        `company_name` = '".$company_name."', 
        `updated_on` = '".$currentDate."', 
        `post_code` = '".$postCode."' WHERE `id` = '".$memberId."'";
    } else {
         $SQL_INSERT = "UPDATE `tbl_members` SET 
        `full_name` = '".$full_name."', 
        `email_address` = '".$email_address."', 
        `telephone_no` = '".$telephone_no."', 
        `contact_no` = '".$contact_no."', 
        `address_line1` = '".$address_line1."', 
        `address_line2` = '".$address_line2."', 
        `city_id` = '".$city_id."', 
        `state_id` = '".$regionId."', 
        `country_id` = '".$countryId."', 
        `company_name` = '".$company_name."', 
        `updated_on` = '".$currentDate."', 
        `post_code` = '".$postCode."' WHERE `id` = '".$memberId."'";
    }
    
    $RS_MEMBER_INSERT = mysql_query($SQL_INSERT) or die(mysql_error());
    header('Location: settings.php?status=updated');
    
}



$SQL_REGION = "SELECT * FROM regions WHERE country_id = '".$country_id."'";
$RS_REGION = mysql_query($SQL_REGION);


$SQL_CITIES = "SELECT * FROM cities WHERE region_id = '".$state_id."'";
$RS_CITYIES = mysql_query($SQL_CITIES);

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
        <li><a href="#">Home</a></li>
        <li><a href="#">My Account & Settings </a></li>
        <li class="active"><a href="#">Account & Settings</a></li>
    </ul>
    <!-- END Navigation info -->








    <h3 class="page-header page-header-top">My Account & Settings</h3>

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
                        <h4 class="form-box-header">Account Details</h4>
                        <div class="form-box-content">
                            
                            
                            
                            <div class="control-group">
                                <label class="control-label" for="firstname-input">Full Name</label>
                                <div class="controls">
                                    <input type="text" id="txtFullName" name="txtFullName" class="input-xlarge" value="<?php print($full_name);?>" />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="company-input">Company Name</label>
                                <div class="controls">
                                    <input type="text" id="txtCompanyName" name="txtCompanyName" class="input-xlarge" value="<?php print($company_name);?>" />
                                </div>
                            </div>
                            
                            
                            <div class="control-group">
                                <label class="control-label" for="telephonenumber-input">Telephone Number</label>
                                <div class="controls">
                                    <input type="text" id="txtTelephoneNumber" name="txtTelephoneNumber" class="input-xlarge" value="<?php print($telephone_no);?>" />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="contactnumber-input">Contact Number</label>
                                <div class="controls">
                                    <input type="text" id="txtContactNumber" name="txtContactNumber" class="input-xlarge" value="<?php print($contact_no);?>" />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="country-input">Country</label>
                                <div class="controls">
                                    <select id="cmbCountry" name="cmbCountry" class="input-xlarge" onchange="showRegion();">
                                         <option value=""></option>
                                         <?php while($country_row = mysql_fetch_array($RS_COUNTRY)){?>
                                         <option value="<?php print($country_row['id']);?>" <?php if($country_id == $country_row['id']){?> selected="selected" <?php } ?> ><?php print($country_row['name']);?></option>
                                         <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="region-input">Region</label>
                                <div class="controls">
                                    <span id="div_region">
                                    <select id="cmbRegion" name="cmbRegion" class="input-xlarge" onchange="showCity();">
                                         <option value=""></option>
                                         <?php while($region_row = mysql_fetch_array($RS_REGION)){?>
                                         <option value="<?php print($region_row['id']);?>" <?php if($state_id == $region_row['id']){?> selected="selected" <?php } ?> ><?php print($region_row['name']);?></option>
                                         <?php } ?>
                                    </select>
                                        </span>
                                    &nbsp;
                                    OR
                                    &nbsp;
                                     <input type="text" id="txtRegion" name="txtRegion" class="input-xlarge" value="" />
                                </div>
                                
                                
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="city-input">City</label>
                                <div class="controls">
                                    <span id="div_city">
                                    <select id="cmbCity" name="cmbCity" class="input-xlarge">
                                         <option value=""></option>
                                         <?php while($city_row = mysql_fetch_array($RS_CITYIES)){?>
                                         <option value="<?php print($city_row['id']);?>" <?php if($city_id == $city_row['id']){?> selected="selected" <?php } ?> ><?php print($city_row['name']);?></option>
                                         <?php } ?>
                                    </select>
                                    </span>
                                    &nbsp;
                                    OR
                                    &nbsp;
                                     <input type="text" id="txtCity" name="txtCity" class="input-xlarge" value="" />
                                    
                                </div>
                            </div>
                            
                            
                            <div class="control-group">
                                <label class="control-label" for="postcode-input">Post Code</label>
                                <div class="controls">
                                    <input type="text" id="txtPostCode" name="txtPostCode" class="input-xlarge" value="<?php print($post_code);?>" />
                                </div>
                            </div>
                            
                           <div class="control-group">
                                <label class="control-label" for="addressline1-input">Address Line 1</label>
                                <div class="controls">
                                    <input type="text" id="txtAddressLine1" name="txtAddressLine1" class="input-xlarge" value="<?php print($address_line1);?>" />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="addressline2-input">Address Line 2</label>
                                <div class="controls">
                                    <input type="text" id="txtAddressLine2" name="txtAddressLine2" class="input-xlarge" value="<?php print($address_line2);?>" />
                                </div>
                            </div>
                            
                            
                            <BR/>
                            <BR/>
                            
                            <div class="control-group">
                                <label class="control-label" for="emailaddress-input">E-Mail Address</label>
                                <div class="controls">
                                    <input type="text" id="txtEmailAddress" name="txtEmailAddress" class="input-xlarge" value="<?php print($email_address);?>" />
                                </div>
                            </div>
                            
                            
                            
                            <div class="control-group">
                                <label class="control-label" for="password-input">Password</label>
                                <div class="controls">
                                    <input type="password" id="txtPassword" name="txtPassword" class="input-xlarge" value="" />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="confirmpassword-input">Confirm Password</label>
                                <div class="controls">
                                    <input type="password" id="txtCPassword" name="txtCPassword" class="input-xlarge" value="" />
                                </div>
                            </div>


                            <div class="form-actions">
                                <input type="hidden" id="txtMemberId" name="txtMemberId" class="input-xlarge" value="<?php print($memberId);?>" />
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


<?php include 'includes/panel/footer.php'; ?>

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