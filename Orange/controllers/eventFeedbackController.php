<?
include_once('../database/config.php');
include_once('../models/eventFeedback.php');
class EventFeedbackController extends Connexion {

    function __construct() {
        parent::__construct();
    }

    function getFeedbacksByEventId($event_id) {
        // Assuming you have a database connection, modify this part accordingly
        $db = new mysqli("your_host", "your_username", "your_password", "your_database");

        $event_id = $db->real_escape_string($event_id);

        $query = "SELECT * FROM EventFeedback WHERE event_id = $event_id";
        $result = $db->query($query);

        $feedbacks = [];
        while ($row = $result->fetch_assoc()) {
            $feedback = new EventFeedback($row['event_id'], $row['member_id'], $row['satisfaction_rating'], $row['feedback_text']);
            $feedback->setFeedbackId($row['feedback_id']);
            $feedbacks[] = $feedback;
        }

        return $feedbacks;
    }
    

}
?>