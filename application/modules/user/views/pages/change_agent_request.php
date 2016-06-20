<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Change Agent
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Change Agent Table</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <form method="post" id="form" name="form" action="<?php echo base_url(); ?>user/user/add_change_agent_request">
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
                                <div class="col-md-4">Old Agent :</div>
                                <div class="col-md-8">
                                    <input type="hidden" id="oldagent" name="oldagent" value="<?php echo $oldagent; ?>"/>
                                    <?php echo $oldagentname; ?>                                            
                                </div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-4"><span style="color:red">* </span>New Agent :</div>
                                <div class="col-md-8">
                                    <input type="hidden" id="newagent" name="newagent" value="<?php echo set_value('newagent') ?>"/>
                                    <input type="text" id="newagentname" name="newagentname" value="<?php echo set_value('newagentname') ?>"/>
                                </div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-4">Old MG User ID :</div>
                                <div class="col-md-8">
                                    <input type="hidden" id="oldmg_user_id" name="oldmg_user_id" value="<?php echo $oldmg_user_id; ?>"/>
                                    <?php echo $oldmg_user_id; ?>                                            
                                </div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-4"><span style="color:red">* </span>New MG User ID :</div>
                                <div class="col-md-8"><input type="text" id="newmg_user_id" name="newmg_user_id" value="<?php echo set_value('newmg_user_id') ?>"/></div>
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