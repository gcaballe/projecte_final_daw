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
	<h1>Welcome to projecte DAW!</h1>

	<div id="content">
		
        <form method="post" action="<?php echo site_url("login/verify_user") ?>" >
        
            <label for="username" >Username:<br></label>
            <input type="text" id="username" name="username"/>
            
            <label for="password" >Password:<br></label>
            <input type="password" id="password" name="password" />
            
            <input type="submit" value="Login" />
        
        </form>
        
        
	</div>

	<p class="footer">Footer</p>
</div>

</body>
</html>