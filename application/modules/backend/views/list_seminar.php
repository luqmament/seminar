<!--Mulai input Body-->
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Icons</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Seminar</h1>
			</div>
		</div><!--/.row-->
				
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading"><a href="<?php echo site_url('backend/c_seminar/v_seminar')?>" class="btn btn-primary">Add Seminar</a></div>
					<?php if($this->session->flashdata('infoJurusanFakultas')){ ?>
						<div class="alert alert-success" style="margin: 15px">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>Success!</strong> <?php echo $this->session->flashdata('infoJurusanFakultas'); ?>
						</div>
					<?php } ?>
					<?php if($this->session->flashdata('infoDeleteUser')){ ?>
						<div class="alert alert-success" style="margin: 15px">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>Success!</strong> <?php echo $this->session->flashdata('infoDeleteUser'); ?>
						</div>
					<?php } ?>
					<?php if($this->session->flashdata('infoCheckJurusanFakultas')){ ?>
						<div class="alert alert-warning" style="margin: 15px">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>Failed!</strong> <?php echo $this->session->flashdata('infoCheckJurusanFakultas'); ?>
						</div>
					<?php } ?>
					<div class="panel-body">
						<table class="table table-bordered table-hover">
							<thead>
							  <tr>
								<th>No</th>
								<th>Tema Seminar</th>
								<th>Jadwal Seminar</th>
								<th>Pembicara Seminar</th>
								<th>Tempat Seminar</th>
								<th>Kuota Seminar</th>
								<th>Sisa Kuota</th>
								<th>Kelas Seminar</th>
								<th>Semester Seminar</th>
								<th>Jurusan Seminar</th>
								<th>Status Seminar</th>								
								<th>Action</th>
							  </tr>
							</thead>
							<tbody>
							<?php
							foreach($listSeminar as $key => $value){ ?>
							<tr>
								<td><?php echo ++$start ?></td>
								<td><?php echo $value['tema_seminar'] ?></td>
								<td><?php echo $value['jadwal_seminar'] ?></td>	
								<td><?php echo $value['pembicara_seminar'] ?></td>	
								<td><?php echo $value['tempat_seminar'] ?></td>	
								<td><?php echo $value['kuota_seminar'] ?></td>	
								<td><?php echo $value['sisa_kuota'] ?></td>	
								<td><?php echo $value['untuk_kelas'] ?></td>	
								<td><?php echo $value['semester_seminar'] ?></td>
								<td><?php echo $value['jurusan_seminar'] ?></td>	
								<td><?php echo (($value['status_seminar'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Non Active</span>' ); ?></td>								
								<td class="text-center">
								    <a href="<?php echo site_url('backend/c_seminar/v_seminar/'.$value['id_seminar'])?>" >Edit</a>  
								    | <a id="delete_seminar" id_delete_seminar="<?php echo $value['id_seminar']?>" >Delete</td>
							</tr>  
							<?php }  ?>
							</tbody>
						</table>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<?php echo $pagination; ?>
						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->
		
	</div><!--/.main-->

		
</body>

</html>
<script>var base_url = "<?php echo base_url();?>"</script>
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
<script>
$(document).on("click","#delete_jurusan_fakultas", function(){
    var answer = confirm("Are you sure you want to Delete Jurusan Fakultas ID = "+$(this).attr('id_jur_fakultas')+' ?');
    if(answer){
             $.ajax({
                type: "POST",
                url: base_url+'backend/c_jurusan_fak/do_delete',
                data: {id : $(this).attr('id_jur_fakultas')},
                dataType: "json",
                success: function(result){				
                    switch(result.returnVal){
                    case "success":
				alert(result.alert);
                    window.location.reload(base_url+'jurusan-fak');
                    break;
                    default:
                        alert(result.alert);
                    break;
                    }				
                }
            });
        }
    })
</script>
