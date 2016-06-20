<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Input Agent
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Agent Table</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <form method="post" id="form" name="form" action="<?php echo base_url(); ?>admin/agent/insert">                            
                            <div class="row box-body">
                                <div class="col-md-12">
                                    <span style="color:red">
                                        <?php
                                        echo validation_errors();
                                        ?>
                                    </span>
                                </div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-4"><span style="color:red">* </span>Name :</div>
                                <div class="col-md-8"><input type="text" id="name" name="name" value="<?php echo set_value('name'); ?>"/></div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-4"><span style="color:red">* </span>Email :</div>
                                <div class="col-md-8"><input type="text" id="email" name="email" value="<?php echo set_value('email'); ?>"/></div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-12">
                                    <span style="color:red">* </span>Required
                                </div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-4"></div>
                                <div class="col-md-8"><input type="submit" id="submit" name="submit" value="submit"/></div>
                            </div>                        
                        </form>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside>