<div class="form-box"  style="width:70%;margin:30px auto 0 auto">
    <div class="header">User Registration</div>
    <form action="<?php echo base_url(); ?>user/user/user_reg" name="form" id="form" method="post">
        <div class="body">
            <div class="form-group">
                <div class="col-md-12">
                    <span style="color:red">
                        <?php
                        echo validation_errors('<li>', '</li>');
                        ?>
                    </span>
                </div>                
            </div>
            <div class="form-group bg-gray">
                <label class="col-md-3 control-label"><span style="color:red">*</span> Name :</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name') ?>"/>
                </div>
            </div>
            <div class="form-group bg-gray">
                <label class="col-md-3 control-label"><span style="color:red">*</span> Address :</label>
                <div class="col-md-9">
                    <textarea id="address" class="form-control" name="address"><?php echo set_value('address') ?></textarea>
                </div>
            </div>
            <div class="form-group bg-gray">
                <label class="col-md-3 control-label"><span style="color:red">*</span> City :</label>
                <div class="col-md-9"><input class="form-control" type="text" id="city" name="city" value="<?php echo set_value('city') ?>"/></div>
            </div>
            <div class="form-group bg-gray">
                <label class="col-md-3 control-label"><span style="color:red">*</span> Phone :</label>
                <div class="col-md-9"><input type="text" class="form-control" id="phone" name="phone" value="<?php echo set_value('phone') ?>"/></div>
            </div>
            <div class="form-group bg-gray">
                <label class="col-md-3 control-label"><span style="color:red">*</span> ID Number :</label>
                <div class="col-md-9"><input type="text" class="form-control" id="id_number" name="id_number" value="<?php echo set_value('id_number') ?>"/></div>
            </div>
            <div class="form-group bg-gray">
                <label class="col-md-3 control-label"><span style="color:red">*</span> Birth Date :</label>
                <div class="col-md-9"><input type="text" class="form-control" id="birthdate" name="birthdate" value="<?php echo set_value('birthdate') ?>"/></div>
            </div>
            <div class="form-group bg-gray">
                <label class="col-md-3 control-label"><span style="color:red">*</span> Gender :</label>
                <div class="col-md-9">
                    <select id="genre" class="form-control" name="genre">
                        <option value="male">male</option>
                        <option value="female">female</option>
                    </select>
                </div>
            </div>
            <div class="form-group bg-gray">
                <label class="col-md-3 control-label"><span style="color:red">*</span> Email :</label>
                <div class="col-md-9"><input type="text" class="form-control" id="email" name="email" value="<?php echo set_value('email') ?>"/></div>
            </div>
            <div class="form-group bg-gray">
                <label class="col-md-3 control-label"><span style="color:red">*</span> MG User ID :</label>
                <div class="col-md-9"><input type="text" class="form-control" id="mg_user_id" name="mg_user_id" value="<?php echo set_value('mg_user_id') ?>"/></div>
            </div>
            <div class="form-group bg-gray">
                <label class="col-md-3 control-label"><span style="color:red">*</span> Transaction User ID :</label>
                <div class="col-md-9"><input type="text" class="form-control" id="trans_user_id" name="trans_user_id" value="<?php echo set_value('trans_user_id') ?>"/></div>
            </div>
            <div class="form-group bg-gray">
                <label class="col-md-3 control-label"><span style="color:red">*</span> Password :</label>
                <div class="col-md-9"><input type="password" class="form-control" id="password" name="password" value="<?php echo set_value('password') ?>"/></div>
            </div>
            <div class="form-group bg-gray">
                <label class="col-md-3 control-label"><span style="color:red">*</span> Agent :</label>
                <div class="col-md-9">
                    <input type="hidden" id="agent" name="agent" value="<?php echo set_value('agent') ?>"/>
                    <input type="text" class="form-control" id="agentname" name="agentname" value="<?php echo set_value('agentname') ?>"/>
                </div>
            </div>
            <div class="form-group bg-gray">
                <label class="col-md-3 control-label"><span style="color:red">*</span> Required</label>
                <div class="col-md-9"></div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    </br>
                </div>                
            </div>
        </div>        
        <div class="footer">                                                               
            <input type="submit" class="btn bg-olive btn-block" value="Register"/>  
        </div>
    </form>
</div>
<div  class="bg-black" style="height:30px">
</div>