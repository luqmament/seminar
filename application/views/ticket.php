<!DOCTYPE html>
<html>
<body>
<h1 style="text-align : center">Ticket Seminar</h1>
<div class="left_ticket">
	<table>
		<tr>
			<td>Nama Seminar</td>
			<td>:</td>
			<td><?php echo $ticket_seminar->tema_seminar?></td>
		</tr>
		<tr>
			<td>Tanggal Seminar</td>
			<td>:</td>
			<td><?php echo $ticket_seminar->jadwal_seminar?></td>
		</tr>
		<tr>
			<td>Lokasi Seminar</td>
			<td>:</td>
			<td><?php echo $ticket_seminar->tempat_seminar?></td>
		</tr>
		<tr>
			<td>Pembicara Seminar</td>
			<td>:</td>
			<td><?php echo $ticket_seminar->pembicara_seminar?></td>
		</tr>
	</table>
	
</div>
<div class="right_ticket">
	<img src="<?php echo base_url()?>assets/frontend/barcode/<?php echo $ticket_seminar->serial.'.gif'?>">
</div>
</body>
</html>
