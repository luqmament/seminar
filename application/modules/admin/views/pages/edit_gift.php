<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Gift
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Gift Table</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <?php echo form_open_multipart('http://localhost/MG/admin/gift/update'); ?>
                        <div class="row box-body">
                            <div class="col-md-12">
                                <span style="color:red">
                                    <?php
                                    echo validation_errors();
                                    ?>
                                </span>                                
                            </div>
                        </div>
                        <div class="row box-body">
                            <div class="col-md-4"></div>
                            <div class="col-md-8"><input type="hidden" name="id" value="<?php echo $gift->id; ?>"/></div>
                        </div>
                        <div class="row box-body">
                            <div class="col-md-4">File</div>
                            <div class="col-md-8"><input type="file" name="file_upload"/></div>
                        </div>
                        <div class="row box-body">
                            <div class="col-md-4"><span style="color:red">* </span>Name :</div>
                            <div class="col-md-8"><input type="text" id="name" name="name" value="<?php echo $gift->name; ?>"/></div>
                        </div>
                        <div class="row box-body">
                            <div class="col-md-4"><span style="color:red">* </span>Point :</div>
                            <div class="col-md-8"><input type="text" id="point" name="point" value="<?php echo $gift->point; ?>"/></div>
                        </div>
                        <div class="row box-body">
                            <div class="col-md-4">Description :</div>
                            <div class="col-md-8">
                                <textarea id="description" name="description"><?php echo $gift->description; ?></textarea>
                            </div>
                        </div>
                        <div class="row box-body">
                            <div class="col-md-12">
                                <span style="color:red">* </span>Required
                            </div>
                        </div>
                        <div class="row box-body">
                            <div class="col-md-4"></div>
                            <div class="col-md-8"><input class="btn btn-primary"  type="submit" name="submit" value="submit" /></div>
                        </div>                                        
                        <?php echo form_close(); ?>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside>