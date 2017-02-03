<?php
include '../config/db_con.php';
include 'includes/auth.php';
$currentDate = date('Y-m-d H:i:s');

$dmianId = $_GET['id'];
$SQL_DOMAIN = "SELECT * FROM tbl_domains WHERE id = '".$dmianId."'";
$RS_DOMAIN = mysql_query($SQL_DOMAIN) or die(mysql_error());
$ROW_DOMAIN = mysql_fetch_assoc($RS_DOMAIN);

$id             = $ROW_DOMAIN['id']; 
$domain_name    = $ROW_DOMAIN['domain_name']; 
$post_code      = $ROW_DOMAIN['post_code']; 
$city_id        = $ROW_DOMAIN['city_id']; 
$region_id      = $ROW_DOMAIN['region_id']; 
$country_id     = $ROW_DOMAIN['country_id']; 
$added_on       = $ROW_DOMAIN['added_on']; 
$updated_on     = $ROW_DOMAIN['updated_on'];

$SQL_COUNTRY = "SELECT * FROM countries";
$RS_COUNTRY = mysql_query($SQL_COUNTRY);

$SQL_REGION = "SELECT * FROM regions WHERE country_id = '".$country_id."'";
$RS_REGION = mysql_query($SQL_REGION);

$SQL_CITY = "SELECT * FROM cities WHERE region_id = '".$region_id."' OR country_id = '".$country_id."'";
$RS_CITY = mysql_query($SQL_CITY);


if($_POST){
    
    $domainId = $_POST['txtId'];
    $countryId = $_POST['cmbCountry'];
    $regionId = $_POST['cmbRegion'];
    $cityId = $_POST['cmbCity'];
    $postCode = $_POST['txtPostCode'];
    
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
    if($cityId == ""){
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
            $theCityId = $cityId;
        }
        
    } else {
        $theCityId = $cityId;
    }
    
    
    $SQL_UPDATE_DOMAIN = "UPDATE `tbl_domains` SET 
        `post_code` = '".$postCode."', 
        `city_id` = '".$theCityId."', 
        `region_id` = '".$theRegionId."', 
        `country_id` = '".$countryId."', 
        `updated_on` = '".$currentDate."' 
        WHERE `id` = '".$domainId."'";
    
    
    $RS_NEW_CITY = mysql_query($SQL_UPDATE_DOMAIN) or die(mysql_error());
    header('Location: domains.php');
    
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
        <li><a href="#">Domains</a></li>
        <li class="active"><a href="#">All Domains</a></li>
    </ul>
    <!-- END Navigation info -->








    <h3 class="page-header page-header-top">Edit Domain</h3>

    
              <!-- Text Inputs -->
                    <form class="form-horizontal form-box remove-margin" method="post" action="" id="form-validation" novalidate="novalidate">
                        <h4 class="form-box-header">Domain Details</h4>
                        <div class="form-box-content">
                            
                            
                            
                            <div class="control-group">
                                <label class="control-label" for="firstname-input">Domain Name</label>
                                <div class="controls">
                                    <input type="text" id="txtDomainName" name="txtDomainName" class="input-xlarge" value="<?php print($domain_name);?>" />
                                </div>
                            </div>
                            
                            
                            <div class="control-group">
                                <label class="control-label" for="status-input">Country</label>
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
                                <label class="control-label" for="status-input">Region</label>
                                <div class="controls">
                                    <span id="div_region">
                                    <select id="cmbRegion" name="cmbRegion" class="input-xlarge" onchange="showCity();">
                                         <option value=""></option>
                                         <?php while($region_row = mysql_fetch_array($RS_REGION)){?>
                                         <option value="<?php print($region_row['id']);?>" <?php if($region_id == $region_row['id']){?> selected="selected" <?php } ?> ><?php print($region_row['name']);?></option>
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
                                <label class="control-label" for="status-input">City</label>
                                <div class="controls">
                                    <span id="div_city">
                                    <select id="cmbCity" name="cmbCity" class="input-xlarge">
                                         <option value=""></option>
                                         <?php while($city_row = mysql_fetch_array($RS_CITY)){?>
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
                                <label class="control-label" for="lastname-input">Post Code</label>
                                <div class="controls">
                                    <input type="text" id="txtPostCode" name="txtPostCode" class="input-xlarge" value="<?php print($post_code);?>" />
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
                                    <input readonly="readonly" type="text" id="txtUpdatedOn" name="txtUpdatedOn" class="input-xlarge" value="<?php print($updated_on);?>" />
                                </div>
                            </div>


                            <div class="form-actions">
                                <input type="hidden" name="txtId" value="<?php print($id);?>" />
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