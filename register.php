<?php
session_start();
/*this is the default page of the eTutoring system in a large university

*We will actually run a login form here.

*/
 require_once "php/db.php"; //Connecting database
$this_user = $_SESSION['username'];
if($_SESSION['loggedin'] && $_SESSION['loggedin'] == true){
    header('location:dashboard.php');
}


?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>Register user</title>
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
					    <h2>Register and login to access this system </h2>
						 <?
    //check for errors
    
    if(isset($_GET['error'])){
        echo $_GET['error'];
    }
    
    
    
    
    ?>
  <form action="php/process_register2.php" method="POST">
      <input type ="email" name="email" placeholder="Enter email" required><br>
      <input type ="text" name="username" placeholder="Enter username" required><br>
      
      <input type ="password" name="password" placeholder="Enter password" required><br>
      
      <select name="role" required>
          <option value="" hidden selected>Select a role</option>
         
          <option value="tutor">Tutor</option>
          <option value="student">Student</option>
          
          
          
          
      </select>
      
      
      <br>
     
     
       <input type ="submit" name="add" class="button big alt" style="border:1px solid black;" value="Add user now"><br>
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
  </form>  
					</div>
					<div class="content">
					    <hr>
						<header>
							
						</header>
						<p>
						    <div class="image fit"><img src="images/uni.jpg"></div>
	
  
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
     
						    
						    
						    
						    
						    
						    
						    
						    
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