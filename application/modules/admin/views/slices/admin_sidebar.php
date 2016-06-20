
<style>
ul{
list-style: none;
}
.dropdown-menu{
display: none;
}
.dropdown:hover{
background-color: #00CCFF;
}
.dropdown:hover .dropdown-menu {
display: block;
left:217px;
top:-2px;
}
</style>
<aside class="left-side sidebar-off canvas">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url(); ?>assets/img/avatar3.png" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>
                    Hello, <?php  $session_data = $this->session->userdata('CMS_logged_in'); echo $session_data['username'] ?>
                </p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li>
                <a href="<?php echo base_url(); ?>admin">
                    <i class="fa fa-home"></i><span>Dashboard</span>
                </a>
            </li>
            
            <!--user-->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user"></i> 
                    <span>Member</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo base_url(); ?>admin/admin/approved_user_list">
                            <i class="fa fa-angle-double-right"></i> <span>Agent User List</span>
                        </a>
                    </li>                    
                    <li>
                        <a href="<?php echo base_url(); ?>admin/admin/approval_reg">
                            <i class="fa fa-angle-double-right"></i><span>Approve Registration</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>admin/admin/tipe_memberList">
                            <i class="fa fa-angle-double-right"></i> <span>Type of Member</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--End user-->
            
            <!--Agent-->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-briefcase "></i> 
                    <span>Agent</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo base_url(); ?>admin/agent">
                            <i class="fa fa-angle-double-right"></i> <span>Agent</span>
                        </a>
                    </li>                    
                    <li>
                        <a href="<?php echo base_url(); ?>admin/admin/approval_agent_list">
                            <i class="fa fa-angle-double-right"></i><span>Approve Change Agent</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--End Agent-->
            
            <!--Gift-->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-gift"></i> 
                    <span>Gift</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo base_url(); ?>admin/gift/list_gift">
                            <i class="fa fa-angle-double-right"></i> <span>Gift List</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>admin/gift_option/list_gift_option">
                            <i class="fa fa-angle-double-right"></i> <span>Gift List Option</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>admin/admin/approval_gift_request_list">
                            <i class="fa fa-angle-double-right"></i> <span>Redemption Request</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--End Gift-->
            
            <!--History-->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-history"></i> 
                    <span>History</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>            
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo base_url(); ?>admin/history/list_history">
                            <i class="fa fa-angle-double-right"></i> <span>Agent User History</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>admin/transaction/list_transaction">
                            <i class="fa fa-angle-double-right"></i> <span>History Hotel Bookings</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>admin/down">
                            <i class="fa fa-angle-double-right"></i> <span>From PS (PowerSuite)</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>admin/testimonial/list_testimonial">
                            <i class="fa fa-angle-double-right"></i> <span>Testimonial</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End History-->
            <li>
                <a href="<?php echo base_url(); ?>admin/sales/list_sales">
                    <i class="fa fa-group"></i> <span>Sales List</span>
                </a>
            </li>
            <!--Promo-->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-calendar"></i> 
                    <span>Fitur Promo</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>            
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo base_url(); ?>admin/promo">
                            <i class="fa fa-angle-double-right"></i> <span>Promo Point Reward</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>admin/promo/list_promo">
                            <i class="fa fa-angle-double-right"></i> <span>list Promo</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>admin/promo/city_promo">
                            <i class="fa fa-angle-double-right"></i> <span>City Promo</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>admin/promo_game">
                            <i class="fa fa-angle-double-right"></i> <span>Promo Game</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>admin/promo_game/detail_promo_game">
                            <i class="fa fa-angle-double-right"></i> <span>Detail Promo Game</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Promo-->
            <li>
                <a href="<?php echo base_url(); ?>admin/slider">
                    <i class="fa fa-flag"></i> <span>Setting a Banner</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>admin/performance">
                    <i class="fa fa-file-excel-o"></i> <span>Report Performance</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>