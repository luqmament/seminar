<aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Redemption
                    </h1>
                </section>

                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-body table-responsive">
                                    <div class="row">
                                        <div class="col-md-6 pull-right">
                                            <div class="input-group pull-right">
                                                <form method="get" id="form" name="form" action="<?php echo base_url(); ?>user/user/gift_request_list">
                                                    <input type="text" name="textsearch" id="textsearch" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                                                    <div class="input-group-btn">
                                                        <button type="submit" class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                                                    </div>
                                                </form>
                                            </div>                                            
                                        </div>

                                    </div>
                                    <div class="row">
                                        <?php
                                        $i = 0;
                                        foreach ($gift_data as $item) {
                                            $i++;
                                            ?>
                                            <div class="col-md-4" align="center">
                                                <div></br></div>
                                                <div><img class="img-thumbnail" src="<?php echo base_url(); ?>assets/gift/<?php echo $item->filename; ?>" style="width:150px"/></div>
                                                <div><?php echo '<h4>' . $item->name . '</h4>'; ?></div>
                                                <div><?php echo '<h4>' . $item->point . ' point</h4>'; ?></div>
                                                <div><a href="<?php echo base_url(); ?>user/user/gift_redeem/<?php echo $item->id; ?>" class="btn btn-success">Redeem</a></div>
                                                <div></br></div>
                                            </div>
                                            <?php
                                            if ($i == 3) {
                                                $i = 0;
                                                echo '</div><div class="row">';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="table table-hover">Page : <?php echo $halaman; ?></div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section><!-- /.content -->
            </aside>