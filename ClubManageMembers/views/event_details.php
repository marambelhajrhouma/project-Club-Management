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

    // Fetch existing vote details (if any) for the logged-in member
    $loggedInMemberId = $_SESSION['member_id']; // Assuming you have a member session
    $existingVote = $eventController->getMemberVote($eventId, $loggedInMemberId);

    // Check if the member has already voted
    $hasVoted = ($existingVote !== false);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <script>
        function toggleAbsenceReason() {
            var availabilitySelect = document.getElementById("availability");
            var absenceReasonLabel = document.getElementById("absenceReasonLabel");
            var absenceReasonInput = document.getElementById("absence_reason");

            if (availabilitySelect.value === "Not Available") {
                absenceReasonLabel.style.display = "block";
                absenceReasonInput.style.display = "block";
                absenceReasonInput.required = true;
            } else {
                absenceReasonLabel.style.display = "none";
                absenceReasonInput.style.display = "none";
                absenceReasonInput.required = false;
            }
        }
    </script>
</head>
<body>
    <h2>Event Details - <?php echo $eventDetails['event_name']; ?></h2>

    <p>Description: <?php echo $eventDetails['event_description']; ?></p>
    <p>Event Date: <?php echo $eventDetails['event_date']; ?></p>

    <?php if ($eventEnded): ?>
        <p>This event has ended. Voting is closed.</p>
    <?php else: ?>
        <form action="submit_vote.php" method="post" onsubmit="toggleAbsenceReason()">
            <input type="hidden" name="event_id" value="<?php echo $eventId; ?>">

            <?php if ($hasVoted): ?>
                <p>You have already voted. You can edit your vote below.</p>
            <?php endif; ?>

            <label for="availability">Vote for Availability:</label>
            <select name="availability" id="availability" onchange="toggleAbsenceReason()" required>
                <option selected disabled>Are you attending or not?</option>
                <option value="available" <?php echo ($hasVoted && $existingVote['availability'] === 'available') ? 'selected' : ''; ?>>Available</option>
                <option value="Not Available" <?php echo ($hasVoted && $existingVote['availability'] === 'Not Available') ? 'selected' : ''; ?>>Not Available</option>
            </select>

            <label for="absence_reason" id="absenceReasonLabel" style="display: none;">Absence Reason:</label>
            <input type="text" name="absence_reason" id="absence_reason" style="display: none;" value="<?php echo ($hasVoted) ? $existingVote['absence_reason'] : ''; ?>">

            <button type="submit"><?php echo ($hasVoted) ? 'Edit Vote' : 'Submit Vote'; ?></button>
        </form>
    <?php endif; ?>

</body>
</html>
