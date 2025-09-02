<?php
session_start();

// Check if the user is already logged in
if(!isset($_SESSION['user_session'])) {
    header("Location: index.php"); // Redirect to the login page if not logged in
    exit();
}

// Initialize the last_activity session variable if not already set
if(!isset($_SESSION['last_activity'])) {
    $_SESSION['last_activity'] = time();
}

// Check if the user's last activity time is older than one minute
if(time() - $_SESSION['last_activity'] > 600) {
    // Destroy the session
    session_unset();
    session_destroy();
    header("Location: index.php"); // Redirect to the login page
    exit();
}

// Update the user's last activity time
$_SESSION['last_activity'] = time();

$mtumiaji = $_SESSION['user_session'];
$store_id = $_SESSION['store_id'];

?>