<header class="header">
    <a href="#" class="logo">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        Point Reward
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#">
                        <span>Jumlah point anda adalah <small style="margin-left:10px" class="badge pull-right bg-yellow"><?php echo $user_data->point; ?></small></span>
                    </a>
                </li>
                <li class="dropdown user user-menu">
                    <a href="<?php echo base_url(); ?>user/user/request_change_agent">
                        <span>Profile</span>
                    </a>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="<?php echo base_url(); ?>user/user/logout">
                        <span>Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>