<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            History List
        </h1>
    </section>

    <!-- Main content -->
    <?php
                                        echo validation_errors();
                                    ?>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">History Table</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <?php echo form_open_multipart(site_url('admin/report/report_history'), array("id" => "form-history", "enctype" => "multipart/form-data", "method" => "POST")); ?>
                                <span style="color:red">
                                    <?php
                                        echo validation_errors();
                                    ?>
                                </span>
                                <div class="col-md-4">
                                    <label class="control-label">Periode History</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="glyphicon glyphicon-th-list"></i>
                                        </div>
                                        <input type="text" class="form-control" name="periode_download" id="periode_download" autocomplete="off">
                                    </div>                                    
                                </div>
                                <div class="col-md-4" style="padding-top: 25px">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-download"></i> Download</button>
                                </div>
                            <?php echo form_close()?>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-body table-responsive">                        
                        <table id="tbl" class="table table-bordered table-hover dataTable">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Kode Agent</th>
                                    <th>Gift</th>
                                    <th>Status</th>
                                    <th>Last Point</th>
                                    <th>In Point</th>
                                    <th>Out Point</th>
                                    <th>Current Point</th>
                                    <th>Approve By</th>
                                    <th>Notes</th>
                                    <th>Date Created</th>
                                    <th>Checkout</th>
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
