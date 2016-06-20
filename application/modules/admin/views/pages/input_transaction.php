<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Input Transaction
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Transaction Table</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <form method="post" id="form" name="form" action="<?php echo base_url(); ?>admin/transaction/insert">
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
                                <div class="col-md-4"><span style="color:red">* </span>User :</div>
                                <div class="form-inline">
                                    <div class="col-md-6">
                                        <input type="hidden" name="user" id="user" value="<?php echo set_value('user') ?>"/>
                                        <input type="text" class="form-control" readonly id="username" name="username" value="<?php echo set_value('username') ?>"/>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                            List
                                        </button>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" style="width:850px">
                                            <div style="width:850px" class="modal-content" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; height: 100%; padding: 0px;">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">User</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <iframe style="width:800px;height:500px" scrolling="no" frameBorder="0" src="<?php echo base_url() ?>admin/transaction/show_user"></iframe>
                                                </div>
                                                <div class="modal-footer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                                    <select id="user" name="user">
                                    <?php // foreach($user as $item){ ?>
                                                                                                <option value="<?php // echo $item->id;        ?>"><?php echo $item->name; ?></option>
                                    <?php // } ?>
                                                                                        </select>-->
                                </div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-4"><span style="color:red">* </span>Hotel :</div>
                                <div class="col-md-4"><input type="text" class="form-control" id="hotel" name="hotel" value="<?php echo set_value('hotel') ?>"/></div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-4">Room :</div>
                                <div class="col-md-2">
                                    <select class="form-control" id="room" name="room">
                                        <?php
                                            for($i=1;$i<=10;$i++){
                                                echo '<option value="'.$i.'">'.$i.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-4">Night :</div>
                                <div class="col-md-2">
                                    <select class="form-control" id="night" name="night">
                                         <?php
                                            for($i=1;$i<=31;$i++){
                                                echo '<option value="'.$i.'">'.$i.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-4"><span style="color:red">* </span>Date Range :</div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="reservation" name="reservation" value="<?php echo set_value('reservation') ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-12">
                                    <span style="color:red">* </span>Required
                                </div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-4"></div>
                                <div class="col-md-8"><input type="submit" class="btn btn-primary" id="submit" name="submit" value="submit"/></div>
                            </div>                        
                        </form>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside>