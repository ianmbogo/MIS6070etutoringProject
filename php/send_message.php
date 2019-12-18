<?php
//start session
session_start();
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require_once "db.php";
//collect the POST data below
if(isset($_POST['send'])){//first check if the correct button was clicked
$recipient= $_POST['recipient'];
$from = $_SESSION['username'];
$text = $_POST['text'];

//now we have the variables set from the add user form. Check if we have this in our database.

 $sqluser = "SELECT * FROM users WHERE username = '$recipient'";
$resultuser = $conn->query($sqluser);

if ($resultuser->num_rows > 0) {
   while($row = $resultuser->fetch_assoc()){
       $recipient_email = $row['email'];
   }
    
  $sql ="INSERT INTO `messages` (`sender`,`recipient`,`text`) VALUES ('$from','$recipient','$text')";



if(mysqli_query($conn, $sql)){
    
    //email the recipient
   
    // the email message
$msg = $text;

// send email
mail("$recipient_email","You have a new message",$msg);
    
    //update assigned tutors to students
    
        header('location:../dashboard.php?success=Message sent successfully.');
    }else{
        header('location:../dashboard.php?error='. mysqli_error($conn)); 
    }
}
    
    


}else{
    header('location:../dashboard.php?error=Form submission problem. Retry again or contact administrator');
}











?>