<?php
$servername = "localhost";
$username = 'raiahos1_etutori'; //database username with all previledges
$password = 'Etutoring$$12'; //password for the above user
$database = 'raiahos1_etutoring';// database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 