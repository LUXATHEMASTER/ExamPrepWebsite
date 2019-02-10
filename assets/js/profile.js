var username;
if(window.sessionStorage.getItem('userInfo')){
    var myObject = JSON.parse(sessionStorage.getItem('userInfo'));
    username =JSON.parse(myObject).username;
    console.log(username);

}else{
    window.location = 'signin.html';
}

window.onload=function(){
    
    console.log('sending');
	var xhr = new XMLHttpRequest();
	xhr.open('GET', 'assets/server/profile.php?username=' + encodeURIComponent(username) + '&name=info', true);
	xhr.send();
	xhr.onreadystatechange = function(){
       
			if ( xhr.readyState === 4 && xhr.status === 200 ) {
				var user =JSON.parse(this.responseText); 
                console.log(this.responseText);
                displayinfo(user)
			}
            //window.location='profile.html'


	}

}
function displayinfo(user){
    

    document.getElementById('userInfo').innerHTML = '<ul id="info"> </ul>';

    if(user.username!=null){
        var list = document.createElement("li");
        var text = document.createTextNode('Username:'+ user.username);
        console.log(user.username);
        list.appendChild(text);
        document.getElementById("info").appendChild(list);
    }

    if(user.firstname!=null){
        var list = document.createElement("li");
        var text = document.createTextNode('Firstname:'+user.firstname);
        console.log(user.firstname);
        list.appendChild(text);
        document.getElementById("info").appendChild(list);
    }

    if(user.lastname!=null){
        var list = document.createElement("li");
        var text = document.createTextNode('Lastname:'+user.lastname);
        list.appendChild(text);
        document.getElementById("info").appendChild(list);
        
    }
    if(user.phonenumber!=null){
        var list = document.createElement("li");
        var text = document.createTextNode('Phonenumber:'+user.phonenumber);
        list.appendChild(text);
        document.getElementById("info").appendChild(list);
        
    }
    if(user.gender!=null){
        var list = document.createElement("li");
        var text = document.createTextNode('Gender:'+user.gender);
        list.appendChild(text);
        document.getElementById("info").appendChild(list);
        
    }
    if(user.dateofbirth!=null){
        var list = document.createElement("li");
        var text = document.createTextNode('DOB:'+user.dateofbirth);
        
        list.appendChild(text);
        document.getElementById("info").appendChild(list);
        
    }
    if(user.hometown!=null){
        var list = document.createElement("li");
        var text = document.createTextNode('Hometown:'+user.hometown);
        console.log(user.username);
        list.appendChild(text);
        document.getElementById("info").appendChild(list);
        
    }
    if(user.intrest!=null){
        var list = document.createElement("li");
        var text = document.createTextNode('Intrest:'+user.intrest);
        list.appendChild(text);
        document.getElementById("info").appendChild(list);
        
    }
    
}


