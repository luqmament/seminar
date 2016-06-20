<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Detail Promo Game
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Detail Promo Game Table</h3>
                    </div><!-- /.box-header -->
                    <div style="padding-left: 11px">
                        <button type="button" class="btn btn-primary btn-new">Add New</button>
                    </div>
                    <div class="box-body table-responsive">                        
                        <table id="tbl" class="table table-bordered table-hover dataTable">
                            <thead>
                                <tr>
                                    <th>Kota Promo Game</th>
                                    <th>Nama Promo Game</th>
                                    <th>Start Promo Game</th>
                                    <th>End Promo Game</th>
                                    <th>Status Promo</th>
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
<div class="modal fade" id="PromoGameDetailModals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Promo Game</h4>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart(site_url('admin/promo_game/submit_detailGame'), array("id" => "form-data", "class" => "form-horizontal", "enctype" => "multipart/form-data", "method" => "POST")); ?>
        <div class="form-group div_id" style="display:none">
            <label for="ID" class="col-sm-3 control-label">ID</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" name="id" id="id" readonly="true">
            </div>
        </div>
        <div class="form-group">
            <label for="ID" class="col-sm-3 control-label">City Promo Game</label>
            <div class="col-sm-9">
                <select class="form-control" name="CityPromoGame" id="CityPromoGame">
                    <option value="">-- Pilih City --</option>
                    <?php
                        foreach($listCity as $rows){
                            echo '<option value="'.$rows['CityName'].'">'.$rows['CityName'].'</option>';
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="ID" class="col-sm-3 control-label">Promo Game</label>
            <div class="col-sm-9">
                <select class="form-control" name="KatPromoGame" id="KatPromoGame">
                    <option value="">-- Pilih Promo --</option>
                    <?php
                        foreach($list_promo_game as $rows){
                            echo '<option value="'.$rows['id_promogame'].'">'.$rows['nama_promogame'].'</option>';
                        }
                    ?>
                </select>
            </div>
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