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

// NEW: Check if user has access to all stores and store it in session
include('dbcon.php');
if (isset($_SESSION['user_session']) && isset($con)) {
    $username = $_SESSION['user_session'];
    $user_access_query = mysqli_query($con, "SELECT can_access_all_stores FROM users WHERE user_name = '$username'");
    
    if ($user_access_query && mysqli_num_rows($user_access_query) > 0) {
        $user_access_data = mysqli_fetch_assoc($user_access_query);
        $_SESSION['can_access_all_stores'] = $user_access_data['can_access_all_stores'];
    } else {
        $_SESSION['can_access_all_stores'] = 0;
    }
} else {
    $_SESSION['can_access_all_stores'] = 0;
}
?>