<div id="list">
    <?php 
    //$time_stamp = time(1425142800000);
    //$php_timestamp = 1423242000;
    //$php_timestamp_date = date("Y-m-d H:i:s", $php_timestamp);
    //echo "The timestamp is ".$php_timestamp."<br />";
    //echo "The timestamp in a readable format is ".$php_timestamp_date."";
    ?>
</div>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Check Data PowerSuite
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Check Data PowerSuite</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <?php echo form_open_multipart(site_url('admin/cron/trans'), array("id" => "form-date", "enctype" => "multipart/form-data", "method" => "POST")); ?>
                                <div class="col-md-6">
                                    <label class="control-label">Begin Date - End Date</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control" placeholder="date" name="date_search" id="date_search" autocomplete="off" value="<?php echo set_value('date_search') ?>">
                                        <span class="input-group-btn">
                                        <button id="btn-search" class="btn btn-primary" type="button">Go!</button>
                                        <span id="box-btnInsert">
                                            
                                        </span>
                                        
                                        
                                        </span>                                        
                                        <img id="loading-search" src="<?php echo base_url()?>assets/img/ajax-loader.gif" style="display: none;" width="30px"/>
                                    </div>
                                    
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div style="height: 20px"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="tbl" class="table table-bordered table-hover dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>MG User ID</th>
                                            <th>Kode Agent</th>
                                            <th>Agent Name</th>
                                            <th>Hotel Name</th>
                                            <th>City</th>
                                            <th>Country</th>
                                            <th>Room</th>
                                            <th>Night</th>
                                            <th>Room Night</th>
                                            <th>From Date</th>
                                            <th>To Date</th>
                                            <th>Web Invoice</th> 
                                        </tr>
                                    </thead>
                                    <tbody id="list-data-reward">
                                        
                                    </tbody>
                                </table>                                                                    
                            </div>
                            
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside>