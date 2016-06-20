<div class="form-box"  style="width:70%;margin:30px auto 0 auto">
    <div class="header">Reset Password</div>
    <form action="<?php echo base_url(); ?>user/user/do_reset_user_password" name="form" id="form" method="post">
        <div class="body">
            <div class="form-group">
                <div class="col-md-12">
                    <span style="color:red">
                        <?php
                        echo validation_errors();
                        ?>
                    </span>
                </div>                
            </div>
            <div class="form-group bg-gray">
                <div class="col-md-9">
                    <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id; ?>"/>
                </div>
            </div>
            <div class="form-group bg-gray">
                <div class="col-md-9">
                    <input type="hidden" class="form-control" id="token" name="token" value="<?php echo $token; ?>"/>
                </div>
            </div>
            <div class="form-group bg-gray">
                <div class="col-md-12">
                    <input type="password" class="form-control" id="new_password" placeholder="New Password" name="new_password" value="<?php echo set_value('new_password') ?>"/>
                </div>
            </div>
            <div class="form-group bg-gray">
                <div class="col-md-12">
                    <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" name="confirm_password"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    </br>
                </div>                
            </div>
        </div>        
        <div class="footer">                                                               
            <input type="submit" class="btn bg-olive btn-block" value="Reset"/>  
        </div>
    </form>
</div>
<div  class="bg-black" style="height:30px">
</div>