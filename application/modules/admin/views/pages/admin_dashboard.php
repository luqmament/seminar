<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Small boxes (Stat box) -->
        <div class="row">
            <?php if($reg_count){ ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>
                            <?php echo $reg_count; ?>
                        </h3>
                        <p>
                            User Registration
                        </p>
                    </div>
                    <div class="icon">
                        <i class="icon icon-bag"></i>
                    </div>
                    <a href="<?php echo site_url('admin/admin/approval_reg')?>" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
            <?php }  if($redeem_count){ ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>
                            <?php echo $redeem_count; ?>
                        </h3>
                        <p>
                            Redemption Request
                        </p>
                    </div>
                    <div class="icon">
                        <i class="icon icon-bag"></i>
                    </div>
                    <a href="<?php echo site_url('admin/admin/approval_gift_request_list')?>" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
            <?php } if($changeAgent_count){ ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>
                            <?php echo $changeAgent_count; ?>
                        </h3>
                        <p>
                            Change Agent
                        </p>
                    </div>
                    <div class="icon">
                        <i class="icon icon-bag"></i>
                    </div>
                    <a href="admin/admin/approval_agent_list" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
            <?php } ?>
        </div><!-- /.row -->
    </section><!-- /.content -->
</aside>