<div class="col-md-12">
    <?php echo form_open_multipart('admin/agent/file_excel', array("id" => "form-data", "class" => "form-horizontal", "enctype" => "multipart/form-data", "method" => "POST")); ?>  
        
        <div class="form-group">
            <label class="col-sm-3 control-label">File</label>
            <div class="col-sm-9" id="Upload">
                <div class="fileUpload btn btn-warning">
                    <span>Pilih Photo</span>
                    <input type="file" name="file" class="upload" id="file" />     
                </div>
                <span class="label label-warning">(289x155px)</span>
            </div >
        </div>
        
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      <?php echo form_close();?>
</div>
