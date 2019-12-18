<?php
//start a session
session_start();

/*this is the default page of the eTutoring system in a large university

*We will actually run a login form here.

*/
 require_once "php/db.php"; //Connecting database
$this_user = $_SESSION['username'];

if(!$_SESSION['loggedin'] && $_SESSION['loggedin'] == false){
    header('location:index.php?error=You must be logged in to access this page.');
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Tutors</title>
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
 <h1>Tutors list</h1>
    <?
    //check for errors and successes
    
    if(isset($_GET['error'])){
        echo $_GET['error'];
    }elseif(isset($_GET['success'])){
    $this_user = $_SESSION['username'];
    echo 'Hi'. ' '. $this_user.'!! ' . $_GET['success'];
    
    }
    
    
 //now that we are logged in, let us use this dashboard for all the user roles
 
 //Get this logged in user
echo '<table>

<tr>
<th>Email</th>
<th>Username</th>

<th>Role</th>
<th>Alloted students</th>
</tr>


';
   $sqluser = "SELECT * FROM users WHERE role = 'tutor'";
$resultuser = $conn->query($sqluser);

if ($resultuser->num_rows > 0) {
    // output data of each row
    while($row = $resultuser->fetch_assoc()){
	$email = $row['email'];
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
	
	echo '
	
	<tr>
	<td>'.$email.'</td>
	<td>'.$username.'</td>
	<td>'.$role.'</td>
		<td>'.$allocated_students.'<a href="tutorDashboard.php?tutor='.$username.'">  View details</a>
		
		
		
		</td>
	  
	</tr>
	
	
	'

	;
	
	
	
    }
    
}else{
    echo '<tr><td>No tutors found.</td></tr>';
}
						
    
    echo '</table>';
    
    
    ?>
    

  
    
    
    
    
    
    
    
  
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
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
   
   
   
   ';
   
   //Get messages for this user
   
   
   echo '<table>
   <h2>Messages</h2>
<tr>
<th>From</th>
<th>To</th>
<th>text</th>
</tr>
';
   $sqlmessages = "SELECT * FROM messages WHERE sender = '$this_user' || recipient='$this_user";
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
   echo '<h2>My blogs</h2>';
   $sqlblogs = "SELECT * FROM blogs WHERE posted_by = '$this_user'";
$resultblogs = $conn->query($sqlblogs);

if ($resultblogs->num_rows > 0) {
    // output data of each row
    while($row = $resulblogs->fetch_assoc()){
					
$heading = $row['heading'];
$details = $row['details'];
$status= $row['status'];
	
	echo 
	
	$heading .'</br>'.$details . '<br><hr>'

	;
   
    }}else{
        echo 'No blogs found.';
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
<th>text</th>
</tr>
';
   $sqlmessages = "SELECT * FROM messages WHERE sender = '$this_user' || recipient='$this_user";
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
        echo 'No messages found.';
    }
    
    echo '</table>';
   //get blogs for this user
   echo '<h2>My blogs</h2>';
   $sqlblogs = "SELECT * FROM blogs WHERE posted_by = '$this_user'";
$resultblogs = $conn->query($sqlblogs);

if ($resultblogs->num_rows > 0) {
    // output data of each row
    while($row = $resulblogs->fetch_assoc()){
					
$heading = $row['heading'];
$details = $row['details'];
$status= $row['status'];
	
	echo 
	
	$heading .'</br>'.$details . '<br><hr>'

	;
   
    }}else{
        echo 'No blogs found.';
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