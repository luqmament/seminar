<div class="form-box"  style="width:70%;margin:30px auto 0 auto">
    <div class="header">Input Email</div>
    <form action="<?php echo base_url(); ?>user/user/token_generate" name="form" id="form" method="post">
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
                <label class="col-md-3 control-label"><span style="color:red">*</span> Email :</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="email" name="email" value="<?php echo set_value('email') ?>"/>
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
            <input type="submit" class="btn bg-olive btn-block" value="Reset"/>  
        </div>
    </form>
</div>
<div  class="bg-black" style="height:30px">
</div>