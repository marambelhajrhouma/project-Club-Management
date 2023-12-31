<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $memberId = $_GET['id'];

        include_once('../controller/memberController.php');
        $memberController = new MemberController();

        $deleted = $memberController->deleteMember($memberId);

        if ($deleted) {
            header("Location: list_members.php");
            exit();
        } else {
            echo "Error deleting the member.";
        }
    } else {
        echo "Member ID not provided.";
    }
} else {
    echo "Invalid request method.";
}
?>