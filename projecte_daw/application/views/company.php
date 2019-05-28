<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	</style>
	
	<!-- aixo ha de estar en un altre arxiu centralitzat -->

	<!-- DATEPICKER -->
<!-- codi del datepicker que funciona
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
-->

  <!--
	<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap-4.3.1-dist/css/bootstrap.css')?>" >
	
	<script src="<?php echo base_url('assets/bootstrap-4.3.1-dist/js/jquery-3.4.1.min.js') ?>"></script>
    
	<script src="<?php echo base_url('assets/bootstrap-4.3.1-dist/js/bootstrap.min.js') ?>"></script>
	-->
	
	<!-- CLOCKPICKER -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<script type="text/javascript" src="<?php echo base_url('assets\clockpicker\jquery.timepicker.js') ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets\clockpicker\jquery.timepicker.css') ?>" >

	<script type="text/javascript" src="<?php echo base_url('assets\clockpicker\lib\bootstrap-datepicker.js') ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets\clockpicker\lib\bootstrap-datepicker.css') ?>" >


  <!-- tot aixo hauria de anar a un include -->
  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap-4.3.1-dist/css/bootstrap.css')?>" >
  <script src="<?php echo base_url('assets/bootstrap-4.3.1-dist/js/bootstrap.min.js') ?>"></script>

	<script>

		$( function() {
			$( "#date" ).datepicker();
		} );

		$(function() {
			$('#hour').timepicker();
		});
	</script>

</head>
<body>

  <?php
    $this->load->view('header');
  ?>

<div id="container">
	<h1>Welcome to Company panel!</h1>

    <h2>Crea una nova activitat</h2>

        <form method="post" action="<?php echo site_url("company/add_activity") ?>" >

            <label for="name" >Name:<br></label>
            <input type="text" id="name" name="name"/><br>
            
            <label for="product" >Product:<br></label>
            <select id="product" name="product">
                <?php
                
                    foreach($products as $p){
                        echo "<option value=" . $p->getId() .">" . $p->getName() ."</option>";
                    }
                    
                ?>
            </select><br>
            
            <label for="description" >Description:<br></label>
            <input type="text" id="description" name="description" /><br>
            
            <label for="date" >Date:<br></label>
    <input id="date" name="date" /><br>
            
            <label for="hour" >Hour:<br></label>
            <input id="hour" name="hour" type="text" class="time" />

            <input type="submit" value="Create" />
        
        </form>
        
        
        
		  <h1>List of my activities:</h1>
        
        <div class="accordion" id="accordionListMyActivities">
        
        <?php       
            $i = 0;
            foreach($activities as $act){
                
        ?>
        
          <div class="card">
            <div class="card-header" id="heading<?php echo $i; ?>">
              <div class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse<?php echo $i; ?>">
                  <!-- data dins del boto llista -->
                  #<?php echo $i; ?>
                  <?php echo $act->getName(); ?>  ---- <?php echo $act->getTimestamp(); ?>
                </button>
              </div>
            </div>

            <div id="collapse<?php echo $i; ?>" class="collapse" aria-labelledby="heading<?php echo $i; ?>" data-parent="#accordionListMyActivities">
              <div class="card-body row">
                <div class="col-6">
                  Status: <?php echo $act->getStatus(); ?><br>
                  Description:<br> <?php echo $act->getDescription(); ?><br>
                  Product:<br>
                  <?php echo $act->getProduct()->getName(); ?><br>
                  <?php echo $act->getProduct()->getDescription(); ?><br>
                </div>

                <div class="col-6">
                  
                  <p>Users enrolled</p>
                  <table class="table">
                  <tr>
                    <th>Name</th>
                    <th>Mail</th>
                    <?php if($act->getStatus() == "done" || $act->getStatus() == "closed") echo "<th>Rating</th>"; ?>
                  </tr>
                  <?php 
                    foreach ($enrolled_users[$act->getId()] as $u ){
                      echo "<tr>
                        <td>" . $u->getUsername() . "</td>
                        <td>" . $u->getEmail() . "</td>";
                        /* TO-DO combinar enrolled users i ratings */

                        if($act->getStatus() == "done" || $act->getStatus() == "closed"){
                          //$rev = Review::find($ratings[$act->getId()], $u->getId());
                          foreach($ratings[$act->getId()] as $rev){
                            if($rev->getUser() == $u->getId()) echo "<td>" . $rev->getRating() . "</td>";
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
                        echo "<a href='" . site_url("company/mark_as_done/" . $act->getId()) . "'><button class='btn btn-primary'>Mark as done!</button></a>";
                        break;
                      case "done":
                        echo "<a href='" . site_url("company/mark_as_closed/" . $act->getId()) . "'><button class='btn btn-danger'>Close!</button></a>";
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

  <h1> Importar products via CSV or XML file </h1>

  <form enctype="multipart/form-data" method="post" action="<?php echo site_url('company/import_data');?>">
     Choose a file:<br>
     <input type="file" name="dir_to_search" size="50"><br>
    <input type="submit" value="Import" />
  </form>

</div>

  <?php
    $this->load->view('footer');
  ?>

</body>
</html>
