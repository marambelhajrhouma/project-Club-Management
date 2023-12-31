<?php

include_once('../database/config.php');
include_once('../model/event.php');
include_once('../model/eventEngagement.php');
include_once('../model/eventFeedback.php');
include_once('../model/eventVoting.php');

class EventController extends Connexion {
private $errorMessage;
    function __construct() {
        parent::__construct();
        $this->errorMessage = null;
    }

    function getMemberVote($eventId, $memberId) {
        $query = "SELECT * FROM eventvoting WHERE event_id = ? AND member_id = ?";
        $res = $this->executeQuery($query, [$eventId, $memberId]);
        return $res->fetch(PDO::FETCH_ASSOC);
    }
    function getEventsForMonth($month, $year) {
        $firstDay = date("{$year}-{$month}-01");
        $lastDay = date("{$year}-{$month}-t");

        $query = "SELECT * FROM events WHERE event_date BETWEEN ? AND ?";
        $res = $this->executeQuery($query, [$firstDay, $lastDay]);
        $events = [];

        while ($row = $res->fetch()) {
            $eventId = $row['event_id'];
            $eventDate = $row['event_date'];
            $eventEnded = $this->isEventEnded($eventId);

            $events[date('d', strtotime($eventDate))][] = [
                'event_id' => $eventId,
                'event_name' => $row['event_name'],
                'event_description' => $row['event_description'],
                'color' => $this->getEventColor($eventId),
                'ended' => $eventEnded,
            ];
        }

        return $events;
    }

    function initializeEventEngagement($eventId) {
        // Initialize the EventEngagement table entry for the new event
        $query = "INSERT INTO eventengagement(event_id, total_votes, total_feedback) VALUES (?, 0, 0)";
        $this->executeQuery($query, [$eventId]);
    }

    function isThereAnEventEngagement($eventId){
        // Search if the event is already in the eventengagement
        $query = "SELECT COUNT(*) FROM eventengagement WHERE event_id = ?";
        $result = $this->executeQuery($query, [$eventId])->fetchColumn();
    
        return ($result > 0);
    }
    
    function voteEvent(EventVoting $vote) {
        $member_id = $vote->getEventId();
        // Check if the event has ended
        if ($this->isEventEnded($vote->getEventId())) {
            return false; // Voting is not allowed after the event ends
        }
    
        // Check if the member has already voted
        if ($this->hasMemberVoted($vote->getEventId(), $vote->getMemberId())) {
            return false; // Member has already voted
        }
    
        $query = "INSERT INTO eventvoting(event_id, member_id, availability, absence_reason, voted_at) VALUES (?, ?, ?, ?, ?)";
        $res = $this->executeQuery($query, [
            $vote->getEventId(),
            $vote->getMemberId(),
            $vote->getAvailability(),
            $vote->getAbsenceReason(),
            date('Y-m-d H:i:s') // Current timestamp
        ]);
        if($this->isThereAnEventEngagement($member_id)== false){
            $this->initializeEventEngagement($member_id);
        }
    
        // Update the total_votes in EventEngagement
        if ($res) {
            $this->updateEventEngagement($vote->getEventId(),'votes');
        }
    
        return $res;
    }

        function getMemberFeedback($eventId, $memberId) {
        $query = "SELECT * FROM eventfeedback WHERE event_id = ? AND member_id = ?";
        $res = $this->executeQuery($query, [$eventId, $memberId]);
        return $res->fetch(PDO::FETCH_ASSOC);
    }
    

    function editVote(EventVoting $vote) {
        // Allow only members to edit their own vote
        if ($_SESSION['role'] === 'Club Member') {
            // Check if the event has ended
            if ($this->isEventEnded($vote->getEventId())) {
                return false; // Editing is not allowed after the event ends
            }
    
            // Check if the member has already voted
            if (!$this->hasMemberVoted($vote->getEventId(), $vote->getMemberId())) {
                return false; // Member has not voted yet
            }
    
            $query = "UPDATE eventvoting SET availability = ?, absence_reason = ?, voted_at = ? WHERE event_id = ? AND member_id = ?";
            $res = $this->executeQuery($query, [
                $vote->getAvailability(),
                $vote->getAbsenceReason(),
                date('Y-m-d H:i:s'), // Update voted_at to the current timestamp
                $vote->getEventId(),
                $vote->getMemberId()
            ]);
    
            // Update the total_votes in EventEngagement
            if ($res) {
                $this->updateEventEngagement($vote->getEventId(),'votes');
            }
    
            return $res;
        } else {
            return false;
        }
    }
    
    function provideEventFeedback(EventFeedback $feedback) {
        if ($_SESSION['role'] === 'Club Member') {
            $query = "INSERT INTO eventfeedback(event_id, member_id, satisfaction_rating, feedback_text) VALUES (?, ?, ?, ?)";
            $res = $this->executeQuery($query, [
                $feedback->getEventId(),
                $feedback->getMemberId(),
                $feedback->getSatisfactionRating(),
                $feedback->getFeedbackText()
            ]);
            if($this->isThereAnEventEngagement($feedback->getEventId())== false){
                $this->initializeEventEngagement($feedback->getEventId());
            }
    
            // Update the total_feedback_given in EventEngagement
            if ($res) {
                $this->updateEventEngagement($feedback->getEventId(),'feedback');
            } else {
                $this->setErrorMessage("Failed to submit feedback. Please try again.");
            }
    
            return $res;
        } else {
            $this->setErrorMessage("Invalid role for providing feedback.");
            return false;
        }
    }
    


    function editFeedback(EventFeedback $feedback) {
        // Allow only members to edit their own feedback
        if ($_SESSION['role'] === 'Club Member') {
            $query = "UPDATE eventfeedback SET satisfaction_rating = ?, feedback_text = ? WHERE feedback_id = ? AND member_id = ?";
            $res = $this->executeQuery($query, [
                $feedback->getSatisfactionRating(),
                $feedback->getFeedbackText(),
                $feedback->getFeedbackId(),
                $feedback->getMemberId()
            ]);

            return $res;
        } else {
            return false;
        }
    }


    // Helper function to check if a member has already voted for an event
    private function hasMemberVoted($eventId, $memberId) {
        $query = "SELECT COUNT(*) FROM eventvoting WHERE event_id = ? AND member_id = ?";
        $res = $this->pdo->prepare($query);
        $res->execute([$eventId, $memberId]);
        return $res->fetchColumn() > 0;
    }

    function isEventEnded($eventId) {
        $query = "SELECT event_date FROM events WHERE event_id = ?";
        $res = $this->pdo->prepare($query);
        $res->execute([$eventId]);
        $eventDate = $res->fetchColumn();

        // Compare event date with current date and time
        return strtotime($eventDate) < time();
    }

    private function getEventIdByVoteId($voteId) {
        $query = "SELECT event_id FROM eventvoting WHERE vote_id = ?";
        $res = $this->pdo->prepare($query);
        $res->execute([$voteId]);
        return $res->fetchColumn();
    }
    
    private function getEventIdByFeedbackId($feedbackId) {
        $query = "SELECT event_id FROM eventfeedback WHERE feedback_id = ?";
        $res = $this->pdo->prepare($query);
        $res->execute([$feedbackId]);
        return $res->fetchColumn();
    }

    private function deleteEventVotes($eventId) {
        $query = "DELETE FROM eventvoting WHERE event_id = ?";
        $this->executeQuery($query, [$eventId]);
    }

    private function deleteEventFeedback($eventId) {
        $query = "DELETE FROM eventfeedback WHERE event_id = ?";
        $this->executeQuery($query, [$eventId]);
    }

    private function updateEventEngagement($eventId, $type) {
        // Check the type of update and construct the corresponding query
        if ($type === 'votes') {
            $query = "UPDATE eventengagement SET total_votes = total_votes + 1 WHERE event_id = ?";
        } elseif ($type === 'feedback') {
            $query = "UPDATE eventengagement SET total_feedback = total_feedback + 1 WHERE event_id = ?";
        } else {
            error_log("Unrecognized type '$type' for event engagement update.");
            return false; 
        }
    
        // Execute the query and check the result
        $res = $this->executeQuery($query, [$eventId]);
        if (!$res) {
            // Log or throw an error indicating the query execution failure
            error_log("Failed to update event engagement. Error: " . $this->getErrorMessage());
            return false; 
        }
        error_log("Event engagement updated successfully!");
    }
    

    function getEventDetails($eventId)
    {
        $query = "SELECT * FROM events WHERE event_id = ?";
        $res = $this->executeQuery($query, [$eventId]);
        return $res->fetch(PDO::FETCH_ASSOC);
    }

    
    function getErrorMessage() {
        return $this->errorMessage;
    }

    private function setErrorMessage($errorMessage) {
        $this->errorMessage = $errorMessage;
    }

    private function executeQuery($query, $params) {
        try {
            $res = $this->pdo->prepare($query);
            $res->execute($params);
            return $res;
        } catch (PDOException $e) {
            $this->setErrorMessage($e->getMessage());
            echo $e->getMessage(); // Add this line for debugging
            return false;
        }
    }
    
    function getEventColor($eventId) {
        $eventEnded = $this->isEventEnded($eventId);
        return $eventEnded ? '#FFA07A' : '#87CEEB'; // Change colors as needed
    }

    //add event
    function addEvent(Event $event) {
                
        $query = "INSERT INTO Events (event_name, event_description, event_date, organizer_id, voting_deadline) VALUES (?, ?, ?, ?, ?)";
        $res = $this->executeQuery($query, [
            $event->getEventName(),
            $event->getEventDescription(),
            $event->getEventDate(),
            $event->getOrganizerId(),
            $event->getVotingDeadline()
        ]);

        // After adding the event, check if there is an EventEngagement entry; if not, initialize it
        $eventId = $this->pdo->lastInsertId(); // Get the last inserted event ID
        if (!$this->isThereAnEventEngagement($eventId)) {
            $this->initializeEventEngagement($eventId);
        }

        return $res;
    
}

}

?>