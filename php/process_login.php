<?php
//start session
session_start();
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require_once "db.php";
//collect the POST data below
if(isset($_POST['login'])){//first check if the correct button was clicked
$username = $_POST['username'];
$pass = MD5($_POST['password']);

//now we have the variables set from the login form. Check if we have this in our database.

 $sqluser = "SELECT * FROM users WHERE username = '$username' && password ='$pass'";
$resultuser = $conn->query($sqluser);

if ($resultuser->num_rows > 0) {
    header('location:../dashboard.php?success=Welcome to our eTutoring system');
    //set a session variable
    $_SESSION['username'] = $username;
    $_SESSION['loggedin']  = true;
						
}else{
header('location:../index.php?error= Username or password is incorrect.');
}

}else{
    header('location:../index.php?error=Form submission problem. Retry again or contact administrator');
}











?>