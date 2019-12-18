<?php

session_start();
//this file destroys the session of a logged in user

// remove all session variables
session_unset();

// destroy the session
session_destroy(); 

if($_SESSION['loggedin'] == false){
    header('location:../index.php');
}else{
    header('location:../dashboard.php');
}


?>