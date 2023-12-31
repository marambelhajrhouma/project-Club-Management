<?php
session_start();
include_once('../controller/MemberProfileController.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $memberId = $_SESSION['member_id'];
    $fullName = $_POST['fullName'];
    $aboutMe = $_POST['aboutMe'];
    $interests = $_POST['interests'];
    $skills = $_POST['skills'];

    // Handle image upload
    $targetDir = '../images/MemberProfilePhotos/';
    $targetFileImage = $targetDir . basename($_FILES['image']['name']);

    try {
        // Check if the target directory exists, if not create it
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFileImage)) {
            echo "The file " . basename($_FILES['image']['name']) . " has been uploaded for the member profile.";

            $profileController = new MemberProfileController();
            $profile = $profileController->createMemberProfile($memberId, $fullName, $targetFileImage, $aboutMe, $interests, $skills);

            if ($profile) {
                echo "Member profile created/updated successfully!";
                header('Location: profile_member.php');
                exit();
            } else {
                throw new Exception("Failed to create/update member profile.");
            }
        } else {
            throw new Exception("Error: There was an error uploading your member profile photo file.");
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>
