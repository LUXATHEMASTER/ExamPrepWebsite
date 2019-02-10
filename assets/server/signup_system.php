<?php
include_once("php_includes/check_login_status.php");
// If user is logged in, header them away
//if(isset($_SESSION["username"])){
//header("location: message.php?msg=NO to that weenis");
//    exit();
//}
?><?php
// Ajax calls this NAME CHECK code to execute
if(isset($_POST["usernamecheck"])){
include_once("php_includes/db_conx.php");
$username = preg_replace('#[^a-z0-9_]#i', '', $_POST['usernamecheck']);
$sql = "SELECT id FROM users WHERE username='$username' LIMIT 1";
    $query = mysqli_query($db_conx, $sql) or die(mysqli_error($db_conx)); 
    $uname_check = mysqli_num_rows($query);
    if (strlen($username) < 3 || strlen($username) > 16) {
   echo '<strong style="color:#F00;">&times; 3 - 16 characters please</strong>';
   exit();
    }
if (is_numeric($username[0])) {
   echo '<strong style="color:#F00;">&times; Usernames must begin with a letter</strong>';
   exit();
    }
    if ($uname_check < 1) {
   echo '<strong style="color:#009900;">&#x2713; ' . $username . ' is OK</strong>';
   exit();
    } else {
   echo '<strong style="color:#F00;">&times; ' . $username . ' is taken</strong>';
   exit();
    }
}
?><?php
// Ajax calls this NAME CHECK code to execute
if(isset($_POST["emailcheck"])){
include_once("php_includes/db_conx.php");
$email = mysqli_real_escape_string($db_conx, $_POST['emailcheck']);
   if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
$sql = "SELECT id FROM users WHERE email='$email' LIMIT 1";
    $query = mysqli_query($db_conx, $sql) or emaildie(mysqli_error($db_conx)); 
    $email_check = mysqli_num_rows($query);
    if ($email_check < 1) {
   echo '<strong style="color:#009900;">&#x2713;</strong>';
   exit();
    }
  else {
   echo '<strong style="color:#F00;">&times; This email is already on wontah</strong>';
   exit();
    }
}else{
    echo '<strong style="color:#F00;">&times; Invalid email</strong>';
    exit();
}
}
?><?php
// Ajax calls this REGISTRATION code to execute
if(isset($_POST["u"])){
// CONNECT TO THE DATABASE
include_once("php_includes/db_conx.php");
// GATHER THE POSTED DATA INTO LOCAL VARIABLES
$u = preg_replace('#[^a-z0-9_]#i', '', $_POST['u']);
$f = preg_replace('#[^a-z0-9- ]#i', '', $_POST['f']);
$f = str_replace(" ", "_", $f);
$l = preg_replace('#[^a-z0-9- ]#i', '', $_POST['l']);
$l = str_replace(" ", "_", $l);
$e = mysqli_real_escape_string($db_conx, $_POST['e']);
$p = $_POST['p'];
$g = preg_replace('#[^a-z]#', '', $_POST['g']);
// GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
// DUPLICATE DATA CHECKS FOR USERNAME AND EMAIL
if(filter_var($e, FILTER_VALIDATE_EMAIL)) {     
$sql = "SELECT id FROM users WHERE username='$u' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
$u_check = mysqli_num_rows($query);
// -------------------------------------------
$sql = "SELECT id FROM users WHERE email='$e' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
$e_check = mysqli_num_rows($query);
// FORM DATA ERROR HANDLING
if($u == "" || $f == ""|| $l == ""|| $e == "" || $p == "" || $g == ""){
  header("location: message.php?msg=The form submission is missing values.");
        exit();
} else if ($u_check > 0){ 
        header("location: message.php?msg=The username you entered is alreay taken");
        exit();
} else if ($e_check > 0){ 
        header("location: message.php?msg=That email address is already in use in the system");
        exit();
} else if (strlen($u) < 3 || strlen($u) > 16) {
        header("location: message.php?msg=Username must be between 3 and 16 characters");
        exit(); 
    } else if (is_numeric($u[0])) {
        header("location: message.php?msg=Username cannot begin with a number");
        exit();
    } else {
// END FORM DATA ERROR HANDLING
   // Begin Insertion of data into the database
// Hash the password and apply your own mysterious unique salt
//$cryptpass = crypt($p);
//include_once ("php_includes/randStrGen.php");
//$p_hash = randStrGen(20)."$cryptpass".randStrGen(20);
$p_hash = md5($p);
// Add user info into the database table for the main site table
$sql = "INSERT INTO users (username, firstname, lastname, email, password, gender, ip, signup, lastlogin, notescheck, avatar)       
       VALUES('$u','$f','$l','$e','$p_hash','$g','$ip',now(),now(),now(),'avatardefault.jpg')";
$query = mysqli_query($db_conx, $sql); 
$uid = mysqli_insert_id($db_conx);
// Establish their row in the useroptions table
$sql = "INSERT INTO useroptions (id, username, background) VALUES ('$uid','$u','original')";
$query = mysqli_query($db_conx, $sql);
// Create directory(folder) to hold each user's files(pics, MP3s, etc.)
if (!file_exists("user/$u")) {
mkdir("user/$u", 0755); 
}
$explode  = "$e";
$mail = explode("@", $explode);
//COPY AVATAR
$avatar = "images/avatardefault.jpg";
$avatar2 = "user/$u/avatardefault.jpg";
if(!copy($avatar, $avatar2)){
    echo "failed to create avatar";
}
// Email the user their activation link
$to = "$e";	 
$from = "auto_responder@wontah.com";
$subject = 'Wontah Account Activation';
$message = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Wontah Message</title></head><body'
        . ' style="margin:0px; font-family:Tahoma, Geneva, sans-serif;"><div style="padding:10px;'
        . ' background:orangered; font-size:24px; color:#FFF;"><a href="http://www.wontah.com">'
        . '</a>Wontah Account Activation</div><div style="padding:24px; font-size:17px;">Hello '.$u.',<br />'
        . '<br />Click the link below to activate your account when ready:<br />'
        . '<br /><a href="http://www.wontah.com/activation.php?id='.$uid.'&u='.$u.'&f='.$f.'&l='.$l.'&e='.$e.'&p='.$p_hash.'">'
        . 'Click here to activate your account now</a><br /><br />Login after successful activation using your:'
        . '<br />* E-mail Address: <b>'.$e.'</b></div></body></html>';
$headers = "From: $from\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
        
if(mail($to, $subject, $message, $headers)){
    echo "Message has been sent successfully";
}  else {
    echo "an error occured";
}


echo "signup_success";
exit();
}
exit();
}else{
header("location: message.php?msg=Invalid email");
    exit();
}
}
?>