var validUsername = false;
var validPassword = false;
console.log(window.sessionStorage.getItem('userInfo'));
console.log("Loading page");
if(window.sessionStorage.getItem('userInfo')){
	console.log("I am here");
	window.location = 'profile.html'; 
  }
function validateUsername() {
	var usernameregex = /^[a-z0-9]+$/;
	var username = document.getElementById('form-username').value;
	if (username.match(usernameregex)) {
		
		document.getElementById('form-username').style.backgroundColor="white";
		check_username(username)

	} else {
		document.getElementById('checkusername').innerHTML="The username doesnt exist.";
		document.getElementById('checkusername').style.color ='red';
		validUsername=false;
	}
}

function validatePassword(){
	
	var PASSWORD=document.getElementById('form-password').value;
	if(PASSWORD.length>40||PASSWORD.length<8){
		document.getElementById('form-password').style.backgroundColor = "yellow";

	}
	else{
		document.getElementById('form-password').style.backgroundColor = "white";
		}
}


function check_username(username) {

	var xhr = new XMLHttpRequest();
	xhr.open('GET', 'assets/server/signup.php?username=' + encodeURIComponent(username) + '&name=checkusername', true);
	xhr.send();

	xhr.onreadystatechange = function () {

		if (xhr.readyState === 4 && xhr.status === 200) {
			
			if(this.responseText.length==3){
				document.getElementById('form-username').style.backgroundColor="yellow";
				document.getElementById('checkusername').style.color ='red';
				document.getElementById('checkusername').innerHTML="The username doesnt exist.";
				validUsername=false;
			}
			else{
				document.getElementById('form-username').style.backgroundColor="white";
				document.getElementById('form-username').innerHTML=this.responseText;
				document.getElementById('checkusername').innerHTML =' ';
				validUsername=true;
			}
			
		}


	}
}
function signIn(){
	var username = document.getElementById('form-username').value;
	var password = document.getElementById('form-password').value;
	
	var xhr = new XMLHttpRequest();
	xhr.open('GET','assets/server/signin.php?username=' + encodeURIComponent(username) +'&password=' + encodeURIComponent(password) + '&name=checkpassword', true);
	xhr.send();

	xhr.onreadystatechange = function () {
		//console.log(this.responseText)

		if (xhr.readyState === 4 && xhr.status === 200) {
			
			if(this.responseText!=" "){
				window.sessionStorage.setItem("userInfo", JSON.stringify(xhr.responseText)); 
				window.location='profile.html' ;

				console.log(this.responseText);
				//window.localStorage.push("userInfo", JSON.stringify(xhr.responseText)); 
				// document.getElementById('form-username').style.backgroundColor="white";
				// document.getElementById('form-username').innerHTML=this.responseText;
				// document.getElementById('submitdetails').style.color ='green';
				// document.getElementById('submitdetails').innerHTML="Success you have logged in";
				// console.log("Success you have logged in")
				// validUsername=false;
			}
			// else if(this.responseText==false){
			// 	document.getElementById('form-username').style.backgroundColor="red";
			// 	document.getElementById('form-password').style.backgroundColor="red";
			// 	document.getElementById('submitdetails').style.color ='red';
				
			// 	document.getElementById('submitdetails').innerHTML ='The username and password are wrong';
			// 	validUsername=true;
			// }
			
		}


	}
}
