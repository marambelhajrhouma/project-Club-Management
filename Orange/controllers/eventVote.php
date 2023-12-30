<?php

class EventVoting {
    private $event_id, $member_id, $availability, $absence_reason, $voted_at;

    // Keep track of total votes for the event
    private static $totalVotes = 0;

    public function __construct($event_id, $member_id, $availability, $absence_reason ="", $voted_at) {
        $this->event_id = $event_id;
        $this->member_id = $member_id;
        $this->availability = $availability;
        $this->absence_reason = $absence_reason;
        $this->voted_at = $voted_at;

        // Increment total votes count
        self::$totalVotes++;
    }

    public function getEventId() { return $this->event_id; }
    public function getMemberId() { return $this->member_id; }
    public function getAvailability() { return $this->availability; }
    public function getAbsenceReason() { return $this->absence_reason; }
    public function getVotedAt() { return $this->voted_at; }

    public function setEventId($event_id) { $this->event_id = $event_id; }
    public function setMemberId($member_id) { $this->member_id = $member_id; }
    public function setAvailability($availability) { $this->availability = $availability; }
    public function setAbsenceReason($absence_reason) { $this->absence_reason = $absence_reason; }
    public function setVotedAt($voted_at) { $this->voted_at = $voted_at; }

    // Retrieve members available for a specific event
    public static function getAvailableMembersByEventId($event_id) {
        // Replace this with your database query logic
        // Here, I'm just returning a dummy array of available members
        $availableMembers = array(
            new EventVoting($event_id, 1, 'Available', '', '2023-01-01 12:00:00'),
            new EventVoting($event_id, 3, 'Available', '', '2023-01-02 14:30:00'),
            // Add more available members as needed
        );

        return $availableMembers;
    }

    // Retrieve members not available with reasons for a specific event
    public static function getNotAvailableMembersWithReasonsByEventId($event_id) {
        // Replace this with your database query logic
        // Here, I'm just returning a dummy array of not available members with reasons
        $notAvailableMembersWithReasons = array(
            new EventVoting($event_id, 2, 'Not Available', 'Busy', '2023-01-02 14:30:00'),
            new EventVoting($event_id, 4, 'Not Available', 'Unavailable', '2023-01-03 10:00:00'),
            // Add more not available members with reasons as needed
        );

        return $notAvailableMembersWithReasons;
    }

    // Generate HTML for members available and not available for a specific event
    public static function getVotingStatusByEventId($event_id) {
        $availableMembers = self::getAvailableMembersByEventId($event_id);
        $notAvailableMembersWithReasons = self::getNotAvailableMembersWithReasonsByEventId($event_id);

        $html = "<h3>Members Available:</h3>";
        if (count($availableMembers) > 0) {
            $html .= "<p>Number of available members: " . count($availableMembers) . "</p>";
            $html .= "<p><a href='memberAvailableEvent.php?event_id=$event_id'>View Available Members</a></p>";
        } else {
            $html .= "<p>No members available for this event.</p>";
        }

        $html .= "<h3>Members Not Available:</h3>";
        if (count($notAvailableMembersWithReasons) > 0) {
            $html .= "<p>Number of not available members: " . count($notAvailableMembersWithReasons) . "</p>";
            $html .= "<p><a href='memberNotAvailableEvent.php?event_id=$event_id'>View Not Available Members with Reasons</a></p>";
        } else {
            $html .= "<p>No members not available for this event.</p>";
        }

        return $html;
    }
}

// Example usage:
$event_id = 1; // Replace with the actual event ID
$votingStatus = EventVoting::getVotingStatusByEventId($event_id);

// Display the voting status wherever you want on your webpage
echo "<h2>Voting Status</h2>" . $votingStatus;

?>
