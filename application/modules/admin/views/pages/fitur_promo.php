<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Fitur Promo
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Promo Reward Point</h3>
                        <div class="pull-right" style="margin: 10px 12px 0 0; font-size: 16px">
                        <a href="<?php echo site_url('admin/report/Promo_point_report')?>">
                        <i class="fa fa-download"> </i>
                            Download Promo Point 
                        <i class="fa fa-download"> </i>
                        </a>
                    </div>
                    </div>
                    
                    <div class="box-body">
                        <div class="row">﻿<br class="Apple-interchange-newline">
                            <form id="form-promo" onsubmit="return false" method="post" enctype="multipart/form-data">
                                <div class="col-md-3">
                                    <label class="control-label">Kategori Promo</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="glyphicon glyphicon-th-list"></i>
                                        </div>
                                        <select class="form-control" name="jenis_promo" id="jenis_promo">
                                            <option value="">- Pilih -</option>
                                            <option value="Country">Country</option>
                                            <option value="City">City</option>
                                            <option value="Hotel">Hotel</option>                                            
                                        </select>                      
                                    </div>
                                    
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <img id="loading-search" src="<?php echo base_url()?>assets/img/ajax-loader.gif" style="display: none; padding-top: 25px" width="30px"/>
                                    </div>
                                    <div id="list-place">
                                        
                                    </div>
                                    <!--<label class="control-label">Nama Country</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="glyphicon glyphicon-th-list"></i>
                                        </div>
                                        <select class="form-control" name="jenis_promo" id="jenis_promo">
                                            <option value="">- Pilih -</option>
                                            <option value="Country">Country</option>
                                            <option value="City">City</option>
                                            <option value="Hotel">Hotel</option>
                                        </select>
                                        <span class="input-group-btn">
                                        <button id="btn-search" class="btn btn-primary" type="button">Go!</button>
                                        </span>                               
                                    </div>-->
                                    
                                </div>
                                <div class="col-md-2" id="point-place">
                                    
                                </div>
                                <div class="col-md-3" id="date-place-from">
                                    
                                </div>
                                <div class="col-md-1" id="btn-submit">
                                    
                                </div>
                            </form>
                        </div>
                        <div style="height: 20px"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="tbl-promo" class="table table-bordered table-hover dataTable">
                                    <thead>
                                        <tr>
                                            <th>Kategori Promo</th>
                                            <th>Nama Promo</th>
                                            <th>Point</th>
                                            <th>Date From</th>
                                            <th>Date To</th>
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
<div class="modal fade" id="GiftPromoLuqman" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Change Promo</h4>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart(site_url('admin/promo/e_point_promo'), array("id" => "form-promo-edit", "class" => "form-horizontal", "enctype" => "multipart/form-data", "method" => "POST")); ?>
        <div class="form-group div_id">
            <label for="ID" class="col-sm-3 control-label">ID</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" name="id" id="id" readonly="true">
            </div>
        </div>
        <div class="form-group">
            <label for="ID" class="col-sm-3 control-label">Kategori Promo</label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="glyphicon glyphicon-th-list"></i>
                    </div>
                    <select class="form-control" name="e_jenis_promo" id="e_jenis_promo">
                        <option value="">- Pilih -</option>
                        <option value="Country">Country</option>
                        <option value="City">City</option>
                        <option value="Hotel">Hotel</option>                                            
                    </select>                      
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="ID" class="col-sm-3 control-label promoName"></label>
            <div class="col-sm-9">
                 <select class="form-control" name="e_nama_promo" id="e_nama_promo">
                 </select>
            </div>
        </div>
        <div class="form-group"> 
            <label for="ID" class="col-sm-3 control-label">Point Promo</label>
            <div class="col-sm-9">
                <select class="form-control" name="e_point_promo" id="e_point_promo">
                    <?php
                        $PointPromo = 20 ;
                        for($no = 1;$no <= $PointPromo;$no++){
                            echo '<option value="'.$no.'">'.$no.' Point</option>';
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="ID" class="col-sm-3 control-label">Periode Promo</label>
            <div class="col-sm-9">
                <input type="hidden" class="form-control" name="e_from_date" id="e_from_date"/>
                <input type="hidden" class="form-control" name="e_to_date" id="e_to_date"/>
                <input type="text" class="form-control pull-right" id="e_date_range"/>
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