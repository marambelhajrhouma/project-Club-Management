<?php

class EventVoting {
    private $voting_id, $event_id, $member_id, $availability, $absence_reason, $voted_at;

    public function __construct($event_id, $member_id, $availability, $absence_reason ="", $voted_at) {
        $this->event_id = $event_id;
        $this->member_id = $member_id;
        $this->availability = $availability;
        $this->absence_reason = $absence_reason;
        $this->voted_at = $voted_at;
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
}

?>
