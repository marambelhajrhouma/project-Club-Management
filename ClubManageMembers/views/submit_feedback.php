<?php
include_once('../database/config.php');
include_once('../model/event.php');
include_once('../model/eventEngagement.php');
include_once('../model/eventFeedback.php');
include_once('../controller/EventController.php');

session_start();

// Check if the user is logged in
if (!isset($_SESSION['member_id'])) {
    // Redirect to the login page
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the necessary POST parameters are set
    if (isset($_POST['event_id'], $_POST['satisfaction_rating'], $_POST['feedback_text'])) {
        $eventId = $_POST['event_id'];
        $satisfactionRating = $_POST['satisfaction_rating'];
        $feedbackText = $_POST['feedback_text'];

        // Create an instance of the EventController class
        $eventController = new EventController();

        // Check if the event has ended
        $eventEnded = $eventController->isEventEnded($eventId);

        if ($eventEnded) {
            // Check if the member has already given feedback
            $loggedInMemberId = $_SESSION['member_id'];
            $existingFeedback = $eventController->getMemberFeedback($eventId, $loggedInMemberId);

            if ($existingFeedback) {
                // Member has already given feedback, so edit the existing feedback
                $feedback = new EventFeedback($existingFeedback['event_id'], $loggedInMemberId, $satisfactionRating, $feedbackText);
                $feedback->setFeedbackId($existingFeedback['feedback_id']);

                $result = $eventController->editFeedback($feedback);

                if ($result) {
                    echo "Feedback edited successfully!";
                } else {
                    echo "Failed to edit feedback. Please try again.";
                    // Add error log message
                    error_log("Failed to edit feedback for event $eventId and member $loggedInMemberId");
                }
            } else {
                // Member has not given feedback yet, so submit new feedback
                $feedback = new EventFeedback($eventId, $loggedInMemberId, $satisfactionRating, $feedbackText);

                $result = $eventController->provideEventFeedback($feedback);

                if ($result) {
                    echo "Feedback submitted successfully!";
                } else {
                    echo "Failed to submit feedback. Please try again.";
                    // Add error log message
                    error_log("Failed to submit feedback for event $eventId and member $loggedInMemberId");
                    // Add detailed error message
                    echo '<br>Error details: ' . $eventController->getErrorMessage();
                }
            }
        } else {
            echo "Feedback can only be submitted for ended events.";
        }
    } else {
        echo "Invalid parameters received.";
        // Add error log message
        error_log("Invalid parameters received for feedback submission");
    }
} else {
    echo "Invalid request method.";
    // Add error log message
    error_log("Invalid request method for feedback submission");
}
?>
