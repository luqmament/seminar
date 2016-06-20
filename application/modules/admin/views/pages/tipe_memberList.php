<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Tipe Member List
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Member list Table</h3>
                    </div><!-- /.box-header -->
                    <!--<div style="padding-left: 11px">
                        <button type="button" class="btn btn-primary btn-new">Add New</button>
                    </div>-->
                    <div class="box-body table-responsive">
                        <table id="tbl" class="table table-bordered table-hover dataTable">
                            <thead>
                                <tr>
                                    <th>Tipe Member</th>
                                    <th>Minimal RN</th>
                                    <th>Point</th>
                                    <th>Action</th>
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
        <h4 class="modal-title" id="myModalLabel">Tipe Member</h4>
      </div>
        <form class="form-horizontal" id="form-data" enctype="multipart/form-data" method="POST" onsubmit="return false">
        <div class="modal-body">        
            <div class="form-group" id="id-input" style="display: none">
                <label for="ID" class="col-sm-3 control-label">ID Member</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="id" id="id" readonly="true">
                </div>
            </div>
            <div class="form-group">
                <label for="ID" class="col-sm-3 control-label">Tipe Member</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="tipeMember" id="tipeMember">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="address">Minimal RN</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="minimalRN" id="minimalRN" onkeyup="return numberFormat(this)" onkeypress="return isNumberKey(this)">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="address">Point Member</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="pointMember" id="pointMember" >
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