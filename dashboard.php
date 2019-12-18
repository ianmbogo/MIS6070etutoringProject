<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
//start a session
session_start();

/*this is the default page of the eTutoring system in a large university

*We will actually run a login form here.

*/
 require_once "php/db.php"; //Connecting database
$this_user = $_SESSION['username'];


//number of messages
   $sqlmessages = "SELECT * FROM messages WHERE recipient='$this_user' || sender='$this_user'";
$resultmessages = $conn->query($sqlmessages);
$num_messages= $resultmessages->num_rows;

//alloted students

$sqluser = "SELECT * FROM users WHERE username = '$this_user'";
$resultuser = $conn->query($sqluser);

if ($resultuser->num_rows > 0) {
    // output data of each row
    while($row = $resultuser->fetch_assoc()){
					
	$role = $row['role'];
	$username = $row['username'];
	$allocated_students1 = $row['allocated_students'];
	if($allocated_students1 != ''){
  $allocated_students = count(explode(',', $row['allocated_students']));
  $those_alloted = $row['allocated_students'];
	}else{
	    $allocated_students = 0;
	    $those_alloted = 'None';
	}
}}

if(!$_SESSION['loggedin'] && $_SESSION['loggedin'] == false){
    header('location:index.php?error=You must be logged in to access this page.');
    
    
    

}
?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>Dashboard</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body>

		<!-- Header -->
		
			<header id="header" class="preview">
			   
				
			</header>

		<!-- Main -->
			<div id="preview" class="vertical" style="border:2px solid gray; width:70%; margin:auto; border-radius:25px;">
			    <div style="">
			      <span style="font-weight:20px;"><strong>eTutoring System</strong></span>
			    <a href="index.php" class=""><span>Home</span></a>
			     <a href="php/logout.php" class=""><span>Logout</span></a>
			      </div>
				<div class="inner">
				    
					<div class="image fit">
					  <hr>
					   <?php
					   //get all messages in the past 7 days for admin to see
    
   $sqlmessages1 = "SELECT * FROM messages";
$resultmessages1 = $conn->query($sqlmessages1);
$num_messages1= $resultmessages1->num_rows; 
    
    
    //get average messages per tutor
    
    //1. num of tutors
    if($role=='admin'){
        echo ' <h2>Statistics</h2>';
    $sql_tutors = "SELECT * FROM users WHERE role='tutor'";
$result_tutors = $conn->query($sql_tutors);
$num_tutors= $result_tutors->num_rows;

//2. num of tutor messages

$av_sms = $num_messages1/$num_tutors; 

//3. students without personal tutor

 $sql_stude = "SELECT * FROM users WHERE role='student' AND assigned_tutor =''";
$result_stude = $conn->query($sql_stude);
$num_stude= $result_stude->num_rows;


					   echo 'Messages in the last 7 days: '.$num_messages1.'</br>
					   
					   
					    Average messages per tutor:' .$av_sms.'</br>
					    
					    Students without a personal tutor:'.$num_stude.'</br>
					    
					    Students with no interaction for 7 days:'. $num_stude.'</br>
					    Students with no interaction for 28 days:'.$num_stude;
					   
    }
    
    
    ?>
					   
					    <hr>
						<img src="images/uni.jpg">
					</div>
					<div class="content">
					    <hr>
						<header>
							<h2>Dashboard</h2>
						</header>
						<p>
						    
						   <?
    //check for errors and successes
    
    if(isset($_GET['error'])){
        echo $_GET['error'];
    }elseif(isset($_GET['success'])){
   
    echo 'Hi'. ' '. $this_user.'!! ' . $_GET['success']. '</br>';
    
    }
    
    
 //now that we are logged in, let us use this dashboard for all the user roles
 
 //Get this logged in user

   $sqluser = "SELECT * FROM users WHERE username = '$this_user'";
$resultuser = $conn->query($sqluser);

if ($resultuser->num_rows > 0) {
    // output data of each row
    while($row = $resultuser->fetch_assoc()){
					
	$role = $row['role'];
	$username= $row['username'];
	$assigned_tutor = $row['assigned_tutor'];
	$alloted_students = $row['allocated_students'];
						
    }
    if($role == 'admin'){
        //dashboard for admin below
      echo'<ul>
      
      <a href="students.php"><li>Students</li></a>
       <a href="tutors.php"><li>Tutors</li></a>
       <a href="staff.php"><li>Staff</li> </a>
     
      </ul>
      
      
      <a href="addUser.php"><button>Add user</button></a>
      
      '
      ;
        
    }elseif($role == 'tutor'){
        //dashboard for tutor below 
        
        echo 'username: '.$username.'</br>
   Role: '.$role.'</br>
   My alloted students: '.$alloted_students.'</br>
   
   Number of alloted students: '.$allocated_students.'
   
   ';
   
  //Get messages for this user
   
   
   echo '<table>
   <h2>Messages</h2>
  Messages in the past 7 days: '.$num_messages.'<hr>
<tr>
<th>From</th>
<th>To</th>
<th>text  </th>

</tr>
';
$this_user = $_SESSION['username'];
   $sqlmessages = "SELECT * FROM messages WHERE recipient='$this_user' || sender='$this_user'";
$resultmessages = $conn->query($sqlmessages);

if ($resultmessages->num_rows > 0) {
    // output data of each row
    while($row = $resultmessages->fetch_assoc()){
					
$sender = $row['sender'];
$recipient = $row['recipient'];
$text= $row['text'];
	
	echo '
	
	<tr>
	
	<td>'.$sender.'</td>

	<td>'.$recipient.'</td>
	
	<td>'.$text.'<a href="sendMessage.php?recipient='.$sender.'"><button>Message student</button></a></td>
	</tr>

	
	';

	
   
    }}else{
        echo '<tr><td>No messages found.</td></tr>';
    }
    
    echo '</table>';
   //get blogs for this user
   echo '<h2>My blogs</h2><hr>
   <a href="postBlog.php"><button>Post a blog</button></a></br>';
   $this_user = $_SESSION['username'];
   $sqlblogs = "SELECT * FROM blogs WHERE posted_by = '$this_user'";
$resultblogs = $conn->query($sqlblogs);

if ($resultblogs->num_rows > 0) {
    // output data of each row
    while($row = $resultblogs->fetch_assoc()){
					
$heading = $row['subject'];
$details = $row['details'];
$status= $row['status'];
	
	echo 
	
	$heading .'</br>'.$details . '<br><hr>'

	;
   
    }}else{
        echo '<tr><td>No blogs found.</td></tr>';
    }
   
        
    }elseif($role == 'student'){
      //dashboard for student below   
   
   echo 'username: '.$username.'</br>
   Role: '.$role.'</br>
   My tutor: '.$assigned_tutor.'</br>
   
   
   
   ';
   
   //Get messages for this user
   
   
   echo '<table>
   <h2>Messages</h2>
  
<tr>
<th>From</th>
<th>To</th>
<th>text  <a href="sendMessage.php?recipient='.$assigned_tutor.'"><button>Message Tutor</button></a></th>

</tr>
';
$this_user = $_SESSION['username'];
   $sqlmessages = "SELECT * FROM messages WHERE recipient='$this_user' || sender='$this_user'";
$resultmessages = $conn->query($sqlmessages);

if ($resultmessages->num_rows > 0) {
    // output data of each row
    while($row = $resultmessages->fetch_assoc()){
					
$sender = $row['sender'];
$recipient = $row['recipient'];
$text= $row['text'];
	
	echo '
	
	<tr>
	
	<td>'.$sender.'</td>

	<td>'.$recipient.'</td>
	
	<td>'.$text.'</td>
	</tr>

	
	';

	
   
    }}else{
        echo '<tr><td>No messages found.</td></tr>';
    }
    
    echo '</table>';
   //get blogs for this user
   echo '<h2>My blogs</h2><hr>
   <a href="postBlog.php"><button>Post a blog</button></a></br>';
   $this_user = $_SESSION['username'];
   $sqlblogs = "SELECT * FROM blogs WHERE posted_by = '$this_user'";
$resultblogs = $conn->query($sqlblogs);

if ($resultblogs->num_rows > 0) {
    // output data of each row
    while($row = $resultblogs->fetch_assoc()){
					
$heading = $row['subject'];
$details = $row['details'];
$status= $row['status'];
	
	echo 
	
	$heading .'</br>'.$details . '<br><hr>'

	;
   
    }}else{
        echo '<tr><td>No blogs found.</td></tr>';
    }
   
   
     
      
      
    }else{
        echo 'No dashboard to display as your Role is not well characterised.';
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}else{
    echo 'No such a user.';
}
    
    
    
    
    ?>
  
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
     
						    
						    
						    
						    
						    
						    
						    
						    
						</p>
					</div>
				</div>
				
			</div>

		<!-- Footer -->
			<footer id="footer">
			
					<div class="copyright">
					
						&copy; Ian Mbogo.
					</div>
				
			</footer>

	

	</body>
</html>