<?php
session_start();
include_once('../controller/EventController.php');

// Check if the user is logged in
if (!isset($_SESSION['member_id'])) {
    // Redirect to the login page
    header('Location: login.php');
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the availability option is set to "Not Available"
    if ($_POST['availability'] === 'Not Available') {
        // Save the absence_reason to be stored in the database
        $absenceReason = $_POST['absence_reason'];
    } else {
        // Set absence_reason to NULL if the availability is "Available"
        $absenceReason = null;
    }
    // Validate form data
    $eventId = $_POST['event_id'] ?? '';
    $availability = $_POST['availability'] ?? '';

    // Create an instance of the EventController class
    $eventController = new EventController();

    // Create an instance of the EventVoting class
    $vote = new EventVoting($eventId,$_SESSION['member_id'],$availability,$absenceReason,"");


    // Check if the user has already voted and decide whether to vote or edit
    $existingVote = $eventController->getMemberVote($eventId, $_SESSION['member_id']);

    if ($existingVote) {
        // User has already voted, edit the existing vote
        $result = $eventController->editVote($vote);
    } else {
        // User has not voted, submit a new vote
        $result = $eventController->voteEvent($vote);
    }

    if ($result) {
        // Voting successful
        header('Location: event_details.php?event_id=' . $eventId);
        exit();
    } else {
        // Voting failed, handle accordingly (e.g., redirect with an error)
        header('Location: event_details.php?event_id=' . $eventId . '&error=1');
        exit();
    }
} else {
    // Redirect to the home page or handle the case where the form is not submitted
    header('Location: index.php');
    exit();
}
?>
