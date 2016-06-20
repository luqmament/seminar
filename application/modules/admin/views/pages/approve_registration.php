<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Approve Registration User
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">User Table</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="tbl" class="table table-bordered table-hover dataTable">
                            <thead>
                                <tr>
                                    <th>Agent Code</th>
                                    <th>Agent Name</th>
                                    <th>MG User ID</th>
                                    <th>Email</th>
                                    <th>Regis Date</th>
                                    <th>Rekomend By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside>

<!-- Modal Update-->
<div class="modal fade" id="ApproveRegister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Registration User</h4>
      </div>
        <div class="modal-body">
        <?php echo form_open_multipart(site_url('admin/admin/aprrove_register'), array("id" => "form-aprrove-user", "class" => "form-horizontal", "enctype" => "multipart/form-data", "method" => "POST")); ?>
            <input class="form-control" type="hidden" name="id" id="id" readonly="true">           
            <!--<div class="form-group">
                <label for="ID" class="col-sm-3 control-label">ID User</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="id" id="id" readonly="true">
                </div>
            </div>
            <div class="form-group">
                <label for="ID" class="col-sm-3 control-label">Name</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="u_name" id="u_name" readonly="true">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="address">Address</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="u_address" name="u_address" readonly="true"></textarea>
                </div>
            </div>        
            <div class="form-group">
                <label class="col-sm-3 control-label" for="City">City</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="u_city" id="u_city" readonly="true">
                </div>
            </div>               
            <div class="form-group">
                <label class="col-sm-3 control-label" for="phone">Phone</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="u_phone" id="u_phone" readonly="true">
                </div>
            </div>                      
            <div class="form-group">
                <label class="col-sm-3 control-label" for="id Number">ID Number</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="u_idNumber" id="u_idNumber" readonly="true">
                </div>
            </div>                      
            <div class="form-group">
                <label class="col-sm-3 control-label" for="birthDate">Birth date</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="u_birthDate" id="u_birthDate" readonly="true">
                </div>
            </div>                              
            <div class="form-group">
                <label class="col-sm-3 control-label" for="gender">Gender</label>
                <!-ditutup <input type="radio" name="gender" id="male" value="male"> Male | <input type="radio" name="gender" id="female" value="female"> female 
                <div class="radio">
                    <label class="radio-inline">
                        <input type="radio" name="gender" id="male" value="male" disabled> Male
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="gender" id="female" value="female" disabled> female
                    </label>
                </div>
            </div>  --> 
            <div class="form-group">
                <label class="col-sm-3 control-label" for="agent">Agent code</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="u_agentCode" id="u_agentCode" readonly="true" readonly="true">
                </div>
            </div>                 
            <div class="form-group">
                <label class="col-sm-3 control-label" for="agent">Agent name</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="u_agentName" id="u_agentName" readonly="true" readonly="true">
                </div>
            </div>                         
            <div class="form-group">
                <label class="col-sm-3 control-label" for="email">Email</label>
                <div class="col-sm-9">
                    <input class="form-control" type="email" name="u_email" id="u_email" readonly="true" readonly="true">
                </div>
            </div>                              
            <div class="form-group">
                <label class="col-sm-3 control-label" for="MG_user_ID">MG User ID</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="u_MG_user_ID" id="u_MG_user_ID" readonly="true">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="area">Area</label>
                <div class="col-sm-9" id="listArea">
                    
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="MG_user_ID">Email Rekomend</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="u_EmailRekomend" id="u_EmailRekomend" readonly="true">
                </div>
            </div>
            <!--
            <div class="form-group">
                <label class="col-sm-3 control-label">User Picture</label>
                <div class="col-sm-9" id="Upload">
                    <div class="fileUpload btn btn-warning">
                        <span>Pilih Photo</span>
                        <input type="file" name="image_picture" class="upload" id="upload" onchange="ValidateFileUpload(this, 'upload', 'images','image_user');" disabled />	    
                    </div>
                    <br/><br/>
                    <span id="image_user" style="display: none">
                        <img id="images" class="img-thumbnail" width="100" height="100" />
                    </span>
                </div>
            </div> -->
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Aprrove Register</button>
      </div>
      <?php echo form_close();?>
    </div> 
  </div>
</div>