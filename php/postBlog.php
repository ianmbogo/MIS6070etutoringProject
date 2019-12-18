<?php
//start session
session_start();
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require_once "db.php";
//collect the POST data below
if(isset($_POST['post'])){//first check if the correct button was clicked
$posted_by= $_SESSION['username'];
$topic = $_POST['topic'];
$text = $_POST['text'];

//now we have the variables set from the add user form. Check if we have this in our database.

 $sqluser = "SELECT * FROM users WHERE username = '$posted_by'";
$resultuser = $conn->query($sqluser);

if ($resultuser->num_rows > 0) {
   while($row = $resultuser->fetch_assoc()){
       $recipient_email = $row['email'];
   }
    
  $sql ="INSERT INTO `blogs` (`posted_by`, `subject`, `details`, `status`) VALUES ('$posted_by','$topic','$text', 'Published')";



if(mysqli_query($conn, $sql)){
    
        header('location:../dashboard.php?success=Blog posted successfully.');
    }else{
        header('location:../dashboard.php?error='. mysqli_error($conn)); 
    }
}
    
    


}else{
    header('location:../dashboard.php?error=Form submission problem. Retry again or contact administrator');
}











?>