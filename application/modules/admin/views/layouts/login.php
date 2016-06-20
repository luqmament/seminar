<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?php echo add_css(array(
            'bootstrap.min',
            'AdminLTE',
        )); ?>
        <?php echo $css; ?>
    </head>
    <body class="bg-black">
        <?php echo $content; ?>
        <?php echo $js ?>
    </body>
</html>