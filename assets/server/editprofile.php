<?php

    include_once('connection.php');
    //Checking that a username doesnt exxist in a database
    if(isset($_GET['name']) && $_GET['name']==='checkuserinfo'){
        $username1 = $_GET['username'];
        mysqli_select_db($con,"connectify");
        $sql="SELECT * FROM USERS WHERE USERNAME ='$username1'";
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
    include_once('connection.php');

    if(isset($_GET['name']) && $_GET['name']==='addtodatabase'){

        $username = $_GET['username'];
        $firstname = $_GET['firstname'];
        $lastname = $_GET['lastname'];
        $phonenumber = $_GET['phonenumber'];
        $gender = $_GET['gender'];
        $dateofbirth = $_GET['dateofbirth'];
        $intrest = $_GET['intrest'];
        $hometown = $_GET['hometown'];
       
        mysqli_select_db($con,"connectify");
        // $sql = "INSERT INTO USERS (FIRSTNAME,LASTNAME,PHONE_NUMBER,GENDER,DATE_OF_BIRTH,INTREST,HOMETOWN)
        //     VALUES ('$firstname', '$lastname','$phonenumber','$gender','$dateofbirth','$intrest','$hometown') WHERE USERNAME='$username'";

        $sql= "UPDATE `USERS` 
            SET FIRSTNAME ='$firstname',`LASTNAME`='$lastname',
            `PHONE_NUMBER`='$phonenumber',`GENDER`='$gender',
            `DATE_OF_BIRTH`='$dateofbirth',`INTREST`='$intrest',`HOMETOWN`='$hometown' WHERE USERNAME='$username'";


        $result = mysqli_query($con,$sql);
        echo'succes';
        mysqli_close($con);

        
    }
   
?>