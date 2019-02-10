<?php

    include_once('connection.php');
    //Checking that a username doesnt exxist in a database
    if(isset($_GET['name']) && $_GET['name']==='info'){
        $username = $_GET['username'];
        mysqli_select_db($con,"connectify");
        $sql="SELECT * FROM USERS WHERE USERNAME ='$username'";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_array($result);
        
        
        $username = $row['USERNAME'];
        $firstname = $row['FIRSTNAME'];
        $lastname = $row['LASTNAME'];
        $email = $row['EMAIL'];
        $phonenumber = $row['PHONE_NUMBER'];
        $gender = $row['GENDER'];
        $dateofbirth = $row['DATE_OF_BIRTH'];
        $intrest = $row['INTREST'];
        $hometown = $row['HOMETOWN'];
        
    
        echo json_encode(array('username'=>$username, 'firstname'=>$firstname, 'lastname'=>$lastname,'email'=>$email,'phonenumber'=>$phonenumber,'gender'=>$gender,'dateofbirth'=>$dateofbirth,'intrest'=>$intrest,'hometown'=>$hometown));
        mysqli_close($con);
    }
    else {
        echo false;
    }
   
?>