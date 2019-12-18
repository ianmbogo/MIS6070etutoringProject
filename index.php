<?php
//start a session
session_start();

/*this is the default page of the eTutoring system in a large university

*We will actually run a login form here.

*/
 require_once "php/db.php"; //Connecting database
$this_user = $_SESSION['username'];

if($_SESSION['loggedin'] == true){
    header('location:dashboard.php');
}
?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>eTutoring system</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body>

		<!-- Header -->
			<header id="header" style="background-image:url(assets/css/images/uni_bg.jpg);">
				<div class="inner">
					<div class="content">
						<h2>eTutoring</h2>
						<h2>System</h2>
						<h2>By Ian Mbogo</h2>
					
					<form name="login" action="php/process_login.php" onsubmit="return validateForm()" method="POST">
      <input type ="text" name="username" placeholder="Enter username"><br>
      
      <input type ="password" name="password" placeholder="password" required><br>
       <input type ="submit" name="login" class="button big alt" value="Login"><br>
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
  </form>  
    
				
	
			 
			     <a href="register.php" style="color:#fff;" class=""><span>Create account</span></a><br>
			     
			     <p style="color:#fff;">
			      <?php
    //check for errors
    
    if(isset($_GET['error'])){
        echo $_GET['error'];
    }elseif(isset($_GET['success'])){
   
    echo $_GET['success'];
    
    }
    
    
    ?>
	
	</p>				</div>
				</div>
			</header>
 	
		
<script>
    //below Javascript function to validate the username input field.
    function validateForm() {
  var x = document.forms["login"]["username"].value;
  if (x == "") {
    alert("UserName cannot be empty");
    return false;
  }
} 
    
</script>
	

	</body>
</html>