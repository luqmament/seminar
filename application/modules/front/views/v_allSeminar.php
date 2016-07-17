<!-- banner -->
<!-- <div class="banner"> -->
<!-- <div style="padding: 60px 0"> -->
	<div class="container-row">
		<!-- Responsive slider - START -->
    	<div class="responsive-slider" data-spy="responsive-slider" data-autoplay="true">
        <div class="slides" data-group="slides">
      		<ul>
  	    		<li>
	              	<div class="slide-body" data-group="slide">
	                	<img src="<?php echo base_url()?>assets/frontend/images/Esa-Unggul-Citra-Raya-1.jpg">
	              	</div>
  	    		</li>
  	    		<li>
	              	<div class="slide-body" data-group="slide">
	                	<img src="<?php echo base_url()?>assets/frontend/images/Esa-Unggul-Citra-Raya-1.jpg">
	              	</div>
  	    		</li>
  	    		<li>
	              	<div class="slide-body" data-group="slide">
	                	<img src="<?php echo base_url()?>assets/frontend/images/Esa-Unggul-Citra-Raya-1.jpg">
	              	</div>
  	    		</li>
  	    	</ul>
        </div>
        <a class="slider-control left" href="#" data-jump="prev">Prev</a>
        <a class="slider-control right" href="#" data-jump="next">Next</a>
        <div class="pages">
          <a class="page" href="#" data-jump-to="1">1</a>
          <a class="page" href="#" data-jump-to="2">2</a>
          <a class="page" href="#" data-jump-to="3">3</a>
        </div>
    	</div>
      <!-- Responsive slider - END -->
	</div>
<!-- </div> -->

<div style="padding: 60px 0">
	<div class="container">
			<div class="col-md-9">
			<h2 class="tittle">DAFTAR SEMINAR</h2>
			<?php
				//echo "<pre>", print_r($seminar);
				foreach ($seminar as $key => $value): 
			?>
				<div class="col-md-4">
					<div class="panel panel-default">
					  <div class="panel-body">
					  	<p class="title-seminar"><?php echo $value['tema_seminar'] ?></p>
					    <a href="#" class="thumbnail">
					      <img src="<?php echo $value['poster_seminar'] ?>" style="height:360px" alt="...">
					    </a>
					    <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#myModal-<?php echo $value['id_seminar'] ?>">Daftar</button>
					  </div>
					</div>
				</div>

			<!-- Modal -->
			<div id="myModal-<?php echo $value['id_seminar'] ?>" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Seminar</h4>
			      </div>
			      <div class="modal-body">
			        <div class="panel panel-default">
					  <div class="panel-body">
					  <?php $session_mhs = $this->session->userdata('CMS_mahasiswa'); 
					  //echo "<pre>",print_r($session_mhs);
					  ?>
					    <table class="table">
					    	<tr>
				    		<td width="160px">Tema Seminar</td>
					    		<td width="10px">:</td>
					    		<td><?php echo $value['tema_seminar'] ?></td>
					    	</tr>
					    	<tr>
					    		<td>Pembicara Seminar</td>
					    		<td>:</td>
					    		<td><?php echo $value['pembicara_seminar'] ?></td>
					    	</tr>
					    	<tr>
					    		<td>Jadwal Seminar</td>
					    		<td>:</td>
					    		<td><?php echo $value['jadwal_seminar'] ?></td>
					    	</tr>
					    	<tr>
					    		<td>Tempat Seminar</td>
					    		<td>:</td>
					    		<td><?php echo $value['tempat_seminar'] ?></td>
					    	</tr>
					    	<tr>
					    		<td>Kuota Seminar</td>
					    		<td>:</td>
					    		<td><?php echo $value['kuota_seminar'] ?></td>
					    	</tr>
					    	<tr>
					    		<td>Sisa Kuota Seminar</td>
					    		<td>:</td>
					    		<td><?php echo $value['sisa_kuota'] ?></td>
					    	</tr>
							<tr>
					    		<td>Kelas Seminar</td>
					    		<td>:</td>
					    		<td><?php 
								switch($value['untuk_kelas']){
									case '1' :
									$kelas_seminar = 'Reguler' ;
									break;
									
									case '2' :
									$kelas_seminar = 'Paralel' ;
									break;
									default :
									$kelas_seminar = 'Paralel dan Reguler' ;
								}
								echo $kelas_seminar ?></td>
				    		</tr>							
					    	<tr>
					    		<td>Semester Seminar</td>
					    		<td>:</td>
					    		<td><?php echo $value['semester_seminar'] ?></td>
					    	</tr>
					    	<tr>
					    		<td>NIM Mahasiswa</td>
					    		<td>:</td>
					    		<td><?php echo $session_mhs['nim_mahasiswa']?></td>
					    	</tr>
					    	<tr>
					    		<td>Nama Mahasiswa</td>
					    		<td>:</td>
					    		<td><?php echo $session_mhs['nama_depan'].' '.$session_mhs['nama_belakang']?></td>
					    	</tr>    	
					    	<tr>
					    		<td colspan="3" style="color:red">*Pastikan data mahasiswa sudah benar, jika belum silahkan ubah data mahasiswa</td>
					    	</tr>
					    </table>
					  </div>
					</div>
			      </div>
			      <div class="modal-footer">
			        <button id="btn_seminar_<?php echo $value['id_seminar'];?>" type="button" class="btn btn-primary btn-lg" style="width:100%" sem_id="<?php echo $value['id_seminar'] ?>" onclick="daftar_seminar(<?php echo $value['id_seminar'] ?>)">Daftar</button>
			      </div>
			    </div>

			  </div>
			</div>

			<?php		
				endforeach;
			?>
		</div>
		<!-- Comming soon -->
		<div class="col-md-3">
			<h2 class="tittle">Coming Soon</h2>	
			<div class="row" style="border : 1px solid grey ; background: #c1c1c1 ; border-radius : 5px ; padding : 5px; margin-bottom: 10px">			
				<!-- baris 1 -->
		  		<div>
		  			<div class="title" style="padding: 0 0 20px 0; text-align: center; color: #FFFFFF; font-family: monospace, fantasy;">
				  		<label>Perkembangan masa depan</label>
				  	</div>
				    <a href="#" class="thumbnail">
				      	<img src="http://localhost/seminar/assets/uploads/poster_seminar/display/250/400/vfxfbsgyza.jpg" style="height:360px" alt="...">
				    </a>
		  		</div>
		  		<!-- baris 1 -->
		  		<div style="border : 1px solid grey ; background: #0066FF ; border-radius : 5px ; padding : 5px ;margin-bottom: 10px">
		  			<div class="title" style="padding: 0 0 20px 0; text-align: center; color: #FFFFFF; font-family: monospace, fantasy;">
				  		<label>Perkembangan masa depan</label>
				  	</div>
				    <a href="#" class="thumbnail">
				      	<img src="http://localhost/seminar/assets/uploads/poster_seminar/display/250/400/vfxfbsgyza.jpg" style="height:360px" alt="...">
				    </a>
		  		</div>
		  		<!-- baris 1 -->
		  		<div style="border : 1px solid grey ; background: #0066FF ; border-radius : 5px ; padding : 5px ;margin-bottom: 10px">
		  			<div class="title" style="padding: 0 0 20px 0; text-align: center; color: #FFFFFF; font-family: monospace, fantasy;">
				  		<label>Perkembangan masa depan</label>
				  	</div>
				    <a href="#" class="thumbnail">
				      	<img src="http://localhost/seminar/assets/uploads/poster_seminar/display/250/400/vfxfbsgyza.jpg" style="height:360px" alt="...">
				    </a>
		  		</div>
		  		<!-- baris 1 -->
		  		<div style="border : 1px solid grey ; background: #0066FF ; border-radius : 5px ; padding : 5px ;margin-bottom: 10px">
		  			<div class="title" style="padding: 0 0 20px 0; text-align: center; color: #FFFFFF; font-family: monospace, fantasy;">
				  		<label>Perkembangan masa depan</label>
				  	</div>
				    <a href="#" class="thumbnail">
				      	<img src="http://localhost/seminar/assets/uploads/poster_seminar/display/250/400/vfxfbsgyza.jpg" style="height:360px" alt="...">
				    </a>
		  		</div>
			
			</div>
		</div>
		<!-- END Comming soon -->
	</div>
</div>


<div class="teachers">
	<div class="container">
		<div class="teach-head">
			<h3>OUR TEACHERS</h3>
			<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis 
			praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate.</p>
		</div>
		<div class="team-grids">
			<div class="col-md-3 team-grid text-center">
				<div class="team-img">
					<img src="<?php echo base_url()?>assets/frontend/images/1.png" alt=""/>
					<h3>FEDERICA</h3>
					<h4>Co-founder</h4>
					<p>Nam libero tempore, cum soluta nobis
					est eligendi optio cumque nihil impedit
					quo minus</p>
					<ul>
						<li><a class="fb" href="#"></a></li>
						<li><a class="twitt" href="#"></a></li>
						<li><a class="goog" href="#"></a></li>
						<li><a class="drib" href="#"></a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-3 team-grid text-center">
				<div class="team-img">
					<img src="<?php echo base_url()?>assets/frontend/images/2.png" alt=""/>
					<h3>PATRICK</h3>
					<h4>Co-founder</h4>
					<p>Nam libero tempore, cum soluta nobis
					est eligendi optio cumque nihil impedit
					quo minus</p>
					<ul>
						<li><a class="fb" href="#"></a></li>
						<li><a class="twitt" href="#"></a></li>
						<li><a class="goog" href="#"></a></li>
						<li><a class="drib" href="#"></a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-3 team-grid text-center">
				<div class="team-img">
					<img src="<?php echo base_url()?>assets/frontend/images/3.png" alt=""/>
					<h3>THOMPSON</h3>
					<h4>Co-founder</h4>
					<p>Nam libero tempore, cum soluta nobis
					est eligendi optio cumque nihil impedit
					quo minus</p>
					<ul>
						<li><a class="fb" href="#"></a></li>
						<li><a class="twitt" href="#"></a></li>
						<li><a class="goog" href="#"></a></li>
						<li><a class="drib" href="#"></a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-3 team-grid text-center">
				<div class="team-img">
					<img src="<?php echo base_url()?>assets/frontend/images/4.png" alt=""/>
					<h3>VICTORIA</h3>
					<h4>Co-founder</h4>
					<p>Nam libero tempore, cum soluta nobis
					est eligendi optio cumque nihil impedit
					quo minus</p>
					<ul>
						<li><a class="fb" href="#"></a></li>
						<li><a class="twitt" href="#"></a></li>
						<li><a class="goog" href="#"></a></li>
						<li><a class="drib" href="#"></a></li>
					</ul>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<div class="facilities">
	<div class="container">
		<h3 class="tittle">FACILITIES</h3> 	
				<div class="view view-seventh">
                    <a href="<?php echo base_url()?>assets/frontend/images/g1.jpg" class="b-link-stripe b-animate-go  swipebox"  title="Image Title"><img src="<?php echo base_url()?>assets/frontend/images/g1.jpg" alt="" >
                    <div class="mask">
                        <h4>TUTELAGE</h4>
                        <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                        
                    </div></a>
                </div>
                <div class="view view-seventh">
                    <a href="<?php echo base_url()?>assets/frontend/images/g2.jpg" class="b-link-stripe b-animate-go  swipebox"  title="Image Title"><img src="<?php echo base_url()?>assets/frontend/images/g2.jpg" alt="" >
                    <div class="mask">
                         <h4>TUTELAGE</h4>
                        <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                        
                    </div></a>
                </div>
                <div class="view view-seventh">
                    <a href="<?php echo base_url()?>assets/frontend/images/g3.jpg" class="b-link-stripe b-animate-go  swipebox"  title="Image Title"><img src="<?php echo base_url()?>assets/frontend/images/g3.jpg" alt="">
                    <div class="mask">
                         <h4>TUTELAGE</h4>
                        <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                        
                    </div></a>
                </div>
                <div class="view view-seventh">
                    <a href="<?php echo base_url()?>assets/frontend/images/g4.jpg" class="b-link-stripe b-animate-go  swipebox"  title="Image Title"><img src="<?php echo base_url()?>assets/frontend/images/g4.jpg" alt="">
                    <div class="mask">
                        <h4>TUTELAGE</h4>
                        <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                        
                    </div></a>
                </div>
				<div class="view view-seventh">
                    <a href="<?php echo base_url()?>assets/frontend/images/g5.jpg" class="b-link-stripe b-animate-go  swipebox"  title="Image Title"><img src="<?php echo base_url()?>assets/frontend/images/g5.jpg" alt="">
                    <div class="mask">
                        <h4>TUTELAGE</h4>
                        <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                        
                    </div></a>
                </div>
				<div class="view view-seventh">
                    <a href="<?php echo base_url()?>assets/frontend/images/g6.jpg" class="b-link-stripe b-animate-go  swipebox"  title="Image Title"><img src="<?php echo base_url()?>assets/frontend/images/g6.jpg" alt="">
                    <div class="mask">
                        <h4>TUTELAGE</h4>
                        <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                        
                    </div></a>
                </div>
				<div class="clearfix"></div>
	</div>
</div>
<!-- //our facilities -->
<!-- features -->
<div class="features">
	<div class="container">
		<h3 class="tittle">FEATURES</h3> 
		<div class="col-md-5 features-left">
			<img src="<?php echo base_url()?>assets/frontend/images/f1.jpg" alt=""/>
		</div>
		<div class="col-md-7 features-right">
			<h4>SPECIAL CARE ON STUDENTS</h4>
				<p> Neque porro quisquam est, qui dolorem ipsum 
				quia dolor sit amet, consectetur, adipisci velit, 
				sed quia non numquam eius modi tempora incidunt ut 
				labore et dolore magnam aliquam quaerat voluptatem. 
				Ut enim ad minima veniam, quis nostrum exercitationem 
				ullam corporis suscipit laboriosam, nisi ut aliquid 
				ex ea commodi consequatu.</p>
				<p>Temporibus autem quibusdam et aut officiis debitis aut rerum 
				necessitatibus saepe eveniet ut et voluptates repudiandae sint et 
				molestiae non recusandae. Itaque earum rerum veniam, quis nostrum exercitationem 
				ullam corporis suscipit laboriosam, nisi ut aliquid 
				ex ea commodi consequatu.</p>

		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- //features -->
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
<!-- //footer -->

<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>

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
<script src="<?php echo base_url()?>assets/frontend/js/jquery.event.move.js"></script>
<script src="<?php echo base_url()?>assets/frontend/js/responsive-slider.js"></script>
<script>
	function daftar_seminar(id_seminar){

		var id_mhs 		= "<?php echo $session_mhs['id_mahasiswa']?>";

		if(!id_mhs){
			alert('Maaf, Anda harus login sebelum mendaftar!');
			location.href = "<?php echo base_url('login'); ?>";
		}else{
			//alert($(this).attr('sem_id'));return false;
			$.ajax({
		        type: 'POST',
		        url: "<?php echo base_url('front/seminar/submit_order') ?>",
		        data: {
		         'id_mhs': id_mhs,
		         'id_seminar': id_seminar

		        },
		        dataType: 'json',
		        success: function(results){
		        	console.log(results);
	             	if(results.status == "success"){
		              	alert("Terima kasih, Anda telah terdaftar di seminar");
		              	location.href = results.location;
		              	return true;
	             	}else{
	             		alert(results.alert);
		              	window.location.reload();
	             	}

	             	return false;
		        }
	  		});
		}

		

	}

$(document).on("click","#btn_seminar_"+$(this).attr('sem_id'), function(){
	alert();
    /*var formData = {
            id: $(this).attr("id"),
            id_user: $(this).attr("id_user"),
            point_user: $(this).attr("point")
    };
    $.ajax({
        type: "POST",
        url: URL+'front/reward/viewGift',
        data: formData,
        dataType: "json",
        success: function(res){
            if (res.notif != '') {
		alert(res.notif);
		$("#GiftRedeem").modal('hide'); 
		return false ;
	    }else{
                $("#GiftRedeem").modal('show'); 
                return ($("#modalName").text(res.data["name"])+
                $("#modalAgentName").text('Agent Name : '+res.data["agent_name"])+
                $("#modalMG_userID").text('MG User ID : '+res.data["mg_user_id"])+
                $("#modalStausMember").text(res.data["status_member"])+
                $("#modalValue").text(res.data["value"])+
                $("#modaldescriptionGift").text(res.data["description"])+
                $("#modalRemark").text('Jumlah point Kamu akan berkurang sebanyak '+res.data["point"]+' point')+
                $('#modalImg').attr('src', res.data["pict_name"])+
                $('#gift_id').val(res.data["id"])+
                $('#point').val(res.data["point"])+
                $('#point_user').val(formData.point_user)+
                $('#user_id').val(formData.id_user)+
		$('#typeGift').val(res.data["type"]));
            }
        }
    });*/
});

</script>