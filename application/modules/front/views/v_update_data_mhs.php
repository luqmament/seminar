<div>
	<div class="container" style="background: white; box-shadow: 0 5px 5px 0 grey;">
		<h3 style="font-family: 'Alegreya', serif; margin-top: 40px">Biodata Mahasiswa</h3>
		<div style="margin-top: 10px; height: 10px; border: 0; box-shadow: 0 10px 10px -10px #0066FF inset; border-radius: 5px;"></div>
		<div style="margin-top:25px">
			<div class="col-md-3" style="font-size : 14px ;font-family : tahoma">
				<div class="list-group">
					<a href="<?php echo site_url('mahasiswa-dashboard')?>" class="list-group-item active">Aksi Cepat</a>
					<a href="<?php echo site_url('mahasiswa-dashboard')?>" class="list-group-item">Detail Mahasiswa</a>
					<a href="<?php echo site_url('update-mahasiswa')?>" class="list-group-item">Edit Mahasiswa</a>
					<a href="#" class="list-group-item">Porta ac consectetur ac</a>
					<a href="#" class="list-group-item">Vestibulum at eros</a>
				</div>
			</div>
			<div class="col-md-9" style="font-size : 14px ;font-family : tahoma">
				<div class="panel panel-default">
				  <div class="panel-heading"><h4>Edit Mahasiswa</h4></div>
				  <div class="panel-body">
				    	<!-- Form Register mahasiswa -->
					    <div role="tabpanel" class="tab-pane" id="register">
					    	<div class="about-grids">
								<div class="col-md-7 about-grid">
									<div class="has-error">
										<?php
										echo validation_errors();

										?>
								    </div>
									<form action="<?php echo site_url('front/c_biomhs/submit_update_mhs')?>" method="post" id="form_register_mahasiswa" enctype="multipart/form-data" style="margin-bottom: 15px">
									  	<div class="form-group">
										    <label for="NamaDepan">Nama Depan</label>
										    <input type="text" class="form-control" id="namaDpn" name="namaDpn" placeholder="Nama Depan" autocomplete="off" value="<?php echo $mahasiswa['nama_depan']; ?>" disabled="disabled">
									  	</div>
									  	<div class="form-group">
										    <label for="NamaBelakang">Nama Belakang</label>
										    <input type="text" class="form-control" id="namaBlkg" name="namaBlkg" placeholder="Nama Belakang" autocomplete="off" value="<?php echo $mahasiswa['nama_belakang']; ?>" disabled="disabled">
									  	</div>
									  	<div class="form-group">
										    <label for="NIMmahasiswa">NIM Mahasiswa</label>
										    <input type="text" class="form-control" id="NIMmhs" name="NIMmhs" placeholder="NIM" autocomplete="off" value="<?php echo $mahasiswa['nim_mahasiswa']; ?>" disabled="disabled">
										    <span style="color : red; font-size : 10px">* Harap Masukan NIM yang sesuai dengan KTM (Kartu tanda mahasiswa)</span>
									  	</div>
									  	<!-- <div class="form-group">
										    <label for="NIMmahasiswa">Tipe Mahasiswa</label>
										    <select class="form-control" id="tipe_mahasiswa" name="tipe_mahasiswa">
										    	<option value="">--PILIH--</option>
										    	<?php if($mahasiswa['tipe_mahasiswa'] == 1){ ?> 
										    		<option value="1" selected="selected">REGULER</option>
										    		<option value="2">PARALEL</option>
										    	<?php }else{ ?>
										    		<option value="1">REGULER</option>
										    		<option value="2" selected="selected">PARALEL</option>
										    	<?php } ?>
										    	
										    </select>								   
									  	</div> -->
									  	<div class="form-group">
										    <label for="Emailmahasiswa">Email Mahasiswa</label>
										    <input type="email" class="form-control" id="emailmhs" name="emailmhs" placeholder="email" autocomplete="off"  value="<?php echo $mahasiswa['email_mahasiswa']; ?>" required pattern="[a-zA-Z0-9_.]+@[a-zA-Z0-9\-\_]+\.[a-z.]+">
									  	</div>
									  	<div class="form-group">
										    <label for="alamatmhs">Alamat Mahasiswa</label>
										    <textarea class="form-control" id="alamat_mhs" name="alamat_mhs"><?php echo $mahasiswa['alamat_mahasiswa']; ?></textarea>
									  	</div>
									  	<div class="form-group">
										    <label for="telepon_mhs">Telepon Mahasiswa</label>
										    <input type="text" class="form-control" id="telp_mhs" name="telp_mhs" maxlength="13" placeholder="No telp" autocomplete="off"  value="<?php echo $mahasiswa['telp_mahasiswa']; ?>">
									  	</div>
									  	<!-- <div class="form-group">
										    <label for="tahun_masuk">Tahun Masuk</label>
										    <select class="form-control" id="thn_masuk" name="thn_masuk">
										    	<option value="">--PILIH--</option>
										    	<?php 
										    		//year to start with
										    		$startdate = date('Y', strtotime('-5 years')) ;
										    		//year to end with - this is set to current year. You can change to specific year
													$enddate = date("Y");
													 
													$years = range ($startdate,$enddate);
													 
													//print years
													foreach($years as $year){

														if($mahasiswa['tahun_masuk'] == $year){
															echo "<option value='$year' selected='selected'>".$year."</option>";
														}else{
															echo "<option value='$year'>".$year."</option>";
														}
													}
										    	?>

										    </select>
									  	</div>
									  	<div class="form-group">
										    <label for="statusSMT">Status semester</label>
										    <select class="form-control" id="status_smt" name="status_smt">
										    	<option value="">--PILIH--</option>
										    	<?php if($mahasiswa['semester_mahasiswa'] == "genap"){ ?> 
										    		<option value="genap" selected="selected">GENAP</option>
										    		<option value="ganjil">GANJIL</option>
										    	<?php }else{ ?>
										    		<option value="genap">GENAP</option>
										    		<option value="ganjil" selected="selected">GANJIL</option>
										    	<?php } ?>
										    </select>
									  	</div>
									  	<div class="form-group">
										    <label for="Fakultas">Fakultas mahasiswa</label>
										    <select class="form-control" id="fakultas" name="fakultas">
										    	<option value="">--PILIH FAKULTAS--</option>
										    	<?php 
										    		foreach ($fakultas as $key => $value) { 

										    			if($mahasiswa['id_fakultas'] == $value['id_fakultas']){
															echo "<option value='$value[id_fakultas]' selected='selected'>".$value['nama_fakultas']."</option>";
														}else{
															echo "<option value='$value[id_fakultas]'>".$value['nama_fakultas']."</option>";
														}
													}
										    	?>
										    </select>
									  	</div> -->
									  	<!-- <div class="form-group">
									    	<label for="passwordMHS">Password</label>
									    	<input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php echo $mahasiswa['nama_depan']; ?>">
									  	</div>							  	
									  	<div class="form-group">
									    	<label for="RePasswordMHS">Password</label>
									    	<input type="password" class="form-control" id="repassword" name="repassword" placeholder="Retype Password" value="<?php echo $mahasiswa['nama_depan']; ?>">
									  	</div> -->
									  	<div class="form-group">
									    	<label for="input_file">Photo</label>
									    	<input type="file" id="photo_mhs" name="photo_mhs">
									    	<p class="help-block">Photo Mahasiswa</p>
									  	</div>
									  	<div class="form-group">
									  	<script src='https://www.google.com/recaptcha/api.js'></script>
									  	<?php

								          //require_once(APPPATH."third_party/recaptcha/recaptchalib.php");
								          //$publickey = "6LflpSITAAAAAPikqL2sdwDFlzQttbjYWq75B5GW"; // you got this from the signup page
								          //echo recaptcha_get_html($publickey);
									    ?>
									    <div class="g-recaptcha" data-sitekey="6LflpSITAAAAAPikqL2sdwDFlzQttbjYWq75B5GW"></div>
									  	</div>
									  	<button type="submit" class="btn btn-primary">Submit</button>
									</form>		
								</div>
								<div class="clearfix"></div>
					    	</div>
					    </div>
					    <!-- End Form Register mahasiswa -->
				  </div>
				</div>
			</div>
		</div>
	
	</div>
</div>
	
<!-- footer -->
<div class="footer">
	<div class="container">
		<div class="footer-grids">
			<div class="col-md-3 footer-grid">
				<h3>PERSPICIATIS</h3>
				<ul>
					<li><a href="#">SUMMER CAMPS</a></li>
					<li><a href="#">CELEBRATIONS</a></li>
					<li><a href="#">ONLINE EXAMS</a></li>
					<li><a href="#">COMPETITIONS</a></li>
					<li><a href="#">ACTIVITIES</a></li>
				</ul>
			</div>
			<div class="col-md-3 footer-grid">
				<h3>PRAESENTIUM </h3>
				<ul>
					<li><a href="#">PRESENTATIONS</a></li>
					<li><a href="#">SEMINARS</a></li>
					<li><a href="#">PREPARATIONS</a></li>
					<li><a href="#">CONDUCTING GAMES</a></li>
					<li><a href="#">OTHER ACTIVITIES</a></li>
				</ul>
			</div>
			<div class="col-md-3 footer-grid">
				<h3>DIGNISSIMOS</h3>
				<ul>
					<li><a href="#">SUMMER CAMPS</a></li>
					<li><a href="#">CELEBRATIONS</a></li>
					<li><a href="#">ONLINE EXAMS</a></li>
					<li><a href="#">COMPETITIONS</a></li>
					<li><a href="#">ACTIVITIES</a></li>
				</ul>
			</div>
			<div class="col-md-3 footer-grid">
				<h3>PRAESENTIUM</h3>
				<ul>
					<li><a href="#">PRESENTATIONS</a></li>
					<li><a href="#">SEMINARS</a></li>
					<li><a href="#">PREPARATIONS</a></li>
					<li><a href="#">CONDUCTING GAMES</a></li>
					<li><a href="#">OTHER ACTIVITIES</a></li>
				</ul>
			</div>
			<div class="clearfix"></div>
		</div>
		<p> &copy; 2015 Tutelage. All Rights Reserved | Design by  <a href="http://w3layouts.com/"> W3layouts</a></p>
	</div>
</div>
<!-- smooth scrolling -->
	<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
<!-- //smooth scrolling -->
</body>
</html>
<!-- js -->
<script src="<?php echo base_url()?>assets/frontend/js/jquery-1.11.1.min.js"></script>
<!-- //js -->
<!-- for bootstrap working -->
<script src="<?php echo base_url()?>assets/frontend/js/bootstrap.js"></script>
<!-- //for bootstrap working -->

<!-- smooth scrolling -->
<script type="text/javascript">
$(document).ready(function() {

	/*var defaults = {
	containerID: 'toTop', // fading element id
	containerHoverID: 'toTopHover', // fading element hover id
	scrollSpeed: 1200,
	easingType: 'linear' 
	};*/
								
	$().UItoTop({ easingType: 'easeOutQuart' });
});
</script>
<!-- //smooth scrolling -->
<script src="<?php echo base_url()?>assets/frontend/js/modernizr.custom.js"></script>
<!-- start-smoth-scrolling -->
<script type="text/javascript" src="<?php echo base_url()?>assets/frontend/js/move-top.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/frontend/js/easing.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
</script>
<!-- start-smoth-scrolling -->
<!-- search-scripts -->
<script src="<?php echo base_url()?>assets/frontend/js/classie.js"></script>
<script src="<?php echo base_url()?>assets/frontend/js/uisearch.js"></script>
<script>
	new UISearch( document.getElementById( 'sb-search' ) );
</script>
<!-- //search-scripts -->
<script src="<?php echo base_url()?>assets/frontend/js/jquery.swipebox.min.js"></script> 
<script type="text/javascript">
			jQuery(function($) {
				$(".swipebox").swipebox();
			});
</script>
<script src="<?php echo base_url()?>assets/frontend/js/responsiveslides.min.js"></script>
<script>
	// You can also use "$(window).load(function() {"
	$(function () {
	 // Slideshow 4
	$("#slider3").responsiveSlides({
		auto: true,
		pager: true,
		nav: false,
		speed: 500,
		namespace: "callbacks",
		before: function () {
	$('.events').append("<li>before event fired.</li>");
	},
	after: function () {
		$('.events').append("<li>after event fired.</li>");
		}
		});
		});
</script>