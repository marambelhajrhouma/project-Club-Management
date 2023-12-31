<?php

// Include the EventVoting class
require_once('eventVote.php');

// Get the event ID from the query parameter (replace with your actual method of obtaining it)
$event_id = isset($_GET['event_id']) ? $_GET['event_id'] : null;

// Check if the event ID is provided
if ($event_id === null) {
    echo "<p>Error: Event ID is missing.</p>";
} else {
    // Retrieve members not available for the event with reasons
    $unavailableMembers = EventVoting::getUnavailableMembersByEventId($event_id);

    echo "<h2>Members Not Available for Event #$event_id</h2>";

    if (count($unavailableMembers) > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Member ID</th>
                    <th>Availability</th>
                    <th>Absence Reason</th>
                    <th>Voted At</th>
                </tr>";

        foreach ($unavailableMembers as $member) {
            echo "<tr>
                    <td>{$member->getMemberId()}</td>
                    <td>{$member->getAvailability()}</td>
                    <td>{$member->getAbsenceReason()}</td>
                    <td>{$member->getVotedAt()}</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No members are unavailable for this event.</p>";
    }
}
?>
