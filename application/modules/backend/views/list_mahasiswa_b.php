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
				<h1 class="page-header">Fakultas</h1>
			</div>
		</div><!--/.row-->
				
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading"><a href="#" class="btn btn-primary btn-upgrade-mhs">Update mahasiswa</a></div>
					<?php if($this->session->flashdata('infoFakultas')){ ?>
						<div class="alert alert-success" style="margin: 15px">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>Success!</strong> <?php echo $this->session->flashdata('infoFakultas'); ?>
						</div>
					<?php } ?>
					<?php if($this->session->flashdata('infoDeleteUser')){ ?>
						<div class="alert alert-success" style="margin: 15px">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>Success!</strong> <?php echo $this->session->flashdata('infoDeleteUser'); ?>
						</div>
					<?php } ?>
					<?php if($this->session->flashdata('infoCheckFakultas')){ ?>
						<div class="alert alert-warning" style="margin: 15px">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>Failed!</strong> <?php echo $this->session->flashdata('infoCheckFakultas'); ?>
						</div>
					<?php } ?>
					<div class="panel-body">
						<table class="table table-bordered table-hover">
							<thead>
							  <tr>
								<th>No</th>
								<th>NIM Maha</th>
								<th>Nama</th>
								<th>Email</th>
								<th>Telp</th>
								<th>FAKULTAS</th>
								<th>Jurusan</th>
								<th>Action</th>
							  </tr>
							</thead>
							<tbody>
							<?php
							foreach($listMahasiswa as $key => $value){ ?>
							<tr>
								<td><?php echo ++$start ?></td>
								<td><?php echo $value['nim_mahasiswa'] ?></td>	
								<td><?php echo $value['nama_depan'] ?></td>
								<td><?php echo $value['email_mahasiswa'] ?></td>
								<td><?php echo $value['telp_mahasiswa'] ?></td>
								<td><?php echo $value['nama_fakultas'] ?></td>
								<td><?php echo $value['nama_jurusan'] ?></td>
								<td class="text-center">
								    <a href="<?php echo site_url('backend/c_fakultas/v_fakultas/'.$value['id_fakultas'])?>" >Edit</a>  
								    | <a id="delete_fakultas" id_fakultas="<?php echo $value['id_fakultas']?>" >Delete</td>
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

<!-- Modal-->
<div class="modal fade" id="MyModalUpgradeMhs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">File Excel Agent</h4>
      </div>
        <?php echo form_open_multipart('backend/c_mahasiswa/upg_mahasiswa', array("id" => "form-data-mahasiswa", "class" => "form-horizontal", "enctype" => "multipart/form-data", "method" => "POST")); ?>  
        <div class="modal-body"> 
            <div class="form-group">
                <label class="col-sm-3 control-label">File</label>
                <div class="col-sm-9" id="">
                    <input type="file" name="file" class="" id="file" onchange="ValidateFileUpload(this, 'file');"/>     
                    
                </div>
            </div>
            
          <div class="modal-footer">
            <span id="btn-agentExcel">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
            </span>
            <img id="loading-search" src="<?php echo base_url()?>assets/backend/img/ajax-loader.gif" style="display: none;" width="30px"/>
          </div>      
        </div>
        <?php echo form_close();?>
    </div> 
  </div>
</div>


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
$(document).on("click","#delete_fakultas", function(){
    var answer = confirm("Are you sure you want to Delete Fakultas ID = "+$(this).attr('id_fakultas')+' ?');
    if(answer){
             $.ajax({
                type: "POST",
                url: base_url+'backend/c_fakultas/do_delete',
                data: {id : $(this).attr('id_fakultas')},
                dataType: "json",
                success: function(result){				
                    switch(result.returnVal){
                    case "success":
				alert(result.alert);
                    window.location.reload(base_url+'fakultas');
                    break;
                    default:
                        alert(result.alert);
                    break;
                    }				
                }
            });
        }


    })

$('.btn-upgrade-mhs').click(function(){
    $('#MyModalUpgradeMhs').modal('show');
});

$('#form-data-mahasiswa').on('submit',(function(e) {
        if(validation() == false){
            return false;
        }else{

            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                type:'POST',
                data:formData,
                url: $(this).attr('action'),
                dataType: 'json',
                cache:false,
                contentType: false,
                processData: false,
		beforeSend: function(){
                    $('#btn-agentExcel').hide('fade-in');
                    $('#loading-search').css('display','block');
		},
		error: function(){
		    alert("web server Full load access");
		    $('#loading-search').css('display','none');
		    $('#btn-agentExcel').show('fade-out');
		},
                success:function(result){
		    $('#btn-agentExcel').show('fade-out');
		    $('#loading-search').css('display','none');
		    switch (result.status) {
			case 'success' :
			    alert("Jumlah Data yang Masuk = "+result.Insert + "\n"
			    +"Yang Tidak Masuk = " +result.Non_Insert);
                        window.location.reload();
			break;
			case 'pernah' :
			    alert("Jumlah Data yang Masuk = "+result.Insert + "\n"
			    +"Yang Tidak Masuk = " +result.Non_Insert + '\n'
			    + result.returnVal);
                        window.location.reload();
			break;
			default :
			    alert(result.returnVal);
			break;
		    }
                }
            }); 
        }   
    }));

function ValidateFileUpload(input, file){
    var data = document.getElementById(file).value;          
    var Extension = data.substring(data.lastIndexOf('.')+1).toLowerCase();
    var FileSize = input.files[0].size;
    var FileSizeMB = (FileSize/1048576).toFixed(2);
    var input 	= $("#"+file);
    
    if (Extension != "xlsx" && Extension != "xls" && FileSize >= FileSizeMB) {
	alert("File only allows file types of xls, xlsx and less than 1 MB. ");
        input.replaceWith(input.val('').clone(true));
        return false;
    } 
       
  }
</script>
