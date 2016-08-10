<!DOCTYPE html>
<html>
<head>
	<title>ALl Seminar</title>
	<link href="<?php echo base_url()?>assets/frontend/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<link href="<?php echo base_url()?>assets/frontend/css/cetak_sertifikat.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<div class="container">
	<div class="row">
		<div style="float : left; width: 140mm ;">
			<table class="table table-striped">
				<tr>
					<td>Nama Mahasiswa</td>
					<td>:</td>
					<td>Luqman Hakim</td>
				</tr>
				<tr>
					<td>NIM</td>
					<td>:</td>
					<td>Luqman Hakim</td>
				</tr>
			</table>	
		</div>
	</div>
	<div class="row" class="row" style="margin-top: 15mm">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Tema Seminar</th>
					<th>Jadwal Seminar</th>
					<th>Serial Sertifikat</th>
				</tr>
			</thead>
			<?php 
			$no = 1 ;
			foreach ($all_seminar as $key => $value) { ?>
				<tr>
					<td><?php echo $no?></td>
					<td><?php echo $value['tema_seminar']?></td>
					<td><?php echo $value['jadwal_seminar']?></td>
					<td><?php echo $value['serial']?></td>
				</tr>
			<?php $no++;} ?>
		</table>
	</div>
	<div class="row">
		<div class="text-center" style="width: 140mm ; margin-top: 30mm; margin-left: 110mm;font-size:18px;">EO Esa Unggul</div>
	</div>
	<div class="row" style="margin-top: 20mm">
		<div class="text-center" style="width: 140mm ; margin-top: 0mm; margin-left: 110mm;font-size:24px;">( .................... )</div>
	</div>
</div>

</body>
</html>
