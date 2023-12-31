<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Profile</title>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Member Profile</h2>
        <?php
        session_start();
            include_once('../controller/MemberProfileController.php');

            // Create an instance of the MemberProfileController class
            $profileController = new MemberProfileController();

            // The rest of your code remains unchanged
            $memberId = $_SESSION['member_id'];

            if ($profileController->hasProfile($memberId)) {
                // Member has a profile, display the information
                $profile = $profileController->getMemberProfile($memberId);
                // Display the profile information in a form or any other way you prefer
                echo "Full Name: " . $profile['full_name'] . "<br>";

                // Display the image using the <img> tag
                echo "Profile Image: <img src='" . $profile['image_url'] . "' alt='Profile Image'><br>";

                echo "About Me: " . $profile['about_me'] . "<br>";
                echo "Interests: " . $profile['interests'] . "<br>";
                echo "skills: " . $profile['skills'] . "<br>";
            } else {
        ?>
        <form action="profile_member_action.php" method="post" enctype="multipart/form-data">
            
            <label for="fullName">Full Name:</label>
            <input type="text" name="fullName" id="fullName" required>
           
            <label for="image">Profile Image:</label>
            <input type="file" name="image" id="image" accept="image/*" required>
           
            <label for="aboutMe">About Me:</label>
            <textarea name="aboutMe" id="aboutMe" rows="4"></textarea>

            <label for="interests">Interests:</label>
            <textarea name="interests" id="interests" rows="4"></textarea>

            <label for="skills">Skills:</label>
            <textarea name="skills" id="skills" rows="4"></textarea>

            <button type="submit">Submit</button>
        </form>
        <?php
        };
        ?>
    </div>
</body>

</html>
