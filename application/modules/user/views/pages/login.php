<div class="form-box" id="login-box">
    <div class="header">Sign In</div>
    <form action="<?php echo base_url(); ?>user/do_login" name="form" id="form" method="post">
        <div class="body bg-gray">
            <div class="form-group">
                <span style="color:red">
                    <?php
                    echo validation_errors();
                    ?>
                </span>
            </div>
            <div class="form-group">
                <input type="text" name="username" id="username" class="form-control" placeholder="User Email"/>
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password"/>
            </div>          
            <div class="form-group">
                <input type="checkbox" name="remember_me"/> Remember me
            </div>
        </div>
        <div class="footer">                                                               
            <input type="submit" class="btn bg-olive btn-block" value="Submit"/>
            <p class="pull-right">
                <a href="<?php echo base_url(); ?>user/user/forgot_password">Forgot password</a>
            </p>
            <p>
                <a href="<?php echo base_url(); ?>user/user/register">Register</a>
            </p>
        </div>
    </form>
</div>