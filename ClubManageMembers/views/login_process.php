<?php
// login_process.php
include_once('../controller/memberController.php');
$memberController = new MemberController();

// Validate login credentials
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Check if both username and password are provided
if (empty($username) || empty($password)) {
    header('Location: login.php?error=2'); // Redirect to login page with an error
    exit();
}

// Attempt to login
$member = $memberController->login($username, $password);

if ($member) {
    // Start the session and store user information
    session_start();
    $_SESSION['member_id'] = $member['member_id'];
    $_SESSION['role'] = $member['role'];
        // Redirect to a protected page (e.g., dashboard.php)
    if($_SESSION['role'] === 'Club Member'){
        header('Location: index_member.php');
        exit();
    }else{
        header('Location: dashboard.php');
        exit();
    }



} else {
    header('Location: login.php?error=1'); // Redirect to login page with an error
    exit();
}
?>
