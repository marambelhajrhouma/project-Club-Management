<?php

class EventFeedback {
    private $event_id, $member_id, $satisfaction_rating, $feedback_text;

    // Keep track of total feedback count for the event
    private static $totalFeedbackCount = 0;

    public function __construct($event_id, $member_id, $satisfaction_rating, $feedback_text) {
        $this->event_id = $event_id;
        $this->member_id = $member_id;
        $this->satisfaction_rating = $satisfaction_rating;
        $this->feedback_text = $feedback_text;

        // Increment total feedback count
        self::$totalFeedbackCount++;
    }

    public function getEventId() { return $this->event_id; }
    public function getMemberId() { return $this->member_id; }
    public function getSatisfactionRating() { return $this->satisfaction_rating; }
    public function getFeedbackText() { return $this->feedback_text; }

    public function setEventId($event_id) { $this->event_id = $event_id; }
    public function setMemberId($member_id) { $this->member_id = $member_id; }
    public function setSatisfactionRating($satisfaction_rating) { $this->satisfaction_rating = $satisfaction_rating; }
    public function setFeedbackText($feedback_text) { $this->feedback_text = $feedback_text; }

    // Retrieve all feedbacks for a specific event
    public static function getFeedbacksByEventId($event_id) {
        // Replace this with your database query logic
        // Here, I'm just returning a dummy array of feedback objects
        $feedbacks = array(
            new EventFeedback($event_id, 1, 5, 'Great event!'),
            new EventFeedback($event_id, 2, 4, 'Enjoyed it.'),
            // Add more feedbacks as needed
        );

        return $feedbacks;
    }

    // Generate an HTML table for feedbacks of a specific event
    public static function getFeedbacksTableByEventId($event_id) {
        $eventDetails = "Event ID: $event_id"; // Replace with actual event details
        $feedbacks = self::getFeedbacksByEventId($event_id);

        $table = "<table border='1'>
                    <tr>
                        <th colspan='4'>$eventDetails</th>
                    </tr>
                    <tr>
                        <th>Member ID</th>
                        <th>Satisfaction Rating</th>
                        <th>Feedback Text</th>
                    </tr>";

        foreach ($feedbacks as $feedback) {
            $table .= "<tr>
                            <td>{$feedback->getMemberId()}</td>
                            <td>{$feedback->getSatisfactionRating()}</td>
                            <td>{$feedback->getFeedbackText()}</td>
                        </tr>";
        }

        $table .= "<tr>
                        <th colspan='2'>Total Feedbacks:</th>
                        <td colspan='2'>" . self::$totalFeedbackCount . "</td>
                    </tr>";

        $table .= "</table>";

        return $table;
    }
}

// Example usage:
$event_id = 1; // Replace with the actual event ID
$feedbacksTable = EventFeedback::getFeedbacksTableByEventId($event_id);

// Display the table wherever you want on your webpage
echo "<h2>Feedbacks</h2>" . $feedbacksTable;

?>
