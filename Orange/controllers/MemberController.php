<?php

include_once('../database/config.php');
include_once('../models/member.php');
class MemberController extends Connexion {

    function __construct() {
        parent::__construct();
    }

    function login($username , $password) {
        $query = "SELECT * FROM members WHERE username = ?";
        $res = $this->executeQuery($query, [$username ]);
        $member = $res->fetch(PDO::FETCH_ASSOC);
        return $member;
    }
    function insert(Member $m) {
        $query = "INSERT INTO members(username, password,join_date) VALUES (?, ?, ?)";
        $res = $this->pdo->prepare($query);
        // Hash the password before storing
        $hashedPassword = password_hash($m->getPassword(), PASSWORD_DEFAULT);

        $aryy = array($m->getUsername(), $hashedPassword, $m->getJoinDate());
        return $res->execute($aryy);
    }

    function changeRole($memberId, $newRole) {
        if ($_SESSION['role'] === 'President') {
            $validRoles = ['Club Member','President'];
            $currentRole = $this->getCurrentRole($memberId);
            if (in_array($newRole, $validRoles)) {
                if ($newRole !== $currentRole) {
                    if ($newRole === 'President') {
                        $this->removeThePresidents();
                    }
                    $query = "UPDATE members SET role = ? WHERE member_id = ?";
                    $res = $this->executeQuery($query, [$newRole, $memberId]);
                    return $res;
                }
            }
        } else {
            return false;
        }
    }

    private function removeThePresidents() {
        $query = "UPDATE members SET role='Club Member' WHERE role = 'President'";
        $this->pdo->exec($query);
    }

    private function getCurrentRole($memberId) {
        $query = "SELECT role FROM members WHERE member_id = ?";
        $res = $this->pdo->prepare($query);
        $res->execute([$memberId]);
        return $res->fetchColumn();
    }


    function deleteMember($memberId) {
        // Only allow deletion by the President
        if ($_SESSION['role'] === 'President') {
            $query = "DELETE FROM members WHERE member_id = ?";
            $res = $this->executeQuery($query, [$memberId]);
            return $res;
        } else {
            return false;
        }
    }

    function deleteProfile($memberId) {
        // Allow only the member to delete their own profile
        $query = "DELETE FROM memberprofiles WHERE member_id = ?";
        $res = $this->executeQuery($query, [$memberId]);
        return $res;
    }

    function getProfile($memberId) {
        $query = "SELECT * FROM memberprofiles WHERE member_id = ?";
        $res = $this->executeQuery($query, [$memberId]);
        return $res->fetch(PDO::FETCH_ASSOC);
    }

    private function executeQuery($query, $params) {
        $res = $this->pdo->prepare($query);
        $res->execute($params);
        return $res;
    }

}
