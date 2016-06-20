<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Redemption
        </h1>
    </section>

    <section class="content">
        <div class="col-xs-12"> 
            <div class="box">                        
                <div class="box-body table-responsive">
                    <div class="row">
                        <div class="col-md-4"><img class="img-thumbnail" src="<?php echo base_url(); ?>gift/<?php echo $gift->filename; ?>"/></div>
                        <div class="col-md-8" align="right"><a href="<?php echo base_url(); ?>user/user/gift_request/<?php echo $gift->id; ?>" class="btn btn-primary" onclick="return confirm('Jumlah point anda akan dikurangi sebanyak <?php echo $gift->point; ?> ?')">Redeem</a></div>
                    </div>
                    <div>
                        <p><h4><?php echo $gift->name; ?></h4></p>
                        <p><h4><?php echo $gift->point . " point"; ?></h4></p>
                        <p><h4><?php echo $gift->description; ?></h4></p>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
    </section><!-- /.content -->
</aside>