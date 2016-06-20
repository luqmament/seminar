<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?php echo add_css(array(
            'bootstrap.min',
            'AdminLTE',
             'jquery-ui'
        )); ?>
        <?php echo $css; ?>
        <script>
            var base_url = '<?php echo base_url(); ?>';
        </script>
    </head>
    <body class="bg-black">
        <?php echo $content; ?>
        <?php echo add_js(array(
            'jquery-1.11.1.min',
            'jquery-ui'
        )); ?>
        <?php echo $js ?>
    </body>
</html>