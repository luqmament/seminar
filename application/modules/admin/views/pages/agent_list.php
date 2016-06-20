<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Agent List
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
                    <div style="padding-left: 11px">
                        <button type="button" class="btn btn-primary btn-fileAgent">Upgrade Agent</button>
                        <!-- <a href="<?php echo base_url(); ?>admin/agent/input" class="btn btn-primary">Add New</a> -->
                    </div>
                    <div class="box-body table-responsive">
                        <table id="tbl" class="table table-bordered table-hover dataTable">
                            <thead>
                                <tr>
                                    <th>Agent Code</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="dataTables_empty">Loading data from server</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside>

<!-- Modal-->
<div class="modal fade" id="MyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agent</h4>
      </div>
        <form class="form-horizontal" id="form-data" enctype="multipart/form-data" method="POST" onsubmit="return false">
        <div class="modal-body">        
            <div class="form-group" id="id-input" style="display: none">
                <label for="ID" class="col-sm-3 control-label">ID Agent</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="id" id="id" readonly="true">
                </div>
            </div>
            <div class="form-group">
                <label for="ID" class="col-sm-3 control-label">Name</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="nameAgent" id="nameAgent">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="address">email</label>
                <div class="col-sm-9">
                    <input class="form-control" type="email" name="emailAgent" id="emailAgent" >
                </div>
            </div>    
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
    </div> 
  </div>
</div>

<!-- Modal-->
<div class="modal fade" id="MyModalFileExcel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">File Excel Agent</h4>
      </div>
        <?php echo form_open_multipart('admin/agent/file_excel', array("id" => "form-data-excel", "class" => "form-horizontal", "enctype" => "multipart/form-data", "method" => "POST")); ?>  
        <div class="modal-body"> 
            <div class="form-group">
                <label class="col-sm-3 control-label">File</label>
                <div class="col-sm-9" id="">
                    <input type="file" name="file" class="" id="file" onchange="ValidateFileUpload(this, 'file');"/>     
                    
                </div>
            </div>
            
          <div class="modal-footer">
            <span id="btn-agentExcel">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
            </span>
            <img id="loading-search" src="<?php echo base_url()?>assets/img/ajax-loader.gif" style="display: none;" width="30px"/>
          </div>      
        </div>
        <?php echo form_close();?>
    </div> 
  </div>
</div>