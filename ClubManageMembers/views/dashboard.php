<?php
// dashboard.php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['member_id'])) {
    header('Location: login.html');
    exit();
}

// Display user information
echo '<h2>Welcome to the Dashboard</h2>';
echo '<p>Member ID: ' . $_SESSION['member_id'] . '</p>';
echo '<p>Role: ' . $_SESSION['role'] . '</p>';
echo '<p><a href="list_members.php">members list</a></p>';
echo '<p><a href="logout.php">Logout</a></p>';

?>
