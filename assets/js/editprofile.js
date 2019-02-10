var PASSWORD;
var validUsername=false;
var validEmail=false;
var validPassword=false;
var confirmedPassword=false;
//This function takes the profile values in the database and autofills them into the forms.
if(window.sessionStorage.getItem('userInfo')){
    var myObject = JSON.parse(sessionStorage.getItem('userInfo'));


}else{
    window.location = 'signin.html';
}
function fillInfo(){

    console.log(sessionStorage.getItem('userInfo'));
    var myObject = JSON.parse(sessionStorage.getItem('userInfo'));
    var username =JSON.parse(myObject).username;
    console.log(username);
    var xhr = new XMLHttpRequest();
  
	xhr.open('GET', 'assets/server/editprofile.php?username=' + encodeURIComponent(username) + '&name=checkuserinfo', true);
	xhr.send();
	xhr.onreadystatechange = function () {
	if (xhr.readyState === 4 && xhr.status === 200) {

        var user =JSON.parse(this.responseText);
        fillboxes(user)
       

        console.log(user);

			
	 	}


    }
}

function fillboxes(user){

    if(user.firstname!=null){
        document.getElementById('form-first-name').value=user.firstname;
    }
    if(user.lastname!=null){
        document.getElementById('form-last-name').value=user.lastname;
    }
    if(user.phonename!=null){
        document.getElementById('form-phone-number').value=user.phonenumber;
    }
    if(user.gender!=null){
        document.getElementById('form-gender').value=user.gender;
    }
    if(user.dateofbirth!=null){
        document.getElementById('form-date-of-birth').value=user.dateofbirth;
    }
    if(user.hometown!=null){
        document.getElementById('form-home-town').value=user.hometown;
    }
    if(user.intrest!=null){
        document.getElementById('form-intrest').value=user.intrest;
    }
    
}


//After the form has been filled correctly this function sends it to the database

function submitdetails() {

    
    var myObject = JSON.parse(sessionStorage.getItem('userInfo'));
    var username =JSON.parse(myObject).username;
   
	var firstname = document.getElementById('form-first-name').value;
	var lastname = document.getElementById('form-last-name').value;
    var phonenumber = document.getElementById('form-phone-number').value;
    var gender = document.getElementById('form-gender').value;
	var dateofbirth = document.getElementById('form-date-of-birth').value;
    var hometown = document.getElementById('form-home-town').value;
    var intrest = document.getElementById('form-intrest').value;
		
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'assets/server/editprofile.php?username=' + encodeURIComponent(username)+ '&firstname=' + encodeURIComponent(firstname) +'&lastname=' + encodeURIComponent(lastname) +'&phonenumber=' + encodeURIComponent(phonenumber) + '&gender=' + encodeURIComponent(gender)  + '&dateofbirth=' + encodeURIComponent(dateofbirth) + '&hometown=' + encodeURIComponent(hometown) + '&intrest=' + encodeURIComponent(intrest) + '&name=addtodatabase', true);
	xhr.send();
	xhr.onreadystatechange = function(){
       
        
			if ( xhr.readyState === 4 && xhr.status === 200 ) {
				validUsername=false;
				validPassword=false;
				validEmail=false;
				confirmedPassword=false;
				
				console.log(this.responseText);
			}
            window.location='profile.html'


	}

}


