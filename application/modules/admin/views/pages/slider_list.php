<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Slider / Banner List
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Banner Table</h3>
                    </div><!-- /.box-header -->
                    <div style="padding-left: 11px">
                        <button type="button" class="btn btn-primary btn-new">Add New</button>
                    </div>
                    <div class="box-body table-responsive">                        
                        <table id="tbl" class="table table-bordered table-hover dataTable">
                            <thead>
                                <tr>
                                    <th>Banner Name</th>
                                    <th>Period of date</th>
                                    <th>Banner Image</th>
                                    <th>Link Banner</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
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

<!-- Modal -->
<div class="modal fade" id="BannerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Banner</h4>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart(site_url('admin/slider/submit'), array("id" => "form-data", "class" => "form-horizontal", "enctype" => "multipart/form-data", "method" => "POST")); ?>
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
        <div class="form-group">
            <label class="col-sm-3 control-label" for="address">Period Banner</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="periode_banner" id="periode_banner" autocomplete="off">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="address">Link Banner</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="link_banner" id="link_banner" autocomplete="off">
            </div>
        </div>  
        <div class="form-group">
            <label class="col-sm-3 control-label">File</label>
            <div class="col-sm-9" id="Upload">
                <div class="fileUpload btn btn-warning">
                    <span>Pilih Photo</span>
                    <input type="file" name="image" class="upload" id="image" onchange="ValidateFileUpload(this, 'image', 'images','gambar');"  />     
                </div>
                <span class="label label-warning">(960 x 525px)</span>
                <input type="hidden" name="hImage" id="hImage">
                <br/><br/>
                <span id="gambar" style="display: none">
                    <img id="images" class="img-thumbnail" width="100"/>
                </span>
            </div >
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