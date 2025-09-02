<?php
$host ="localhost";
$user ="root";
$password= "";
$dbname = "pptimber_mauzo";
$con =mysqli_connect($host,$user,$password,$dbname);
if(!$con){
	echo mysqli_connect_error($con);
}
// Initialize the last_activity session variable if not already set
if(!isset($_SESSION['last_activity'])) {
    $_SESSION['last_activity'] = time();
}

?> 