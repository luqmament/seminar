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
                        <h3 class="box-title">User Table</h3>
                        <span style="float: right; margin: 10px; font-size: 18px; color: blue;">
                            <a href="<?php echo base_url()?>admin/report/report_userList"><i class="fa fa-download"> </i> Download</a>
                        </span>
                    </div><!-- /.box-header -->
                    <div style="padding-left: 11px; margin-right: 10px;">
                        <button type="button" class="btn btn-primary btn-add-pointUser">Add Point User</button>
                        <button type="button" class="btn btn-primary btn-point-ToUser">Point to User</button>
                    </div>
                    <div class="box-body">
                        <table id="tbl" class="table table-bordered table-hover dataTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>City</th>
                                    <th>Agent Code</th>
                                    <th>Agent Name</th>
                                    <th>MG User ID</th>
                                    <th>Email User</th>
                                    <th>Point</th>                                    
                                    <th>Regis date</th>
                                    <th>Approved date</th>
                                    <th>Rekomend By</th>
                                    <th>Status</th>
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
<div class="modal fade" id="ChangeUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Change user profile</h4>
      </div>
        <div class="modal-body">
        <?php echo form_open_multipart(site_url('admin/admin/update_user'), array("id" => "form-update-user", "class" => "form-horizontal", "enctype" => "multipart/form-data", "method" => "POST")); ?>
            <div class="form-group">
                <label for="ID" class="col-sm-3 control-label">ID User</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="id" id="id" readonly="true">
                </div>
            </div>
            <div class="form-group">
                <label for="ID" class="col-sm-3 control-label">Name</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="u_name" id="u_name">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="address">Address</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="u_address" name="u_address"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="City">City</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="u_city" id="u_city" >
                </div>
            </div>  
            <div class="form-group">
                <label class="col-sm-3 control-label" for="Area">Area</label>
                <div class="col-sm-9" id="listArea">
                    <input class="form-control" type="text" name="u_area" id="u_area" >
                </div>
            </div>               
            <div class="form-group">
                <label class="col-sm-3 control-label" for="phone">Phone</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="u_phone" id="u_phone" >
                </div>
            </div>                
            <div class="form-group">
                <label class="col-sm-3 control-label" for="birthDate">Birth date</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="u_birthDate" id="u_birthDate" >
                </div>
            </div>                              
            <div class="form-group">
                <label class="col-sm-3 control-label" for="gender">Gender</label>
                <!-- <input type="radio" name="gender" id="male" value="male"> Male | <input type="radio" name="gender" id="female" value="female"> female -->
                <div class="radio">
                    <label class="radio-inline">
                        <input type="radio" name="gender" id="male" value="male"> Male
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="gender" id="female" value="female"> female
                    </label>
                </div>
            </div>                     
            <div class="form-group">
                <label class="col-sm-3 control-label" for="id Number">Kode Agent</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="u_kodeAgent" id="u_kodeAgent" readonly="true">
                </div>
            </div>                           
            <div class="form-group">
                <label class="col-sm-3 control-label" for="agent">Agent name</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="u_agentName" id="u_agentName" readonly="true">
                </div>
            </div>                         
            <div class="form-group">
                <label class="col-sm-3 control-label" for="email">Email</label>
                <div class="col-sm-9">
                    <input class="form-control" type="email" name="u_email" id="u_email" readonly="true">
                </div>
            </div>                              
            <div class="form-group">
                <label class="col-sm-3 control-label" for="MG_user_ID">MG User ID</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="u_MG_user_ID" id="u_MG_user_ID" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="Nama Bank">Nama Bank</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="U_namaBank" id="U_namaBank" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="Nomor Rekening">Nomor Rekening</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="U_nomorRek" id="U_nomorRek" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="Bank Atas Nama">Bank Atas Nama</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="U_bankAtasNama" id="U_bankAtasNama" >
                </div>
            </div>  
            <div class="form-group">
                <label class="col-sm-3 control-label" for="MG_user_ID">Tipe member user</label>
                <div class="col-sm-9">
                    <select class="form-control" id="u_TipeMember" name="u_TipeMember">
                        <option value="1">Silver Member</option>
                        <option value="2">Gold Member</option>
                        <option value="3">Platinum Member</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">User Picture</label>
                <div class="col-sm-9" id="Upload">
                    <div class="fileUpload btn btn-warning">
                        <span>Pilih Photo</span>
                        <input type="file" name="image_picture" class="upload" id="upload" onchange="ValidateFileUpload(this, 'upload', 'images','image_user');"  />	    
                    </div>
                    <br/><br/>
                    <span id="image_user" style="display: none">
                        <img id="images" class="img-thumbnail" width="100" height="100" />
                    </span>
                </div>
            </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      <?php echo form_close();?>
    </div> 
  </div>
</div>


<!-- Modal Add Point to user && Out Point to user -->
<div class="modal fade" id="user-point" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel-UserPoint">point user</h4>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart(site_url('admin/admin/PointUser'), array("id" => "form-data", "tipe-form-pointUser"=> "add", "class" => "form-horizontal", "enctype" => "multipart/form-data", "method" => "POST")); ?>
        <div class="form-group">
            <label for="ID" class="col-sm-3 control-label">Kode Agent</label>
            <div class="col-sm-9">
                <input class="form-control" type="hidden" name="TipePoint" id="TipePoint" autocomplete="off">
                <input class="form-control" type="text" name="AgentCode" id="AgentCode" autocomplete="off">
            </div>
        </div>
        <div class="form-group">
            <label for="ID" class="col-sm-3 control-label">mg user id</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" name="mg_user_id" id="mg_user_id" autocomplete="off">
            </div>
        </div>
        <div id='col-penerima-point' style="display: none">
        <div class="form-group">
            <label for="ID" class="col-sm-3 control-label">Kode Agent Penerima</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" name="AgentCodeTo" id="AgentCodeTo" autocomplete="off">
            </div>
        </div>
        <div class="form-group">
            <label for="ID" class="col-sm-3 control-label">mg user id Penerima</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" name="mg_user_idTo" id="mg_user_idTo" autocomplete="off">
            </div>
        </div>
        </div>
        
        <div class="form-group">
            <label for="ID" class="col-sm-3 control-label">Point</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" name="point" id="point" onkeypress="return isNumberKey(this)">
            </div>
        </div>
        <div class="form-group">
            <label for="ID" class="col-sm-3 control-label">Notes</label>
            <div class="col-sm-9">
                <textarea class="form-control" type="text" name="notes" id="notes"></textarea>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      <?php echo form_close();?>
    </div> 
    </div> 
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="Change-Password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Change Password</h4>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart(site_url('admin/admin/ChangePassword'), array("id" => "form-data-password", "class" => "form-horizontal", "enctype" => "multipart/form-data", "method" => "POST")); ?>
        <div class="form-group">
            <label for="ID" class="col-sm-3 control-label">ID User</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" name="idUser" id="idUser" readonly="true">
            </div>
        </div>
        <div class="form-group">
            <label for="ID" class="col-sm-3 control-label">Kode Agent</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" name="AgentCodePassword" id="AgentCodePassword" autocomplete="off" readonly=true>
            </div>
        </div>
        <div class="form-group">
            <label for="ID" class="col-sm-3 control-label">mg user id</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" name="MgUserPassword" id="MgUserPassword" autocomplete="off" readonly=true>
            </div>
        </div>
        <div class="form-group">
            <label for="ID" class="col-sm-3 control-label">mg user id</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" name="emailUserPassword" id="emailUserPassword" autocomplete="off" readonly=true>
            </div>
        </div>
        <div class="form-group">
            <label for="ID" class="col-sm-3 control-label">Change Password</label>
            <div class="col-sm-9">
                <input class="form-control" type="password" name="ChangePassword" id="ChangePassword">
            </div>
        </div>
        <div class="form-group">
            <label for="ID" class="col-sm-3 control-label">Retype Change Password</label>
            <div class="col-sm-9">
                <input class="form-control" type="password" name="RetypeChangePassword" id="RetypeChangePassword">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      <?php echo form_close();?>
    </div> 
    </div> 
  </div>
</div>