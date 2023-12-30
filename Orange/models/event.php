<?php

class Event {
    private $event_id, $event_name, $event_description, $event_date, $organizer_id, $voting_deadline;

    public function __construct($event_name, $event_description, $event_date, $organizer_id, $voting_deadline) {
        $this->event_name = $event_name;
        $this->event_description = $event_description;
        $this->event_date = $event_date;
        $this->organizer_id = $organizer_id;
        $this->voting_deadline = $voting_deadline;
    }

    public function getEventId() { return $this->event_id; }
    public function getEventName() { return $this->event_name; }
    public function getEventDescription() { return $this->event_description; }
    public function getEventDate() { return $this->event_date; }
    public function getOrganizerId() { return $this->organizer_id; }
    public function getVotingDeadline() { return $this->voting_deadline; }

    

    
    public function setEventName($event_name) { $this->event_name = $event_name; }
    public function setEventDescription($event_description) { $this->event_description = $event_description; }
    public function setEventDate($event_date) { $this->event_date = $event_date; }
    public function setOrganizerId($organizer_id) { $this->organizer_id = $organizer_id; }
    public function setVotingDeadline($voting_deadline) { $this->voting_deadline = $voting_deadline; }
}

?>
