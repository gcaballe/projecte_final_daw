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
		
        <h1>login</h1>
        <form method="post" action="<?php echo site_url("login/verify_user") ?>" >
        
            <label for="username" >Username:<br></label>
            <input type="text" id="username" name="username"/>
            
            <label for="password" >Password:<br></label>
            <input type="password" id="password" name="password" />
            
            <input type="submit" value="Login" />
        
        </form>
        
        <h1>register user</h1>
        <form method="post" action="<?php echo site_url("login/register_user") ?>" >
        
            <label for="username" >Username:<br></label>
            <input type="text" id="username" name="username"/>
            
            <label for="password" >Password:<br></label>
            <input type="password" id="password" name="password" />
            
            <label for="password2" >Confirm password:<br></label>
            <input type="password" id="password2" name="password2" />
            
            <label for="email" >Email:<br></label>
            <input type="email" id="email" name="email" />
            
            <input type="submit" value="Register" />
        
        </form>
        
        
        <h1>register company</h1>
        <form method="post" action="<?php echo site_url("login/register_company") ?>" >
        
            <label for="username" >Username:<br></label>
            <input type="text" id="username" name="username"/>
            
            <label for="password" >Password:<br></label>
            <input type="password" id="password" name="password" />
            
            <label for="password2" >Confirm password:<br></label>
            <input type="password" id="password2" name="password2" />
            
            <label for="email" >Email:<br></label>
            <input type="email" id="email" name="email" />
            
            
            <p>Info de company:</p>
            
            <label for="company_name" >Company name:<br></label>
            <input type="text" id="company_name" name="company_name"/>
            
            <label for="cif" >CIF:<br></label>
            <input type="text" id="cif" name="cif"/>
            
            <label for="address" >Adress:<br></label>
            <input type="text" id="address" name="address" />
            
            <input type="submit" value="Register" />
        
        </form>
        
        
	</div>

	<p class="footer">Footer</p>
</div>

</body>
</html>