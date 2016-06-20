<div style="margin-top : 20px; margin-bottom : 20px">
	<div class="container">
		<h3 style="font-family: 'Alegreya', serif;">Biodata Mahasiswa</h3>
		<div style="margin-top: 10px; height: 10px; border: 0; box-shadow: 0 10px 10px -10px #0066FF inset; border-radius: 5px;"></div>
		<div style="margin-top:25px">
			<div class="col-md-3" style="font-size : 14px ;font-family : tahoma">
				<div class="list-group">
					<a href="<?php echo site_url('mahasiswa-dashboard')?>" class="list-group-item active">Aksi Cepat</a>
					<a href="#" class="list-group-item">Detail Mahasiswa</a>
					<a href="#" class="list-group-item">Edit Mahasiswa</a>
					<a href="#" class="list-group-item">Porta ac consectetur ac</a>
					<a href="#" class="list-group-item">Vestibulum at eros</a>
				</div>
			</div>
			<div class="col-md-9" style="font-size : 14px ;font-family : tahoma">
				<div class="panel panel-default">
				  <div class="panel-heading"><h4>Detail Mahasiswa</h4></div>
				  <div class="panel-body">
				    	<table class="table table-bordered" style="font-weight : bold ; font-size: 16px ; color : #fff">
				    	<?php $session_mhs = $this->session->userdata('CMS_mahasiswa');	?>
				    		<tr>
				    			<td>NIM</td>
				    			<td><?php echo $session_mhs['nim_mahasiswa']?></td>
				    			<td rowspan="6" style="text-align : center ; width : 200px">
				    			
				    			<img class="img-thumbnail" style="max-width: 150px" src="<?php echo $session_mhs['photo_mahasiswa']?>">
				    			</td>
				    		</tr>
				    		<tr>
				    			<td>Nama Lengkap</td>
				    			<td><?php echo $session_mhs['nama_depan'].' '.$session_mhs['nama_belakang']?></td>
				    		</tr>
				    		<tr>
				    			<td>Fakultas</td>
				    			<td><?php echo $session_mhs['nama_fakultas']?></td>
				    		</tr>
				    		<tr>
				    			<td>Email</td>
				    			<td><?php echo $session_mhs['email_mahasiswa']?></td>
				    		</tr>
				    		<tr>
				    			<td>Telp</td>
				    			<td><?php echo $session_mhs['telp_mahasiswa']?></td>
				    		</tr>
				    		<tr>
				    			<td>Alamat</td>
				    			<td><?php echo $session_mhs['alamat_mahasiswa']?></td>
				    		</tr>
				    		<tr>
				    			<td>Periode Masuk</td>
				    			<td>Semester <?php echo $session_mhs['semester_mahasiswa'].' '.$session_mhs['tahun_masuk']?></td>
				    		</tr>
				    		<tr>
				    			<td>Kelas</td>
				    			<td><?php echo ($session_mhs['tipe_mahasiswa'] == 1 ? "Reguler" : "Paralel")?></td>
				    		</tr>
				    		<tr>
				    			<td>Semester</td>
				    			<td>
				    			<?php 
				    				$tahun_masuk = $session_mhs['tahun_masuk'] ;
				    				$now		 = date('Y');
				    				$intervalThn = $now - $tahun_masuk ;
				    				if($session_mhs['semester_mahasiswa'] == 'ganjil'){
				    					$intervalThn = ($intervalThn * 2 ) + 1 ;
				    				}else{
				    					$intervalThn = ($intervalThn * 1 ) + 1 ;
				    				}
				    				echo $intervalThn;
				    			?></td>
				    		</tr>
						</table>
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