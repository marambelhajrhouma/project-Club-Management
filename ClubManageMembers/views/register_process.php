<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include necessary files
    include_once('../controller/memberController.php');
    $memberController = new MemberController();

    // Get user input from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate passwords match
    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit();
    }

    // Check if the username is available
    if ($memberController->isUsernameAvailable($username) ) {
        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Create a new member
        $member = $memberController->createMember($username, $password);

        if ($member) {
            echo "Member registration successful. You can now login.";
            header('Location: login.php');
            exit();
        } else {
            echo "Failed to register member.";
        }
    } else {
        echo "Username or email is already taken.";
    }
} else {
    // Invalid request method
    echo "Invalid request method.";
}
?>
