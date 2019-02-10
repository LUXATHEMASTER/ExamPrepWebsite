<?php

    include_once('connection.php');
    //Checking that a username doesnt exxist in a database
    if(isset($_GET['name']) && $_GET['name']==='checkusername'){
        $username1 = $_GET['username'];
        mysqli_select_db($con,"connectify");
        $sql="SELECT * FROM USERS WHERE USERNAME ='$username1'";
        $result = mysqli_query($con,$sql);

        $row = mysqli_fetch_array($result);
        $name = $row['USERNAME'];
        echo $name;

        //$uname_check = mysqli_num_rows($result);
        mysqli_close($con);

        //echo $username1;
        
    }
    //Check that an email doesnt exxist in a database
    else if(isset($_GET['name']) && $_GET['name']==='checkemail'){
        $email = $_GET['email'];
        mysqli_select_db($con,"connectify");
        $sql="SELECT * FROM USERS WHERE EMAIL ='$email'";
        $result = mysqli_query($con,$sql);

        $row = mysqli_fetch_array($result);
        $name = $row['EMAIL'];
        echo $name;

        //$uname_check = mysqli_num_rows($result);
        

        mysqli_close($con);
        
    }
    //Submitiing a users details to the database
    else if(isset($_GET['name']) && $_GET['name']==='addtodatabase'){
        $username=$_GET['username'];
        $email=$_GET['email'];
        $password=md5($_GET['password']);
        
        mysqli_select_db($con,"connectify");

        $sql = "INSERT INTO USERS (USERNAME, EMAIL, PASSWORD)
            VALUES ('$username', '$email', '$password')";
        
        $result = mysqli_query($con,$sql);
        
        echo 'I have added to the database';
        mysqli_close($con);

        // Email an activation link to the user 
        $to = "$email";	 
        $from = "louismurerwa97@gmail.com";
        $subject = 'Connectify Account Activation';
        $message = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Wontah Message</title></head><body'
            . ' style="margin:0px; font-family:Tahoma, Geneva, sans-serif;"><div style="padding:10px;'
            . ' background:orangered; font-size:24px; color:#FFF;"><a href="http://www.wontah.com">'
            . '</a>Wontah Account Activation</div><div style="padding:24px; font-size:17px;">Hello '.$username.',<br />'
            . '<br />Click the link below to activate your account when ready:<br />'
            . 'Click here to activate your account now</a><br /><br />Login after successful activation using your:'
            . '<br />* E-mail Address: <b>'.$email.'</b></div></body></html>';
        $headers = "From: $from\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";


        if(mail($to, $subject, $message, $headers)){
            echo $to;
            echo "Message has been sent successfully";
        }  else {
            echo "an error occured";
        }
       
       


    }
?>