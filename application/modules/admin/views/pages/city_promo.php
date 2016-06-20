<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            City Promo
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">City</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div style="padding-left: 11px">
                                <button type="button" class="btn btn-primary btn-new">Add New</button>
                            </div>
                        </div>
                        <div style="height: 20px"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="tbl" class="table table-bordered table-hover dataTable">
                                    <thead>
                                        <tr>
                                            <th>City Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>                                                                    
                            </div>
                            
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside>

<!-- Modal -->
<div class="modal fade" id="City-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">City Promo</h4>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart(site_url('admin/promo/submit_city'), array("id" => "form-data", "class" => "form-horizontal", "enctype" => "multipart/form-data", "method" => "POST")); ?>
        <div class="form-group div_id" style="display:none">
            <label for="ID" class="col-sm-3 control-label">ID</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" name="id" id="id" readonly="true">
            </div>
        </div>
        <div class="form-group">
            <label for="ID" class="col-sm-3 control-label">Name</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" name="name" id="name">
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