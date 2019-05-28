<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	</style>
    
  <!-- tot aixo hauria de anar a un include -->
  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap-4.3.1-dist/css/bootstrap.css')?>" >
	<script src="<?php echo base_url('assets/bootstrap-4.3.1-dist/js/jquery-3.4.1.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/bootstrap-4.3.1-dist/js/bootstrap.min.js') ?>"></script>

</head>
<body>

  <?php
    $this->load->view('header');
  ?>

<div id="container">
	<h1>Welcome to client panel</h1>

	<div id="content">

        <h1>List of open activities:</h1>
        
        <div class="accordion" id="accordionListActivities">
        
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

            <div id="collapse<?php echo $i; ?>" class="collapse" aria-labelledby="heading<?php echo $i; ?>" data-parent="#accordionListActivities">
              <div class="card-body">
                <?php echo $act->getStatus(); ?><br>
                <?php echo $act->getDescription(); ?><br>
                <?php echo $act->getProduct()->getName(); ?><br>
                <?php echo $act->getProduct()->getDescription(); ?><br>
                
                <!-- botó enroll, unenroll -->
				<?php
				if(!isset($enrollments[$act->getId()])){				
					echo "<a href='" . site_url("client/enroll/" . $act->getId()) . "'><button class='btn btn-primary'>Enroll!</button></a>";
				}else{
					echo "<a href='" . site_url("client/undo_enroll/" . $act->getId()) . "'><button class='btn btn-danger'>Undo!</button></a>";
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
        
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        
        <h1>List of open activities:</h1>
        
        <div class="accordion" id="accordionListActivities">
        
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

                <div id="collapse<?php echo $i; ?>" class="collapse" aria-labelledby="heading<?php echo $i; ?>" data-parent="#accordionListActivities">
                  <div class="card-body">
                    <?php echo $act->getStatus(); ?><br>
                    <?php echo $act->getDescription(); ?><br>
                    <?php echo $act->getProduct()->getName(); ?><br>
                    <?php echo $act->getProduct()->getDescription(); ?><br>
                    
                    <!-- botó enroll, unenroll -->
                    <?php
                        //if($enrollments[$i] == 1)
                    ?>
                    <a href="<?php echo site_url("client/enroll/" . $act->getId()) ?>"><button class="btn btn-primary">Enroll!</button></a>
                  </div>
                </div>
            </div>
              
            <?php
                    $i++;
                }  
            ?>
        
        </div>
        
        
	</div>

</div>

  <?php
    $this->load->view('footer');
  ?>

</body>
</html>
