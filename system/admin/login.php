<?php
include '../config/db_con.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$username = '';
$userPassword = '';

if($_POST){
    
    
    $username       = $_POST['login-email'];
    $userPassword   = $_POST['login-password'];
    $encPassword = md5($userPassword);
    
    $SQL_USER = "SELECT * FROM tbl_user WHERE username = '".$username."' AND password_2 = '".$encPassword."'";
    $RS_USER  = mysql_query($SQL_USER) or die(mysql_error());
    $ROW_USER = mysql_fetch_assoc($RS_USER);
    if($ROW_USER){
       $userId = $ROW_USER['id'];
       $userFullName = $ROW_USER['fullname'];
       $_SESSION['admin'] = 'Yes';
       $_SESSION['adminId'] = $userId;
       $_SESSION['adminFullName'] = $userFullName;
       
       header('Location: index.php');
        
    } else {
        header('Location: login.php?error=1');
    }
    
    
    
}



?>
<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">

        <title>Login - Administration Panel - <?php print(SITE_NAME);?></title>

        <meta name="description" content="PlusPro Billing System - Admin Login">
        <meta name="author" content="PlusPro">
        <meta name="robots" content="noindex, nofollow">

        <meta name="viewport" content="width=device-width,initial-scale=1">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
         <link rel="icon" href="<?php print($siteBaseUrl);?>favicon.ico" type="image/x-icon"/>
        <link rel="apple-touch-icon" href="<?php print($siteBaseUrl);?>contents/admin/img/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="57x57" href="<?php print($siteBaseUrl);?>contents/admin/img/apple-touch-icon-57x57-precomposed.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php print($siteBaseUrl);?>contents/admin/img/apple-touch-icon-72x72-precomposed.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php print($siteBaseUrl);?>contents/admin/img/apple-touch-icon-114x114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?php print($siteBaseUrl);?>contents/admin/img/apple-touch-icon-precomposed.png">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- The roboto font is included from Google Web Fonts -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,400italic,700,700italic">

        <!-- Bootstrap 2.3.2 is included in its original form, unaltered -->
        <link rel="stylesheet" href="<?php print($siteBaseUrl);?>contents/admin/css/bootstrap.css">

        <!-- Related styles of various javascript plugins -->
        <link rel="stylesheet" href="<?php print($siteBaseUrl);?>contents/admin/css/plugins.css">

        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <link rel="stylesheet" href="<?php print($siteBaseUrl);?>contents/admin/css/main.css">
        <!-- END Stylesheets -->

        <!-- Modernizr (Browser feature detection library) & Respond.js (Enable responsive CSS code on browsers that don't support them) -->
        <script src="<?php print($siteBaseUrl);?>contents/admin/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>

    <body class="login">
        <!-- Login Container -->
        <div id="login-container">
            <div id="login-logo">
                <a href="">
                     <img src="<?php print($siteBaseUrl);?>contents/logos/syslogo.jpg" alt="logo">
                </a>
            </div>

          <!-- Login Buttons -->
            <div id="login-buttons">
                <h5 class="page-header-sub">Administrator Login</h5>
                        <!-- Login Form -->
            <form id="login-form" action="" method="post" class="form-inline">
                
                <div class="control-group">
                    <div class="input-append">
                        <input type="text" id="login-email" name="login-email" placeholder="Username..">
                        <span class="add-on"><i class="icon-user"></i></span>
                    </div>
                </div>
                <div class="control-group">
                    <div class="input-append">
                        <input type="password" id="login-password" name="login-password" placeholder="Password..">
                        <span class="add-on"><i class="icon-asterisk"></i></span>
                    </div>
                </div>
                <div class="control-group remove-margin clearfix">
                    <div class="btn-group pull-right">
                        <button id="login-button-pass" class="btn btn-small btn-warning" data-toggle="tooltip" title="Forgot pass?"><i class="icon-lock"></i></button>
                        <button class="btn btn-small btn-success"><i class="icon-arrow-right"></i> Login</button>
                    </div>
                    
                </div>
            </form>
            <!-- END Login Form -->
            </div>
            <!-- END Login Buttons -->

    
        </div>
        <!-- END Login Container -->

        <!-- Jquery library from Google ... -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <!-- ... but if something goes wrong get Jquery from local file -->
        <script>!window.jQuery && document.write(unescape('%3Cscript src="js/vendor/jquery-1.9.1.min.js"%3E%3C/script%3E'));</script>

        <!-- Bootstrap.js -->
        <script src="<?php print($siteBaseUrl);?>contents/admin/js/vendor/bootstrap.min.js"></script>

        <!--
        Include Google Maps API for global use.
        If you don't want to use  Google Maps API globally, just remove this line and the gmaps.js plugin from js/plugins.js (you can put it in a seperate file)
        Then iclude them both in the pages you would like to use the google maps functionality
        -->


        <!-- Jquery plugins and custom javascript code -->
        <script src="<?php print($siteBaseUrl);?>contents/admin/js/plugins.js"></script>
        <script src="<?php print($siteBaseUrl);?>contents/admin/js/main.js"></script>

        <!-- Javascript code only for this page -->
        
    </body>
</html>
