<?php
//start session
session_start();
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require_once "db.php";
//collect the POST data below
if(isset($_POST['add'])){//first check if the correct button was clicked
$username = $_POST['username'];
$pass = MD5($_POST['password']);
$role = $_POST['role'];
$email = $_POST['email'];

//now we have the variables set from the add user form. Check if we have this in our database.

 $sqluser = "SELECT * FROM users WHERE username = '$username'";
$resultuser = $conn->query($sqluser);

if ($resultuser->num_rows > 0) {
    header('location:../dashboard.php?error=Username already used by another user');
   
						
}else{
//now we can insert this record in the user db table

$sql ="INSERT INTO `users`(`email`,`username`, `password`, `role`) VALUES ('$email','$username','$pass','$role')";



if(mysqli_query($conn, $sql)){
    header('location:../dashboard.php?success=User added successfully.');
}else{
    header('location:../dashboard.php?error='. mysqli_error($conn)); 
}

}

}else{
    header('location:../index.php?error=Form submission problem. Retry again or contact administrator');
}











?>