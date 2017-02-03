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
                        <a href="index.php" class="brand"><img src="contents/logos/syslogo.jpg" alt="logo"></a>

                        <!-- Loading Indicator, Used for demostrating how loading of widgets could happen, check main.js - uiDemo() -->
                        <div id="loading" class="hide pull-left"><i class="icon-certificate icon-spin"></i></div>

                        <!-- Header Widgets -->
                        <!-- You can create the widgets you want by replicating the following. Each one exists in a <li> element -->
                        <ul id="widgets" class="nav pull-right">

                   
                            <?php 
                            $userId = $_SESSION['userId'];
                            $SQL_NOT = "SELECT * FROM tbl_notifications WHERE userId = '".$userId."'";
                            $RS_NOT = mysql_query($SQL_NOT) or die(mysql_error());
                            $RS_TOT = mysql_num_rows($RS_NOT);
                            if($RS_TOT>0) {
                            ?>
                            <!-- Notifications Widget -->
                            <!-- Add .dropdown-center-responsive class to align the dropdown menu center (so its visible on mobile) -->
                            <li id="notifications-widget" class="dropdown dropdown-center-responsive">
                                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                    <span class="badge badge-warning"><?php print($RS_TOT);?></span>
                                </a>
                                <ul class="dropdown-menu widget">
                                    <li class="widget-heading"><a href="javascript:void(0)" class="pull-right widget-link"><i class="icon-cog"></i></a><a href="javascript:void(0)" class="widget-link">System</a></li>
                                <?php while($row_data = mysql_fetch_array($RS_NOT)){?>
                                    <li>
                                        <ul>
                                            <li class="label label-warning"><?php print(getTimeAgo($row_data['added_on']));?></li>
                                            <li class="text-warning"><?php print($row_data['title']);?></li>
                                        </ul>
                                    </li>
                                    <?php } ?>
                                    
                                </ul>
                            </li>
                            <?php } ?>
                            <!-- END Notifications Widget -->

                            <li class="divider-vertical remove-margin"></li>

                             <!-- User Menu -->
                            <li class="dropdown dropdown-user">
                                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><img src="contents/front/img/template/avatar.png" alt="avatar"> <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <!-- Just a button demostrating how loading of widgets could happen, check main.js- - uiDemo() -->
                                    <li>
                                        <a href="javascript:void(0)" class="loading-on"><i class="icon-refresh"></i> Refresh</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <!-- Modal div is at the bottom of the page before including javascript code -->
                                        <a href="profile.php"><i class="icon-user"></i> User Profile</a>
                                    </li>
                                    <li>
                                        <a href="settings.php"><i class="icon-wrench"></i> App Settings</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="logout.php"><i class="icon-lock"></i> Log out</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <!-- END Header Widgets -->
                    </div>
                    <!-- END div#container-fluid -->
                </div>
                <!-- END Navbar Inner -->
            </header>