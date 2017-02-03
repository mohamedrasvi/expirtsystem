<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>Administration Panel - <?php print(SITE_NAME);?></title>


        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">

        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="icon" href="<?php print($siteBaseUrl);?>favicon.ico" type="image/x-icon"/>

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="apple-touch-icon" href="<?php print($siteBaseUrl);?>contents/admin/<?php print($siteBaseUrl);?>contents/admin/img/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="57x57" href="<?php print($siteBaseUrl);?>contents/admin/<?php print($siteBaseUrl);?>contents/admin/img/apple-touch-icon-57x57-precomposed.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php print($siteBaseUrl);?>contents/admin/<?php print($siteBaseUrl);?>contents/admin/img/apple-touch-icon-72x72-precomposed.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php print($siteBaseUrl);?>contents/admin/<?php print($siteBaseUrl);?>contents/admin/img/apple-touch-icon-114x114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?php print($siteBaseUrl);?>contents/admin/<?php print($siteBaseUrl);?>contents/admin/img/apple-touch-icon-precomposed.png">
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

        <!-- Load a specific file here from <?php print($siteBaseUrl);?>contents/admin/css/themes/ folder to alter the default theme of all the template -->

        <!-- The themes stylesheet of this template (for using specific theme color in individual elements (must included last) -->
        <link rel="stylesheet" href="<?php print($siteBaseUrl);?>contents/admin/css/themes.css">
        <!-- END Stylesheets -->

        <!-- Modernizr (Browser feature detection library) & Respond.js (Enable responsive CSS code on browsers that don't support them) -->
        <script src="<?php print($siteBaseUrl);?>contents/admin/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>

    <!-- Add the class .fixed to <body> for a fixed layout on large resolutions (min: 1200px) -->
    <!-- <body class="fixed"> -->
    <body>
        <!-- Page Container -->
        <div id="page-container">
            <!-- Header -->
            <!-- Add the class .navbar-fixed-top or .navbar-fixed-bottom for a fixed header on top or bottom respectively -->
            <!-- <header class="navbar navbar-inverse navbar-fixed-top"> -->
            <!-- <header class="navbar navbar-inverse navbar-fixed-bottom"> -->
            <header class="navbar navbar-inverse">
                <!-- Navbar Inner -->
                <div class="navbar-inner remove-radius remove-box-shadow">
                    <!-- div#container-fluid -->
                    <div class="container-fluid">
                        <!-- Mobile Navigation, Shows up  on smaller screens -->
                        <ul class="nav pull-right visible-phone visible-tablet">
                            <li class="divider-vertical remove-margin"></li>
                            <li>
                                <!-- It is set to open and close the main navigation on smaller screens. The class .nav-collapse was added to aside#page-sidebar -->
                                <a href="javascript:void(0)" data-toggle="collapse" data-target=".nav-collapse">
                                    <i class="icon-reorder"></i>
                                </a>
                            </li>
                        </ul>
                        <!-- END Mobile Navigation -->

                        <!-- Logo -->
                        <a href="<?php print($siteAdminBaseUrl);?>" class="brand">
                             <img src="<?php print($siteBaseUrl);?>contents/logos/syslogo.jpg" alt="logo">
                        </a>

                        <!-- Loading Indicator, Used for demostrating how loading of widgets could happen, check main.js - uiDemo() -->
                        <div id="loading" class="hide pull-left"><i class="icon-certificate icon-spin"></i></div>

                        <!-- Header Widgets -->
                        <!-- You can create the widgets you want by replicating the following. Each one exists in a <li> element -->
                        <ul id="widgets" class="nav pull-right">


                            <li class="divider-vertical remove-margin"></li>

                            <!-- User Menu -->
                            <li class="dropdown dropdown-user">
                                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php print($siteBaseUrl);?>contents/admin/img/template/avatar.png" alt="avatar"> <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <!-- Just a button demostrating how loading of widgets could happen, check main.js- - uiDemo() -->
                                    <li>
                                        <a href="javascript:void(0)" class="loading-on"><i class="icon-refresh"></i> Refresh</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <!-- Modal div is at the bottom of the page before including javascript code -->
                                        <a href="<?php print($siteAdminBaseUrl);?>my-account.php"><i class="icon-user"></i> My Profile</a>
                                    </li>
                                    <li>
                                        <a href="<?php print($siteAdminBaseUrl);?>app-setting.php"><i class="icon-wrench"></i> App Settings</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php print($siteAdminBaseUrl);?>logout.php"><i class="icon-lock"></i> Log out</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END User Menu -->
                        </ul>
                        <!-- END Header Widgets -->
                    </div>
                    <!-- END div#container-fluid -->
                </div>
                <!-- END Navbar Inner -->
            </header>
            <!-- END Header -->

            <!-- Inner Container -->
            <div id="inner-container"><!-- Sidebar -->
                <aside id="page-sidebar" class="nav-collapse collapse">
                    <!-- Sidebar search -->
                    
                    <!-- END Sidebar search -->