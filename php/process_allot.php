<?php
//start session
session_start();
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require_once "db.php";
//collect the POST data below
if(isset($_POST['allot'])){//first check if the correct button was clicked
$tutor = $_POST['tutor'];
$students = implode($_POST['students'], ', ');
$allocated = ltrim($students, ',');

//now we have the variables set from the add user form. Check if we have this in our database.

 $sqluser = "SELECT * FROM users WHERE username = '$tutor'";
$resultuser = $conn->query($sqluser);

if ($resultuser->num_rows > 0) {
   while($row = $resultuser->fetch_assoc()){
       $tutors_email = $row['email'];
   }
    
  $sql ="UPDATE `users` SET `allocated_students` = '$allocated' WHERE `users`.`username` = '$tutor'";



if(mysqli_query($conn, $sql)){
    
    //first email the tutor
    //get the email of the tutor
    
    
    
    // the email message
$msg = "The following students have been assigned to you:". $allocated;



// send email
mail("$tutors_email","A new student allocation done",$msg);
    
    //update assigned tutors to students
    foreach($_POST['students'] as $stude) {
   
    $sql2= ("UPDATE users SET `assigned_tutor` = '$tutor' WHERE `users`.`username` = '$stude'");
    if(mysqli_query($conn, $sql2)){
        
        //email the students
         
         
       //get emails of the students
        $sqlusers = "SELECT * FROM users WHERE username = '$stude'";
$resultusers = $conn->query($sqlusers);

if ($resultusers->num_rows > 0) {
   while($row = $resultusers->fetch_assoc()){
      $stude_email = $row['email'];
   }
       
    
       
         
         
    // the email message
$msg1 = "Dear". $stude.'you have been assigned Tutor:'. $tutor;



// send email
mail("$stude_email","Tutor allocation done",$msg1);
        
}        
        header('location:../tutorDashboard.php?tutor='.$tutor.'&success=Students assigned to this tutor successfully');
    }else{
        header('location:../dashboard.php?error='. mysqli_error($conn)); 
    }
}
    
    
    
}else{
    header('location:../dashboard.php?error='. mysqli_error($conn)); 
} 
   
						
}else{
//tutor doesnt exist
 header('location:../dashboard.php?error=Tutor doesnt exist');
   


}

}else{
    header('location:../tutors.php?error=Form submission problem. Retry again or contact administrator');
}











?>