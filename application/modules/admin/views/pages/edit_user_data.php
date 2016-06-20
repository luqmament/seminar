<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User List
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">User</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <form id="form" name="form" method="post" action="<?php echo base_url(); ?>admin/admin/update_user">
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
                                <div class="col-md-4"></div>
                                <div class="col-md-8"><input type="hidden" id="id" name="id" value="<?php echo $user_data->id; ?>"/></div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-4"><span style="color:red">* </span>Name :</div>
                                <div class="col-md-8"><input type="text" id="name" name="name" value="<?php echo $user_data->name; ?>"/></div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-4"><span style="color:red">* </span>Address :</div>
                                <div class="col-md-8">
                                    <textarea id="address" name="address"><?php echo $user_data->address; ?></textarea>
                                </div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-4"><span style="color:red">* </span>City :</div>
                                <div class="col-md-8"><input type="text" id="city" name="city" value="<?php echo $user_data->city; ?>"/></div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-4"><span style="color:red">* </span>Phone :</div>
                                <div class="col-md-8"><input type="text" id="phone" name="phone" value="<?php echo $user_data->phone; ?>"/></div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-4"><span style="color:red">* </span>ID Number :</div>
                                <div class="col-md-8"><input type="text" id="id_number" name="id_number" value="<?php echo $user_data->id_number; ?>"/></div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-4"><span style="color:red">* </span>Birth Date :</div>
                                <div class="col-md-8"><input type="text" id="birthdate" name="birthdate" value="<?php echo date("m/d/Y",  strtotime($user_data->birthdate)); ?>"/></div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-4"><span style="color:red">* </span>Gender :</div>
                                <div class="col-md-8">
                                    <select id="genre" name="genre">
                                        <option value="male" <?php
                                        if ($user_data->genre == 'male') {
                                            echo 'selected';
                                        }
                                        ?>>male</option>
                                        <option value="female" <?php
                                        if ($user_data->genre == 'female') {
                                            echo 'selected';
                                        }
                                        ?>>female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-4"><span style="color:red">* </span>Agent :</div>
                                <div class="col-md-8">
                                    <input type="hidden" id="agent" name="agent" value="<?php echo $user_data->agent; ?>"/>
                                    <input type="text" id="agentname" name="agentname" value="<?php echo $agent_data->name; ?>"/>
                                </div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-4"><span style="color:red">* </span>Email :</div>
                                <div class="col-md-8"><input type="text" id="email" name="email" value="<?php echo $user_data->email; ?>"/></div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-4"><span style="color:red">* </span>MG User ID :</div>
                                <div class="col-md-8"><input type="text" id="mg_user_id" name="mg_user_id" value="<?php echo $user_data->mg_user_id; ?>"/></div>
                            </div>
                            <div class="row box-body">
                                <div class="col-md-12"><span style="color:red">*</span> Required</div>
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