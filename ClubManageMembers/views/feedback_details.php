<?php
include_once('../controller/EventController.php');
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['member_id'])) {
    // Redirect to the login page
    header('Location: login.php');
    exit();
}
// Check if the event_id is provided
if (isset($_GET['event_id'])) {
    $eventId = $_GET['event_id'];

    // Create an instance of the EventController class
    $eventController = new EventController();

    // Fetch event details
    $eventDetails = $eventController->getEventDetails($eventId);

    // Check if the event has ended
    $eventEnded = $eventController->isEventEnded($eventId);

    // Fetch existing feedback details (if any) for the logged-in member
    $loggedInMemberId = $_SESSION['member_id']; // Assuming you have a member session
    $existingFeedback = $eventController->getMemberFeedback($eventId, $loggedInMemberId);

    // Check if the member has already given feedback
    $hasGivenFeedback = ($existingFeedback !== false);
}

// Display the event details and feedback form
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
</head>
<body>
    <h2>Event Details - <?php echo $eventDetails['event_name']; ?></h2>

    <p>Description: <?php echo $eventDetails['event_description']; ?></p>
    <p>Event Date: <?php echo $eventDetails['event_date']; ?></p>

    <?php if ($eventEnded): ?>
        <p>This event has ended. You can give your feedback below.</p>
        
        <form action="submit_feedback.php" method="post">
            <input type="hidden" name="event_id" value="<?php echo $eventId; ?>">

            <?php if ($hasGivenFeedback): ?>
                <p>You have already given feedback. You can edit your feedback below.</p>
            <?php endif; ?>

            <label for="satisfaction_rating">Satisfaction Rating:</label>
            <select name="satisfaction_rating" id="satisfaction_rating" required>
                <option value="1">1 - Very Dissatisfied</option>
                <option value="2">2 - Dissatisfied</option>
                <option value="3">3 - Neutral</option>
                <option value="4">4 - Satisfied</option>
                <option value="5">5 - Very Satisfied</option>
            </select>

            <label for="feedback_text">Feedback Text:</label>
            <textarea name="feedback_text" id="feedback_text" rows="4" required><?php echo ($hasGivenFeedback) ? $existingFeedback['feedback_text'] : ''; ?></textarea>

            <button type="submit"><?php echo ($hasGivenFeedback) ? 'Edit Feedback' : 'Submit Feedback'; ?></button>
        </form>
    <?php else: ?>
        <p>This event is ongoing or has not yet started. Feedback can be provided only after the event has ended.</p>
    <?php endif; ?>

</body>
</html>
