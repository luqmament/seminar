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
             'jquery-ui',
             'datatables/dataTables.bootstrap',
             'style'
             )); ?>
        <?php echo $css; ?>
        <script>
            var base_url = '<?php echo base_url(); ?>';
        </script>
        
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <?php echo $admin_sidebar; ?>
        <?php echo $admin_header; ?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <?php echo $content; ?>
        </div><!-- ./wrapper -->
        <?php echo add_js(array(
            'jquery-1.11.1.min',
            'bootstrap.min',
            'general',
            'plugins/datatables/jquery.dataTables',
            'plugins/datatables/fnReloadAjax.js',
            'plugins/datatables/fnStandingRedraw.js',
            'AdminLTE/app',
            'plugins/datatables/dataTables.bootstrap',
            'jquery-ui'
        )); ?>
        
        <?php echo $js; ?>
        <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-66936746-2', 'auto');
  ga('send', 'pageview');

</script>
    </body>
</html>