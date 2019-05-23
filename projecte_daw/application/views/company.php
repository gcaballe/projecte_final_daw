<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	</style>
</head>
<body>

<div id="container">
	<h1>Welcome to Company panel!</h1>

	<div id="content">
	
        <h2>Crea una nova activitat</h2>
        
            <form method="post" action="<?php echo site_url("company/add_activity") ?>" >
        
                <label for="name" >Name:<br></label>
                <input type="text" id="name" name="name"/><br>
                
                <label for="product" >Product:<br></label>
                <select id="product" name="product">
                    <?php
                        $productes = array(
                            array("id"=>0, "name"=>"jamon"),
                            array("id"=>1, "name"=>"queso"),
                            array("id"=>2, "name"=>"vinillo peleón")
                        );
                        foreach($productes as $p){
                            echo "<option value=".$p['id'].">".$p['name']."</option>";
                        }
                    ?>
                </select><br>
                
                <label for="type" >Type:<br></label>
                <input type="text" id="type" name="type" /><br>
                
                <label for="description" >Description:<br></label>
                <input type="text" id="description" name="description" /><br>
                
                <label for="date" >Date:<br></label>
                <input type="datepicker" id="date" name="date" /><br>
                
                <label for="hour" >Hour:<br></label>
                <input type="timepicker" id="hour" name="hour" /><br>
                
                <input type="submit" value="Create" />
            
            </form>
        
        
        
        <h2>Llista de les nostres activitats</h2>
        
        
	</div>

	<p class="footer">Footer</p>
</div>

</body>
</html>