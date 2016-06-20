<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?php echo add_css(array(
             '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css',
             '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css', 
             '//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css',
             'AdminLTE',
             'style',
             'datatables/dataTables.bootstrap'
             )); ?>
        <?php echo $css; ?>
        <script>
            var base_url = '<?php echo base_url(); ?>';
        </script>
    </head>
    <body class="skin-blue">
        <?php echo $content; ?>
        
        <?php echo add_js(array(
            'jquery-1.11.1.min',
            'bootstrap.min',
            'jquery.dataTables',
            'AdminLTE/app',
            'plugins/datatables/dataTables.bootstrap',
        )); ?>
        
        <?php echo $js; ?>
    </body>
</html>