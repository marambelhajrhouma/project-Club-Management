<?php
include_once('../controller/MemberProfileController.php');

$profileController = new MemberProfileController();

// Check if the member ID is provided in the URL
$memberId = $_GET['id'] ?? null;

// Fetch member details based on the member ID
// Check if a member with the given ID exists
if ($profileController->hasProfile($memberId)) {
    $profile = $profileController->getMemberProfile($memberId);
    ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Member Details</h2>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td><?php echo "<img src='" . $profile['image_url'] . "' alt='Profile Image'> "?></td>
                </tr>
                <tr>
                    <td><?php echo $profile['full_name']; ?></td>
                </tr>
                <tr>
                    <td><?php echo $profile['about_me']; ?></td>
                </tr>
                <tr>
                    <td><?php echo $profile['interests']; ?></td>
                </tr>
                <tr>
                    <td><?php echo $profile['skills']; ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <?php
} else {
    // profil not found
    echo "Member don't have a profil yet .";
}
?>
