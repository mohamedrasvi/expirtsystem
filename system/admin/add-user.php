<?php
include '../config/db_con.php';
include 'includes/auth.php';
$currentDate = date('Y-m-d H:i:s');

$userId = '';
$username = '';
$password_2 = '';
$user_type = '';
$email = '';
$fullname = '';
$is_enabled = '';

if($_POST){
    
    $userId             = NULL;
    $username           = $_POST['txtUsername'];
    $password_2         = $_POST['txtPassword'];
    $user_type          = 'Admin';
    $email              = $_POST['txtEmailAddress'];
    $fullname           = $_POST['txtFullName'];
    $is_enabled         = $_POST['cmbEnabled'];  

    $SQL_INSERT = "INSERT INTO `tbl_user` (
        `id`, 
        `username`, 
        `password_2`, 
        `user_type`, 
        `email`, 
        `fullname`, 
        `is_enabled`) VALUES (
        NULL, 
        '".$username."', 
        '".md5($password_2)."', 
        '".$user_type."', 
        '".$email."', 
        '".$fullname."', 
        '".$is_enabled."')";
    
    $rs_update = mysql_query($SQL_INSERT) or die(mysql_error());
    header('Location: users.php?status=added');
    
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
        <li><a href="#">Manage Users</a></li>
        <li><a href="#">Search Users</a></li>
        <li class="active"><a href="#">Add New User</a></li>
    </ul>
    <!-- END Navigation info -->








    <h3 class="page-header page-header-top">Add New User</h3>

    
              <!-- Text Inputs -->
                    <form class="form-horizontal form-box remove-margin" method="post" action="" id="form-validation" novalidate="novalidate" enctype="multipart/form-data">
                        <h4 class="form-box-header">User Details</h4>
                        <div class="form-box-content">
                            
                            
                            
                            <div class="control-group">
                                <label class="control-label" for="firstname-input">Full Name</label>
                                <div class="controls">
                                    <input type="text" id="txtFullName" name="txtFullName" class="input-xlarge" value="" />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="emailaddress-input">E-Mail Address</label>
                                <div class="controls">
                                    <input type="text" id="txtEmailAddress" name="txtEmailAddress" class="input-xlarge" value="" />
                                </div>
                            </div>
                            
                          
                            
                           <div class="control-group">
                                <label class="control-label" for="addressline1-input">Is Enabled</label>
                                <div class="controls">
                                   <select id="cmbEnabled" name="cmbEnabled" class="input-xlarge">
                                         <option value=""></option>
                                          <option value="Yes">Yes</option>
                                           <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                            
                       
                            
                            
                            <BR/>
                            <BR/>
                            
                            <div class="control-group">
                                <label class="control-label" for="emailaddress-input">Username</label>
                                <div class="controls">
                                    <input type="text" id="txtUsername" name="txtUsername" class="input-xlarge" value="" />
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