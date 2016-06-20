<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Gift List
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Gift Table</h3>
                    </div><!-- /.box-header -->
                    <div style="padding-left: 11px">
                        <button type="button" class="btn btn-primary btn-new">Add New</button>
                    </div>
                    <div class="box-body table-responsive">                        
                        <table id="tbl" class="table table-bordered table-hover dataTable">
                            <thead>
                                <tr>
                                    <th>Gift</th>
                                    <th>Name</th>
                                    <th>Tipe Voucher</th>
                                    <th>Value</th>
                                    <th>Point</th>
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
<div class="modal fade" id="GiftChange" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Change Gift</h4>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart(site_url('admin/gift/submit'), array("id" => "form-data", "class" => "form-horizontal", "enctype" => "multipart/form-data", "method" => "POST")); ?>
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
            <label for="ID" class="col-sm-3 control-label">Value</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" name="value" id="value">
            </div>
        </div>
        <div class="form-group">
            <label for="ID" class="col-sm-3 control-label">Category</label>
            <div class="col-sm-9">
                <select class="form-control" name="type" id="type">
                    <?php
                        foreach ($category as $key => $value) {
                            echo "<option value='$value[id]'>$value[category_name]</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="ID" class="col-sm-3 control-label">Point</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" name="point" id="point">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="address">Description</label>
            <div class="col-sm-9">
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
        </div>        
        <div class="form-group">
            <label class="col-sm-3 control-label">File</label>
            <div class="col-sm-9" id="Upload">
                <div class="fileUpload btn btn-warning">
                    <span>Pilih Photo</span>
                    <input type="file" name="image" class="upload" id="image" onchange="ValidateFileUpload(this, 'image', 'images','gambar');"  />     
                </div>
                <span class="label label-warning">(289x155px)</span>
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