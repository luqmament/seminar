<aside class="left-side sidebar-offcanvas">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url(); ?>assets/img/avatar3.png" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>
                    Hello, 
                    <?php echo $user; ?>
                </p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li>
                <a href="<?php echo base_url(); ?>user">
                    <i class="fa fa-table"></i><span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>user/user/gift_request_list">
                    <i class="fa fa-table"></i> <span>Redemption</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>user/user/view_user_transaction_list">
                    <i class="fa fa-table"></i> <span>Transaction</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>