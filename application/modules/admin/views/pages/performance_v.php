<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Report
            <small>Performance</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Report</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <?php echo form_open_multipart(site_url('admin/report/user_performance'), array("id" => "form-report", "enctype" => "multipart/form-data", "method" => "POST")); ?>
                                <span style="color:red">
                                    <?php
                                        echo validation_errors();
                                    ?>
                                </span>
                                <div class="col-md-3">
                                    <label class="control-label">Periode Performance :</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="glyphicon glyphicon-th-list"></i>
                                        </div>
                                        <input type="text" class="form-control" name="periode_Report" id="periode_Report" autocomplete="off">
                                    </div>                                    
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label">Report by :</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="glyphicon glyphicon-th-list"></i>
                                        </div>
                                        <select class="form-control" id="ReportBy" name="ReportBy">
                                            <option value="">-- PILIH --</option>
                                            <option value="Users">Users</option>
                                            <option value="Agents">Agents</option>
                                            <option value="Hotels">Hotels</option>
                                            <option value="Destinasi">Destinasi</option>
                                            <option value="AllMemberTop">All Member Top</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3" id="kol-listHotels" style="display: none">
                                    <label class="control-label">Hotel list:</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="glyphicon glyphicon-th-list"></i>
                                        </div>
                                        <select class="form-control" name="list_hotels" id="list_hotels"></select>
                                    </div>                                    
                                </div>
                                <div class="col-md-3" id="kol-listCity" style="display: none">
                                    <label class="control-label">City list:</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="glyphicon glyphicon-th-list"></i>
                                        </div>
                                        <select class="form-control" name="list_citys" id="list_citys"></select>
                                    </div>                                    
                                </div>
                                <div id="kategori-dest">
                                    
                                </div>
                                <div class="col-md-3" style="padding-top: 25px" id="btn-report">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-download"></i> Download</button>
                                </div>
                            <?php echo form_close()?>
                        </div>
                    </div>
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside>