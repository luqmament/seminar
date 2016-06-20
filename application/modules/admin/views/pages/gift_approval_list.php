<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Gift Request List
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Gift Request</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <div class="row">
                            <?php echo form_open_multipart(site_url('admin/admin/approval_gift_request_list'), array("id" => "form-date", "enctype" => "multipart/form-data", "method" => "POST")); ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <span style="color:red">
                                            <?php
                                            echo validation_errors();
                                            ?>
                                        </span>
                                    </div>
                                    <label class="control-label">Report Claimed Approved</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control" placeholder="date" name="date_search" id="date_search" autocomplete="off" value="<?php echo set_value('date_search') ?>">
                                        <span class="input-group-btn">
                                        <button id="btn-search" class="btn btn-primary" type="submit">Go!</button>
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
                                        <th>Kode Agent</th>
                                        <th>Agent Name</th>
                                        <th>Date Claim</th>
                                        <th>MG User id</th>
                                        <th>Username</th>
                                        <th>Nama Bank</th>
                                        <th>No Rekening</th>
                                        <th>Bank Atas Nama</th>                                    
                                        <th>Gift</th>
                                        <th>Value</th>
                                        <th>status</th>
                                        <th>action</th>
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
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside>
<!-- Modal Update-->
<div class="modal fade" id="ApproveGift" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Approve gift request</h4>
        </div>
        <?php //echo form_open_multipart(site_url('admin/admin/aprrove_reqGift'), array("id" => "", "class" => "", "" => "", "method" => "POST")); ?>
        <form id="form-aprrove-reqGift" class="form-horizontal" enctype="multipart/form-data" onsubmit="return false">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <img id="modalImg" class="img-thumbnail" width="100%" alt="" style="margin:0px" />
                </div>
                <div class="col-md-6">
                    <div class="p1" id="modalName" style="font-size:20px;"></div>
                    <div class="p2" id="ModalMG_userID"></div>
                    <div class="p2" id="ModalAgentName"></div>
                    <div class="p2" id="ModalTglKlaim"></div>
                    <div class="p3" id="modalValue"></div>
                    <div class="p3" id="modalNamaBank"></div>
                    <div class="p3" id="modalNoRek"></div>
                    <div class="p3" id="modalAtasNama"></div>
                    <div id="modalRemark" style="font-size:12px; color:#fff"></div>   
                </div>
            </div>
                
        </div>
        <div class="modal-footer">
            <input type="hidden" id="idReqGift" name="idReqGift" />
            <input type="hidden" id="idGift" name="idGift" />
            <input type="hidden" id="idUser" name="idUser" />
            
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Approve gift request</button>
        </div>
        </form>
    </div> 
  </div>
</div>