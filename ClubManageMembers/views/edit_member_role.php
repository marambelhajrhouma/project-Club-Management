<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Member Role</title>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Edit Member Role</h2>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $memberId = $_GET['id'];

            include_once('../controller/memberController.php');
            $memberController = new MemberController();

            // Fetch the member by ID
            $member = $memberController->getMemberById($memberId);

            if ($member) {
        ?>
                <form action="edit_member_role_action.php?id=<?php echo $member['member_id']; ?>" method="post" novalidate="novalidate">
                    <label for="role">Select Role:</label>
                    <select name="role" id="role" required="required">
                        <option value="Club Member" <?php echo ($member['role'] == 'Club Member') ? 'selected' : ''; ?>>Club Member</option>
                        <option value="President" <?php echo ($member['role'] == 'President') ? 'selected' : ''; ?>>President</option>
                    </select>
                    <button type="submit">Update Role</button>
                </form>
        <?php
            } else {
                echo "Member not found.";
            }
        } else {
            echo "Invalid request method or Member ID not provided.";
        }
        ?>
    </div>
</body>

</html>
