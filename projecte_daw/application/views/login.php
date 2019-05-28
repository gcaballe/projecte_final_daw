<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">
      #map {
        height: 200px;
        width: 400px;
      }
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
            <input type="text" id="company_name" name="company_name"/><br>
            
            <label for="cif" >CIF:<br></label>
            <input type="text" id="cif" name="cif"/><br>
            
            <label for="map" >Localitzation:<br></label>
            
            <input type="hidden" name="lat" id="lat">
            <input type="hidden" name="lng" id="lng">

            

            <div id="map"></div>
            
            <script>
            
            var map;
            var marker = false;
                    
            function initMap() {
            
                var centerOfMap = new google.maps.LatLng(41.586,1.591);
            
                var options = {
                center: centerOfMap,
                zoom: 7
                };

                map = new google.maps.Map(document.getElementById('map'), options);
            
                google.maps.event.addListener(map, 'click', function(event) {                
                    //Get the location that the user clicked.
                    var clickedLocation = event.latLng;
                    //If the marker hasn't been added.
                    if(marker === false){
                        //Create the marker.
                        marker = new google.maps.Marker({
                            position: clickedLocation,
                            map: map,
                            draggable: true //make it draggable
                        });
                        //Listen for drag events!
                        google.maps.event.addListener(marker, 'dragend', function(event){
                            markerLocation();
                        });
                    } else{
                        //Marker has already been added, so just change its location.
                        marker.setPosition(clickedLocation);
                    }
                    //Get the marker's location.
                    markerLocation();
                });
            }
                    
            //This function will get the marker's current location and then add the lat/long
            //values to our textfields so that we can save the location.
            function markerLocation(){
                //Get location.
                var currentLocation = marker.getPosition();
                //Add lat and lng values to a field that we can save.
                document.getElementById('lat').value = currentLocation.lat(); //latitude
                document.getElementById('lng').value = currentLocation.lng(); //longitude
            }
            
            </script>

            <?php $key = "AIzaSyC_RzZ21aBuLLg_Z8TEw0M6a0Psz8eM5Tc";?>

            <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $key; ?>&callback=initMap"
            async defer></script>

            

            <input type="submit" value="Register" />
        
        </form>
        
        
	</div>

	<p class="footer">Footer</p>
</div>

</body>
</html>