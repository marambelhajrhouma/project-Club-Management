<?php

class MemberEngagement {
    private $member_id, $total_attendance, $total_feedback_given;

    public function __construct($member_id, $total_attendance = 0, $total_feedback_given = 0) {
        $this->member_id = $member_id;
        $this->total_attendance = $total_attendance;
        $this->total_feedback_given = $total_feedback_given;
    }

    public function getMemberId() { return $this->member_id; }
    public function getTotalAttendance() { return $this->total_attendance; }
    public function getTotalFeedbackGiven() { return $this->total_feedback_given; }

    public function setMemberId($member_id) { $this->member_id = $member_id; }
    public function setTotalAttendance($total_attendance) { $this->total_attendance = $total_attendance; }
    public function setTotalFeedbackGiven($total_feedback_given) { $this->total_feedback_given = $total_feedback_given; }
}

?>
