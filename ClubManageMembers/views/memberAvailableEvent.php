<?php

// Include the EventVoting class
require_once('eventVote.php');

// Get the event ID from the query parameter (replace with your actual method of obtaining it)
$event_id = isset($_GET['event_id']) ? $_GET['event_id'] : null;

// Check if the event ID is provided
if ($event_id === null) {
    echo "<p>Error: Event ID is missing.</p>";
} else {
    // Retrieve available members for the event
    $availableMembers = EventVoting::getAvailableMembersByEventId($event_id);

    echo "<h2>Available Members for Event #$event_id</h2>";

    if (count($availableMembers) > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Member ID</th>
                    <th>Availability</th>
                    <th>Voted At</th>
                </tr>";

        foreach ($availableMembers as $member) {
            echo "<tr>
                    <td>{$member->getMemberId()}</td>
                    <td>{$member->getAvailability()}</td>
                    <td>{$member->getVotedAt()}</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No available members for this event.</p>";
    }
}

?>
