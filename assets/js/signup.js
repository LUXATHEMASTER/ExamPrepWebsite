var PASSWORD;
var validUsername=false;
var validEmail=false;
var validPassword=false;
var confirmedPassword=false;

//Checks if a username holds to the required standards
function validateUsername() {
	var xmlhttp;
	var usernameregex = /^[a-z0-9]+$/;
	var username = document.getElementById('form-username1').value;
	if(username.length=0){
		document.getElementById('form-username1').style.backgroundColor = "yellow";
		document.getElementById('checkusername').innerHTML="The username can't be empty.";
		document.getElementById('checkusername').style.color ='red';
		validUsername=false;
	
	}else if ( username.length < 3) {
		document.getElementById('form-username1').style.backgroundColor = "yellow";
		document.getElementById('checkusername').innerHTML="The username is too short.";
		document.getElementById('checkusername').style.color ='red';
		
		validUsername=false;
	}
	else if(username.length > 16){
		document.getElementById('form-username1').style.backgroundColor = "yellow";
		document.getElementById('checkusername').innerHTML="The username is too long.";
		document.getElementById('checkusername').style.color ='red';
		validUsername=false;

	} else if (username.match(usernameregex)) {
		
		document.getElementById('form-username1').style.backgroundColor="white";
		check_username(username)

	} else {
		document.getElementById('checkusername').innerHTML="Enter small charaters only.";
		document.getElementById('checkusername').style.color ='red';
		validUsername=false;

	}
}

//Checks if rmail meets the required starndads
function validateEmail() {
	var usernameregex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	var email = document.getElementById('form-email').value;
	if (email.length < 3) {
		document.getElementById('form-email').style.backgroundColor = "yellow";
		document.getElementById('checkemail').innerHTML="The email is too short.";
		document.getElementById('checkemail').style.color ='red';
		validEmail=false;

	} else if(email.length > 60 ){

	}else if (email.match(usernameregex)) {
		
			document.getElementById('form-email').style.backgroundColor = "white";
			check_email(email)
		
		
	} else {
		document.getElementById('form-email').style.backgroundColor = "yellow";
		document.getElementById('checkemail').innerHTML="The email is not valid.";
		document.getElementById('checkemail').style.color ='red';
		validEmail=false;
	}
}
//Checks if password meets the required starndards.
function validatePassword() {
	PASSWORD = document.getElementById('form-newpassword').value;
	if (PASSWORD.length < 8) {
		document.getElementById('form-newpassword').style.backgroundColor = "yellow";
		document.getElementById('checkpassword').innerHTML="The password is too short.";
		document.getElementById('checkpassword').style.color ='red';
		validPassword=false;
	}else if(PASSWORD.length > 40 ) {
		document.getElementById('form-newpassword').style.backgroundColor = "yellow";
		document.getElementById('checkpassword').innerHTML="The password is too long.";
		document.getElementById('checkpassword').style.color ='red';
		validPassword=false;

	} else {
		document.getElementById('form-newpassword').style.backgroundColor = "white";
		document.getElementById('checkpassword').innerHTML=" ";
		validPassword=true;
	}
}

//Checks if password is similar to added password
function confirmPassword() {

	var password = document.getElementById('form-confirmpassword').value;
	if (PASSWORD == password) {
		document.getElementById('form-confirmpassword').style.backgroundColor = "white";
		document.getElementById('recheckpassword').innerHTML=" ";
		confirmedPassword=true;
	} else {
		document.getElementById('form-confirmpassword').style.backgroundColor = "yellow";
		document.getElementById('recheckpassword').innerHTML="The passwords dont match";
		document.getElementById('recheckpassword').style.color ='red';
		confirmedPassword=false;

	}
}
//Checks existence of username in database
function check_username(username) {

	var xhr = new XMLHttpRequest();
	xhr.open('GET', 'assets/server/signup.php?username=' + encodeURIComponent(username) + '&name=checkusername', true);
	xhr.send();

	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && xhr.status === 200) {
			
			if(this.responseText.length==3){
				document.getElementById('form-username1').style.backgroundColor="white";
				document.getElementById('checkusername').innerHTML=" ";
				validUsername=true;
			}
			else{
				document.getElementById('form-username1').style.backgroundColor="yellow";
				document.getElementById('checkusername').innerHTML="The username is taken.";
				document.getElementById('checkusername').style.color ='red';
				validUsername=false;
			}
			
		}


	}
}
//Checks if email exists in the database
function check_email(email) {

	var xhr = new XMLHttpRequest();
	xhr.open('GET', 'assets/server/signup.php?email=' + encodeURIComponent(email) + '&name=checkemail', true);
	xhr.send();

	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && xhr.status === 200) {
			
			if(this.responseText.length==3){
				document.getElementById('form-email').style.backgroundColor="white";
				document.getElementById('checkemail').innerHTML=" ";
				validEmail=true;
				
				}
			else{
				document.getElementById('form-email').style.backgroundColor="yellow";
				document.getElementById('checkemail').innerHTML="The email is taken.";
				document.getElementById('checkemail').style.color ='red';
				validEmail=false;
				}
		}


	}
}

//After the form has been filled correctly this function sends it to the database

function submitform() {
	var username = document.getElementById('form-username1').value;
	var email = document.getElementById('form-email').value;
	var password = document.getElementById('form-confirmpassword').value;
	validateUsername()
	validateEmail()
	validatePassword()
	confirmPassword()
	
	
	if(validUsername & validEmail & validPassword & confirmedPassword){
		
		var xhr = new XMLHttpRequest();
		xhr.open( 'POST', 'assets/server/signup.php?username=' + encodeURIComponent(username) +'&email=' + encodeURIComponent(email) + '&password=' + encodeURIComponent(password) +'&name=addtodatabase', true);
		xhr.send();
		xhr.onreadystatechange = function(){
			if ( xhr.readyState === 4 && xhr.status === 200 ) {
				validUsername=false;
				validPassword=false;
				validEmail=false;
				confirmedPassword=false;
				console.log("User added succesfully");
				console.log(this.responseText);
			}
			

		}

	}
	else{
		document.getElementById('submitpassword').style.textAlign="center";
		document.getElementById('submitpassword').innerHTML="Correct all the yellow fields.";
		document.getElementById('submitpassword').style.color ='red';
		
	}

}
