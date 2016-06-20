<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Gift List Option
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
        <?php
            $count_category = count($category);

            for ($i=0; $i < $count_category; $i++) { 

                if($i % 2 === 0 && $i > 0){

                    echo '</div><div class="row"><div class="col-xs-6">';

                }else{

                    echo '<div class="col-xs-6">';
  
                }
 
        ?>
        
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo $category[$i]['category_name'] ?></h3>
                    </div><!-- /.box-header -->

                    <div class="box-body table-responsive">                        
                        <table id="<?php echo "tbl-".$category[$i]['id']; ?>" class="table table-bordered table-hover dataTable">
                            <thead>
                                <tr>
                                    <th>Gift</th>
                                    <th>Name</th>
                                    <th>Value</th>
                                    <th>Point</th>
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
    
        <?php } ?>
        </div>

    </section><!-- /.content -->
</aside>
