<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title ?> | Point Rewards</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
         <?php echo add_css(array(
             'bootstrap.min',
             '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css', 
             'external/ionicons.min',
             'AdminLTE',
             'style',
             'datatables/dataTables.bootstrap',
             'jquery-ui'
             )); ?>
        <?php echo $css; ?>
        <script>
            var base_url = '<?php echo base_url(); ?>';
        </script>
        
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <?php echo $header; ?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <?php echo $sidebar ?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <?php echo $content; ?>
        </div><!-- ./wrapper -->
        <?php echo add_js(array(
            'jquery-1.11.1.min',
            'jquery.dataTables',
            'external/bootstrap.min',
            'AdminLTE/app',
            'plugins/datatables/dataTables.bootstrap',
            'jquery-ui'
        )); ?>
        
        <?php echo $js; ?>
        
    </body>
</html>