<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	</style>
    
    
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body>


<a href="<?php echo site_url("client/logout/")?>"><button class="btn btn-primary">Logout!</button></a>


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
                <a href="<?php echo site_url("client/enroll/" . $act->getId()) ?>"><button class="btn btn-primary">Enroll!</button></a>
                <a href="<?php echo site_url("client/undo_enroll/" . $act->getId()) ?>"><button class="btn btn-danger">Undo!</button></a>
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

	<p class="footer">Footer</p>
</div>

</body>
</html>