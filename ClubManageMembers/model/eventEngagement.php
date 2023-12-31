<?php

class EventEngagement {
    private $event_id, $total_votes ,$total_feedback;

    public function __construct($event_id, $total_votes = 0 ,$total_feedback = 0) {
        $this->event_id = $event_id;
        $this->total_votes = $total_votes;
        $this->total_feedback = $total_feedback;
    }

    public function getEventId() { return $this->event_id; }
    public function getTotalVotes() { return $this->total_votes; }
    public function getTotalFeedback() { return $this->total_feedback; }
    public function setEventId($event_id) { $this->event_id = $event_id; }
    public function setTotalVotes($total_votes) { $this->total_votes = $total_votes; }
    
    public function setTotalFeedback($total_feedback) { $this->total_feedback = $total_feedback; }
}

?>
