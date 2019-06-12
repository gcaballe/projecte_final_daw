<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Gcaballe - Projecte DAW</title>

	<?php
		$this->load->view('head_includes');
	?>

	<style type="text/css">
	
		.rate {
			float: left;
			height: 46px;
			padding: 0 10px;
		}
		.rate:not(:checked) > input {
			position:absolute;
			top:-9999px;
		}
		.rate:not(:checked) > label {
			float:right;
			width:1em;
			overflow:hidden;
			white-space:nowrap;
			cursor:pointer;
			font-size:30px;
			color:#ccc;
		}
		.rate:not(:checked) > label:before {
			content: '★ ';
		}
		.rate > input:checked ~ label {
			color: #ffc700;    
		}
		.rate:not(:checked) > label:hover,
		.rate:not(:checked) > label:hover ~ label {
			color: #deb217;  
		}
		.rate > input:checked + label:hover,
		.rate > input:checked + label:hover ~ label,
		.rate > input:checked ~ label:hover,
		.rate > input:checked ~ label:hover ~ label,
		.rate > label:hover ~ input:checked ~ label {
			color: #c59b08;
		}
	</style>
    
  <!-- tot aixo hauria de anar a un include -->
  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap-4.3.1-dist/css/bootstrap.css')?>" >
	<script src="<?php echo base_url('assets/bootstrap-4.3.1-dist/js/jquery-3.4.1.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/bootstrap-4.3.1-dist/js/bootstrap.min.js') ?>"></script>

</head>
<body>

<!-- loading animation -->
<div id="loader" class="cheese_loader"></div>
<div id="page_content">
<script>
	onload_function();
</script>

  <?php
    $this->load->view('header');
  ?>

<div id="client_container">
	<div class="m-2 p-2 row">

		<div class="col-12 col-md-8 col-lg-5">
			<h1>List of open activities:</h1>
        
			<div class="accordion" id="accordionListActivities">
        
			<?php       
				$i = 0;
				$mesos = ["Gener", "Febrer", "Març", "Abril", "Maig", "Juny", "Juliol", "Agost", "Setembre", "Octubre", "Novembre", "Desembre"];
				foreach($activities as $act){
                
			?>
        
			  <div class="card rounded">
				<div class="card-header" id="heading<?php echo $i; ?>">
				  <div class="mb-0">
					<button class="btn w-100" type="button" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse<?php echo $i; ?>">
					  <!-- data dins del boto llista -->
						<div class="row">
							<div class="d-none d-sm-block w-10">#<?php echo $i; ?></div>
							<div class="col-5"><?php echo $act->getName(); ?></div>
							<div class="col-5 offset-1">
									<?php
										$d = date_parse($act->getTimestamp());
										echo $d['day'] . " de " . $mesos[$d['month']] . ", a les " . $d['hour'] . ":";
										if($d['minute']<10) echo "0" . $d['minute'];
										else echo $d['minute'];
									?>
							</div>
						</div>
					</button>
				  </div>
				</div>

				<div id="collapse<?php echo $i; ?>" class="collapse" aria-labelledby="heading<?php echo $i; ?>" data-parent="#accordionListActivities">
				  <div class="card-body">

					<p><?php echo $act->getDescription(); ?></p>
					<p>Producte a tastar: <?php echo $act->getProduct()->getName(); ?></p>
					<p><?php echo $act->getProduct()->getDescription(); ?></p>
                
					<!-- botó enroll, unenroll -->
					<?php
					if($act->getStatus() == "open"){
						if(!isset($enrollments[$act->getId()])){				
							echo "<a href='" . site_url("client/enroll/" . $act->getId()) . "'><button class='btn btn-primary'>Enroll!</button></a>";
						}else{
							echo "<a href='" . site_url("client/undo_enroll/" . $act->getId()) . "'><button class='btn btn-danger'>Undo!</button></a>";
						}
					}else if ($act->getStatus() == "done"){
						echo "<p>Did you enjoy the activity?</p>";
						echo "<input type='number' min=1 max=5 id='rating' name='rating'/>";
					}
					?>
                
                
				  </div>
				</div>
			  </div>
          
			<?php
        
					$i++;
				}
            
			?>
         
			</div>
		</div>


		<div class="col-12 col-md-4 offset-md-0 col-lg-6 offset-lg-1 mt-2 mt-lg-0" id="rate_experiences">
			
			<h1>Rate your experiences!</h1>
        
			<div class="row">
				<?php       
					$i = 0;
					foreach($myDoneActivities as $act){
				?>

					<div class="col-8 offset-sm-2 col-md-12 offset-md-0 col-lg-5 m-1 card">
						<div class="card-body">
							<h2 class="card-title"><?php echo $act->getName(); ?></h2>
							<p class="card-text"><?php echo $act->getDescription(); ?></p>

							<div>
								<!-- info del producte-->
								<p>Vas tastar: <?php echo $act->getProduct()->getName(); ?></p>
								<p><?php echo $act->getProduct()->getDescription(); ?></p>
							</div>

							<form action="<?php echo site_url('client/rate_activity'); ?>" method="post" >
								<!-- 5 star rating system -->
								<input type="hidden" name="act_id" id="act_id" value="<?php echo $act->getId(); ?>" />
								<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_session->getId(); ?>" />
						
								<div class="rate">
									<input type="radio" id="star5" name="rate" value="5" />
									<label for="star5" title="text">5 stars</label>
									<input type="radio" id="star4" name="rate" value="4" />
									<label for="star4" title="text">4 stars</label>
									<input type="radio" id="star3" name="rate" value="3" />
									<label for="star3" title="text">3 stars</label>
									<input type="radio" id="star2" name="rate" value="2" />
									<label for="star2" title="text">2 stars</label>
									<input type="radio" id="star1" name="rate" value="1" />
									<label for="star1" title="text">1 star</label>
								</div>
                                
								<div class="form-group">
									<label for="text_review">Any opinions?<br></label>
									<input type="text" name="text_review" id="text_review" /><br>
								</div>

								<input class="btn btn-primary" type="submit" value="Rate this!" />
							</form>

						</div>
					</div>


				<?php
        
						$i++;
					}
            
				?>
			</div>
		</div>

        <h2 class="p4">
        <a href="http://92.222.27.83:8080/jasperserver/rest_v2/reports/w2-gcaballe/report_usuari.html?j_username=w2-gcaballe&j_password=47105665D&id_user=
        <?php echo $user_session->getId(); ?>"
        >El teu report</a>
        </h2>
	</div>
</div>

  <?php
    $this->load->view('footer');
  ?>

</body>
</html>
