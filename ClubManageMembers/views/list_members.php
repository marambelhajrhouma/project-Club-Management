<?php
include_once('../controller/memberController.php');

$memberController = new MemberController();

// Fetch all members from the database
$members = $memberController->listMembers();
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Members List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Username</th>
                <th scope="col">Join Date</th>
                <th scope="col">Role</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($members as $member) {
                if($member['role'] === 'Club Member'){ ?>
                <tr>
                    <td><?php echo $member['username']; ?></td>
                    <td><?php echo $member['join_date']; ?></td>
                    <td><?php echo $member['role']; ?></td>
                    <td>
                        <a href="view_member.php?id=<?php echo $member['member_id']; ?>" class="btn btn-sm btn-primary">View</a>
                        <a href="edit_member_role.php?id=<?php echo $member['member_id']; ?>" class="btn btn-sm btn-warning">Edit Role</a>
                        <a href="#" class="btn btn-sm btn-danger" onclick="deleteMember(<?php echo $member['member_id']; ?>)">Delete</a>
                    </td>
                    <script>
                        function deleteMember(memberId) {
                            if (confirm('Are you sure you want to delete this member?')) {
                                window.location.href = 'delete_member.php?id=' + memberId;
                            }
                        }
                    </script>
                </tr>
            <?php }} ?>
        </tbody>
    </table>
</div>
