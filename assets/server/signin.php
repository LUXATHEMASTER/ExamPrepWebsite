<?php
    session_start();
    include_once('connection.php');
    // GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
    $username1 = mysqli_real_escape_string($con, $_GET['username']);
    //$password = md5($_GET['password']);
    $password = $_GET['password'];
    // GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
    //Connect to the database
    mysqli_select_db($con,"connectify");

    if($username1=="" || $password=""){
        echo 'Fill all the form data';
        exit();
    }
    else{
        
        include_once('connection.php');
        mysqli_select_db($con,"connectify");
        $sql="SELECT * FROM USERS WHERE USERNAME ='$username1'LIMIT 1";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_array($result);
        $name = $row['USERNAME'];
        
        
        if($row<1){
            echo 'Wrong password or username';
            exit();
        }
        $password = $_GET['password'];
        $databasepassword = $row['PASSWORD'];
        //echo $databasepassword;
        //echo $password;
        //echo' ';

       

        if($password!=$databasepassword){
            echo 'Incorrect Password';
            exit();
        }
        else{
            // CREATE THEIR SESSIONS AND COOKIES
            $_SESSION['userid'] = $row['ID'];
            $_SESSION['username'] = $row['USERNAME'];
            $_SESSION['password'] = $row['PASSWORD'];
            setcookie("id", $row['ID'], strtotime( '+30 days' ), "/", "", "", TRUE);
            setcookie("user", $row['USERNAME'], strtotime( '+30 days' ), "/", "", "", TRUE);
            setcookie("pass", $row['PASSWORD'], strtotime( '+30 days' ), "/", "", "", TRUE); 
            // UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
           // $sql = "UPDATE users SET IP='$ip', LAST_LOGIN=now() WHERE username='$db_username' LIMIT 1";
            //$query = mysqli_query($con, $sql);
            
            //echo json_encode(array('userid'=>$_SESSION['userid'],'username'=>$_['username']);
            

            echo json_encode(array('userid'=>$_SESSION['userid'], 'username' => $_SESSION['username']));
            // echo 'user.php?u='.$db_username;
            exit();
            }

            //$uname_check = mysqli_num_rows($result);
            mysqli_close($con);

            //echo $username1;

    }
?>