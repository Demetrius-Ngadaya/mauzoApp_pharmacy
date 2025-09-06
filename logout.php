<?php
include("dbcon.php");
include("user_logs.php");

session_start();

// Record logout if user was logged in
if (isset($_SESSION['user_id'])) {
    $userLogger = new UserLogger($con);
    $userLogger->logLogout($_SESSION['user_id']);
}

session_unset();
session_destroy();
header('location:index.php');
exit();
?>