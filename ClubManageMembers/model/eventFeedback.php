<?php

class EventFeedback {
    private $feedback_id, $event_id, $member_id, $satisfaction_rating, $feedback_text;

    public function __construct($event_id, $member_id, $satisfaction_rating, $feedback_text) {
        $this->event_id = $event_id;
        $this->member_id = $member_id;
        $this->satisfaction_rating = $satisfaction_rating;
        $this->feedback_text = $feedback_text;
    }

    public function getFeedbackId() { return $this->feedback_id; }
    public function getEventId() { return $this->event_id; }
    public function getMemberId() { return $this->member_id; }
    public function getSatisfactionRating() { return $this->satisfaction_rating; }
    public function getFeedbackText() { return $this->feedback_text; }

    public function setFeedbackId($feedback_id) { $this->feedback_id = $feedback_id; }
    public function setEventId($event_id) { $this->event_id = $event_id; }
    public function setMemberId($member_id) { $this->member_id = $member_id; }
    public function setSatisfactionRating($satisfaction_rating) { $this->satisfaction_rating = $satisfaction_rating; }
    public function setFeedbackText($feedback_text) { $this->feedback_text = $feedback_text; }
}

?>
