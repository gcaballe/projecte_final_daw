/* engego el datepicker i timepicker */

$(function () {
	$("#date").datepicker();
});

$(function () {
	$('#hour').timepicker();
});


/* load animation */
function onload_function() {
	setTimeout(showPage, 1000);
}
  
function showPage() {
	document.getElementById("loader").style.display = "none";
	document.getElementById("page_content").style.display = "block";
}






/**
 * Posa un warning si tens les caps activades
 */
function capLock(e, num){
	var kc = e.keyCode ? e.keyCode : e.which;
	var sk = e.shiftKey ? e.shiftKey : kc === 16;
	var visibility = ((kc >= 65 && kc <= 90) && !sk) || 
		((kc >= 97 && kc <= 122) && sk) ? 'visible' : 'hidden';
	document.getElementById('divMayus'+num).style.visibility = visibility
}




/**
 * password show/hide
 */

function passwordswitch(){
	var x = document.getElementById("password_login");
	if (x.type === "password") {
	  x.type = "text";
	} else {
	  x.type = "password";
	}
}





/**
 * strong password
 * 
 * */

$(document).ready(function() {
	$('#password_reg').keyup(function() {
	$('#result_strong_password').html(checkStrength($('#password_reg').val()))
	})
		function checkStrength(password) {
		var strength = 0
		if (password.length < 6) {
			$('#result_strong_password').removeClass()
			$('#result_strong_password').addClass('short')
		return 'Too short'
		}
		if (password.length > 7) strength += 1
		// If password contains both lower and uppercase characters, increase strength value.
		if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
		// If it has numbers and characters, increase strength value.
		if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
		// If it has one special character, increase strength value.
		if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
		// If it has two special characters, increase strength value.
		if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
		// Calculated strength value, we can return messages
		// If value is less than 2
		if (strength < 2) {
			$('#result_strong_password').removeClass()
			$('#result_strong_password').addClass('weak')
			return 'Weak'
		} else if (strength == 2) {
			$('#result_strong_password').removeClass()
			$('#result_strong_password').addClass('good')
			return 'Good'
		} else {
			$('#result_strong_password').removeClass()
			$('#result_strong_password').addClass('strong')
			return 'Strong'
		}
	}
});




/** AJAX REQUEST */

function ajax_test(option, act_id){
	console.info("I'm about to mark as '"+option+"' the activity: "+act_id);

	 $.ajax({
		url: '/projecte_daw/index.php/Company/mark_as_' + option +'/'+act_id,
		type: 'GET',
		error: function() {
		   alert('Something is wrong');
		},
		success: function(data) {
			if(option == "closed"){
				
				//edita boto
				var but = document.getElementById('ajax_button_closed' + act_id);
				but.style.display = "none";

				alert("Activity marked as closed!");
			}else{
				
				//edita boot
				var but = document.getElementById('ajax_button_done' + act_id);
				//li canvio: text, color(class), onClick i id
				but.innerHTML = "Close!";
				but.classList.remove("btn-primary");
				but.classList.add("btn-danger");
				//but.addEventListener("click", ajax_test('closed',act_id));
				but.setAttribute('onclick','ajax_test(\'closed\', '+act_id+')');
				but.id = "ajax_button_closed"+act_id;

				alert("Activity marked as done!")
			}
		}
	 });


 };