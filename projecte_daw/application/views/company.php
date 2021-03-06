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
	
	<!-- CLOCKPICKER -->
	<script type="text/javascript" src="<?php echo base_url('assets\clockpicker\jquery.timepicker.js') ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets\clockpicker\jquery.timepicker.css') ?>" >
	<!-- DATEPICKER -->
	<script type="text/javascript" src="<?php echo base_url('assets\clockpicker\lib\bootstrap-datepicker.js') ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets\clockpicker\lib\bootstrap-datepicker.css') ?>" >

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

<div id="company_container">
	<div class="row m-3">

		<!-- new act -->
		<div class="p-3 rounded bg-light col-8 offset-2 col-md-6 offset-md-3 col-lg-4 offset-lg-0">
		
			<form method="post" action="<?php echo site_url("company/add_activity") ?>" >

				<h1>Crea una nova activitat</h1>

				<div class="form-group">
					<label for="name" >Name:</label><br>
					<input type="text" id="name" name="name"/><br>
				</div>
			
				<div class="form-group">
					<label for="product" >Product:</label><br>
					<select id="product" name="product">
						<?php
                
							foreach($products as $p){
								echo "<option value=" . $p->getId() .">" . $p->getName() ."</option>";
							}
                    
						?>
					</select>
					<!-- Button trigger modal -->
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importdataModal">
						Import data
					</button>
					<br>
				</div>
            
				<div class="form-group">
					<label for="description" >Description:</label><br>
					<textarea rows=3 id="description" name="description"></textarea><br>
				</div>
            
				<div class="form-group">
					<label for="date" >Date:</label><br>
					<input id="date" name="date" /><br>
				</div>

				<div class="form-group">
					<label for="hour" >Hour:</label><br>
					<input id="hour" name="hour" type="text" class="time" />
				</div>

				<input class="btn btn-primary" type="submit" value="Create" />
        
			</form>
		</div>

		<!-- list act -->
		<div class="col-12 col-lg-8">
			<h1>List of my activities:</h1>

			<div class="accordion" id="accordionListMyActivities">
        
			<?php       
				$i = 0;
				$mesos = ["Gener", "Febrer", "Març", "Abril", "Maig", "Juny", "Juliol", "Agost", "Setembre", "Octubre", "Novembre", "Desembre"];
				foreach($activities as $act){ 
			?>
			  <div class="card ">
				<div class="card-header" id="heading<?php echo $i; ?>">
				  <div class="mb-0">
						<button class="w-100 btn" type="button" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse<?php echo $i; ?>">
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

				<div id="collapse<?php echo $i; ?>" class="collapse" aria-labelledby="heading<?php echo $i; ?>" data-parent="#accordionListMyActivities">
				  <div class="card-body row">
						<div class="col-4">
							Description:<br> <?php echo $act->getDescription(); ?><br>
							Product:<br>
							<?php echo $act->getProduct()->getName(); ?><br>
							<?php echo $act->getProduct()->getDescription(); ?><br>
						</div>

						<div class="col-8">
										
							<p>Users enrolled:</p>
							<table class="table">
							<caption>
							<th>Name</th>
							<th class='d-none d-md-block'>Mail</th>
							<?php if($act->getStatus() == "done" || $act->getStatus() == "closed") echo "<th>Rating</th><th>Review</th>"; ?>
							</caption>
							<?php 
							foreach ($enrolled_users[$act->getId()] as $u ){
								echo "<tr>
								<td>" . $u->getUsername() . "</td>
								<td class='d-none d-md-block'>" . $u->getEmail() . "</td>";
								/* TO-DO combinar enrolled users i ratings */

								if($act->getStatus() == "done" || $act->getStatus() == "closed"){
									//$rev = Review::find($ratings[$act->getId()], $u->getId());
									foreach($ratings[$act->getId()] as $rev){
									if($rev->getUser() == $u->getId()) {
										echo "<td>";
										for($z = 0; $z < $rev->getRating(); $z++){
											echo "<i class='fas fa-star text-warning'></i>";
										}
										echo "</td>";
										echo "<td>" . $rev->get_text() . "</td>";
									}
									}
								}
								echo "</tr>";
							}
							?>
							</table>
						</div>
					<div class="col-12">
					  <!-- botó Mark as done / Close -->
					  <?php
                  
					  switch($act->getStatus()){
						  case "open":				
								//sense ajax
								//echo "<a href='" . site_url("company/mark_as_done/" . $act->getId()) . "'><button class='btn btn-primary'>Mark as done!</button></a>";
								//amb ajax
								echo "<button id='ajax_button_done" . $act->getId() . "' onClick=\"ajax_test('done', " . $act->getId() . ")\" class='btn btn-primary'>Mark as Done!</button>";
								break;
						  case "done":
							//la seguent linia es sense ajax
								//echo "<a href='" . site_url("company/mark_as_closed/" . $act->getId()) . "'><button class='btn btn-danger'>Close!</button></a>";
								//ara ajax
								echo "<button id='ajax_button_closed" . $act->getId() . "' onClick=\"ajax_test('closed', " . $act->getId() . ")\" class='btn btn-danger'>Close!</button>";
							break;
						  case "closed":
								echo "This activity is already closed.";
							break;
					  }
					  ?>
					</div>

				  </div>
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
        <?php echo $co_id; ?>"
        >El teu report de company</a>
        </h2>

		<!-- Modal // importar dades -->
		<div class="modal fade" id="importdataModal" tabindex="-1" role="dialog" aria-labelledby="importdataModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h2 class="modal-title" id="importdataModalLabel">Importar products via CSV or XML file</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
			
				<form class="rounded m-3 p-2 bg-light" enctype="multipart/form-data" method="post" action="<?php echo site_url('company/import_data');?>">
			
					<div class="form-group">
						Choose a file:<br>
						<input aria-label="select_file" type="file" name="dir_to_search" size="50"><br>
					</div>

					<input class="btn btn-primary" type="submit" value="Import" />

				</form>

			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>


	</div>
</div>

  <?php
    $this->load->view('footer');
  ?>

</body>
</html>
