<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Forms</title>

<link href="<?php echo base_url()?>assets/backend/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url()?>assets/backend/css/datepicker3.css" rel="stylesheet">
<link href="<?php echo base_url()?>assets/backend/css/styles.css" rel="stylesheet">

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">Log in</div>
				<div class="panel-body">
					<style>
					    .has-error > p {
						color: red !important;
					    }
					</style>
					<div class="has-error">
					    <?php
					    echo validation_errors();
					    ?>
					</div>
					<?php echo form_open_multipart(base_url()."backend/c_login/do_login", array( "name" => "form", "id" => "form", "method" => "post")); ?>
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="Username" name="username" type="text" autofocus="">
							</div>
							<div class="form-group">
								<?php echo form_error('password'); ?>
								<input class="form-control" placeholder="Password" name="password" type="password" value="">
							</div>
							<button type="submit" class="btn btn-primary">login</button>
						</fieldset>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
	
		

	<script src="<?php echo base_url()?>assets/backend/js/jquery-1.11.1.min.js"></script>
	<script src="<?php echo base_url()?>assets/backend/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url()?>assets/backend/js/chart.min.js"></script>
	<script src="<?php echo base_url()?>assets/backend/js/chart-data.js"></script>
	<script src="<?php echo base_url()?>assets/backend/js/easypiechart.js"></script>
	<script src="<?php echo base_url()?>assets/backend/js/easypiechart-data.js"></script>
	<script src="<?php echo base_url()?>assets/backend/js/bootstrap-datepicker.js"></script>
	<script>
		!function ($) {
			$(document).on("click","ul.nav li.parent > a > span.icon", function(){		  
				$(this).find('em:first').toggleClass("glyphicon-minus");	  
			}); 
			$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>	
</body>

</html>
