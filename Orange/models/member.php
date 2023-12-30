<?php

class Member {
    protected $member_id, $username, $password, $role, $join_date, $last_activity, $active_status, $absence_count;

    public function __construct($username = "", $password = "",$join_date = "") {
        $this->username = $username;
        $this->password = $password;
        $this->role = "Club Member";
        $this->join_date = $join_date;
    }

    public function getUsername() { return $this->username; }
    public function setUsername($username) { $this->username = $username; }

    public function getRole() { return $this->role; }
    public function setRole($role, $changerRole) {
        if ($changerRole === "President") {
            $validRoles = ['Club Member', 'Core Team', 'President'];
            if (in_array($role, $validRoles)) {
                $this->role = $role;
            }
        }
    }

    public function getJoinDate() { return $this->join_date; }
    public function setJoinDate($join_date) { $this->join_date = $join_date; }

    public function getPassword() { return $this->password; }
    public function setPassword($password) { $this->password = $password; }

    public function getLastActivity() { return $this->last_activity; }
    public function setLastActivity($last_activity) { $this->last_activity = $last_activity; }

    public function getActiveStatus() { return $this->active_status; }
    public function setActiveStatus($active_status) { $this->active_status = $active_status; }

    public function getAbsenceCount() { return $this->absence_count; }
    public function setAbsenceCount($absence_count) { $this->absence_count = $absence_count; }
}

?>
