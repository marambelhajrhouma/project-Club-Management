<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $memberId = $memberId = $_GET['id'] ?? null;
        $newRole = $_POST['role']?? null;

        include_once('../controller/memberController.php');
        $memberController = new MemberController();

        // Update the role in the database
        $success = $memberController->changeRole($memberId, $newRole);

        if ($success) {
            echo "Role updated successfully!";
            header('Location: logout.php'); 
            exit();
        } else {
            echo "Failed to update role.";
        }

} else {
    echo "Invalid request method.";
}
?>
