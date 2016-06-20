<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Transaction List
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Transaction Table</h3>
                        <span style="float: right; margin: 10px; font-size: 18px; color: blue;">
                            <a href="http://www.mgfriends.com/admin/report/ReportAllHotelBooking"><i class="fa fa-download"> </i> Download All Hotel Booking</a>
                        </span>
                    </div><!-- /.box-header -->
                    <!--<div style="padding-left: 11px">
                        <a href="<?php //echo base_url(); ?>admin/transaction/input" class="btn btn-primary">Add New</a>
                    </div>-->
                    <div class="row">
                        <div class="col-md-12">
                            <form id="form-transaksi-user" onsubmit="return false" method="post" enctype="multipart/form-data">
                                <div class="col-md-2">
                                    <label class="control-label">Kode Agent</label>
                                    <input type="text" class="form-control input-sm" id="kode_agent" name="kode_agent">
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label">MG User ID</label>
                                    <input type="text" class="form-control input-sm" id="mg_user_id" name="mg_user_id">
                                </div>
                                <div class="col-md-3" style="padding-top: 25px">
                                    <button type="submit" class="btn btn-primary btn-sm">Download User History</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-body table-responsive">
                                <table id="tbl" class="table table-bordered table-hover dataTable">
                                    <thead>
                                        <tr>
                                            <th>MG User ID</th>
                                            <th>Kode Agent</th>
                                            <th>Hotel</th>
                                            <th>City</th>
                                            <th>Country</th>
                                            <th>Room</th>
                                            <th>Night</th>
                                            <th>Room Night</th>
                                            <th>Promo Point</th>
                                            <th>Total Point</th>
                                            <th>From Date</th>
                                            <th>To Date</th>
                                            <th>Web Invoice</th> 
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
                        </div>
                    </div>
                    
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside>