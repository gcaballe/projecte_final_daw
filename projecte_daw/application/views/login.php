<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<?php
		$this->load->view('head_includes');
	?>	

    
	<!-- google maps shit -->
	<?php $key = "AIzaSyC_RzZ21aBuLLg_Z8TEw0M6a0Psz8eM5Tc";?>
	<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $key; ?>&callback=initMap"
	async defer></script>

	<script>
            
		var map;
		var marker = false;
                    
		function initMap() {
            
			var centerOfMap = new google.maps.LatLng(41.586,1.591); //Igualada
            
			var options = {
				center: centerOfMap,
				zoom: 7
			};

			map = new google.maps.Map(document.getElementById('map'), options);
            
			google.maps.event.addListener(map, 'click', function(event) {                
				var clickedLocation = event.latLng;
				if(marker === false){
					marker = new google.maps.Marker({
						position: clickedLocation,
						map: map,
						draggable: true //make it draggable
					});
					google.maps.event.addListener(marker, 'dragend', function(event){
						markerLocation();
					});
				} else{
					marker.setPosition(clickedLocation);
				}
				markerLocation();
			});
		}

		function markerLocation(){
			var currentLocation = marker.getPosition();
			document.getElementById('lat').value = currentLocation.lat();
			document.getElementById('lng').value = currentLocation.lng();
		}
            
	</script>

	<script>
		//no puc posar aquesta funcio a scripts.js per que té php echo's
		//el swtich de si ets company o No
		function imcompany(){
			var d = document.getElementById('info_company');
			console.info(d.style.display);
			if(d.style.display == "none" || d.style.display == ""){
				d.style.display = "block";
				form_register.action="<?php echo site_url("login/register_company") ?>";
			}else{
				d.style.display = "none";
				form_register.action="<?php echo site_url("login/register_user") ?>";
			}
		}

	</script>

	<!-- aquest style esta separat xk nomès s'utilitza aqui, aixi no el carrego cada cop -->
	<link rel="stylesheet" href="<?php echo base_url() . "assets/login_style.css"; ?>">

</head>
<body class="area">

	<?php
		$this->load->view('header');
	?>

	<!-- copes al background -->
    <ul class="cubs_voladors">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
    </ul>

	<div id="container">
	<div class="row m-5">
		
		<div class="col-9 offset-2 col-sm-6 offset-sm-0 col-lg-4 offset-lg-2">

			<form class="rounded bg-light p-4" method="post" action="<?php echo site_url("login/verify_user") ?>" >
        
				<h1>Login</h1>

				<div class="form-group">
					<label for="username" >Username:</label><br>
					<input type="text" id="username" name="username"/><br>
				</div>

				<div class="form-group">
					<label for="password" >Password:</label><br>
					<input type="password" id="password" name="password" /><br>
				</div>

				<input class="btn btn-primary" type="submit" value="Login" />
        
			</form>

		</div>

		<div class="col-9 offset-2 col-sm-6 offset-sm-0 col-lg-4 mb-5">
        
			<form class="rounded bg-light mb-5 p-4" id="form_register" method="post" action="<?php echo site_url("login/register_user") ?>" >
		
				<h1>Register</h1>

				<div class="form-group">
					<p>Are you a company?</p>
					<label class="switch">
					  <input id="company_switch" onChange="imcompany()" type="checkbox">
					  <span class="slider round"></span>
					</label>
				</div>

				<div class="form-group">
					<label for="username" >Username:</label><br>
					<input type="text" id="username" name="username"/><br>
				</div>

				<div class="form-group">
					<label for="password" >Password:</label><br>
					<input type="password" id="password" name="password" /><br>
				</div>

				<div class="form-group">
					<label for="password2" >Confirm password:</label><br>
					<input type="password" id="password2" name="password2" /><br>
				</div>

				<div class="form-group">
					<label for="email" >Email:</label><br>
					<input type="email" id="email" name="email" /><br>
				</div>

				<!-- info de company -->
				<div id="info_company">

					<h4>Company information:</h4>
					
					<div class="form-group">
						<label for="company_name" >Company name:</label><br>
						<input type="text" id="company_name" name="company_name"/><br>
					</div>
            
					<div class="form-group">
						<label for="cif" >CIF:</label><br>
						<input type="text" id="cif" name="cif"/><br>
					</div>

					<div class="form-group">
						<label for="map" >Localitzation:</label><br>
            
						<input type="hidden" name="lat" id="lat">
						<input type="hidden" name="lng" id="lng">

						<div id="map"></div><br>
					</div>
				</div>

				<input class="btn btn-primary" type="submit" value="Register" />
        
			</form>
        </div>

	</div>
	</div>

	<?php
		$this->load->view('footer');
	?>

</body>
</html>
