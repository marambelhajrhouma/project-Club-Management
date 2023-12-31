<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once('../model/member.php');
include_once('../database/config.php');

class MemberController extends Connexion {

    function __construct() {
        parent::__construct();
    }

    /*------------------- login and registration*/ 
    function isUsernameAvailable($username) {
        $query = "SELECT * FROM Members WHERE username = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$username]);
        $result = $stmt->fetch();
        return !$result;
    }
    
    function createMember($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Assuming join_date is the current date
        $joinDate = date('Y-m-d');
        
        $query = "INSERT INTO Members(username, password, join_date, role) VALUES (?, ?, ?,'Club Member')";
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute([$username, $hashedPassword, $joinDate]);
    
        if ($result) {
            // Fetch the newly created member
            $query = "SELECT * FROM Members WHERE username = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$username]);
            return $stmt->fetch();
        }
    
        return false;
    }

    function getHashedPasswordByEmail($email) {
        $query = "SELECT password FROM Members WHERE email = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$email]);
        $result = $stmt->fetch();
    
        return $result ? $result['password'] : null;
    }
    function login($username , $password) {
        $query = "SELECT * FROM members WHERE username = ?";
        $res = $this->executeQuery($query, [$username ]);
        $member = $res->fetch(PDO::FETCH_ASSOC);
        return $member;
    }


    /*------------------- list of members and registration*/ 
    function listMembers() {
        $query = "SELECT * FROM Members";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*--delete member */
    function deleteMember($memberId) {
        $query = "DELETE FROM Members WHERE member_id = ?";
        $stmt = $this->pdo->prepare($query);
    
        $params = array($memberId);
    
        return $stmt->execute($params);
    }

    /*--Edit role member*/
    // to edit
    function getMemberById($id) {
        try {
            $query = "SELECT * FROM Members WHERE member_id = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Error fetching member by ID: " . $e->getMessage();
            return false;
        }
    }

    function getRole($member_id){
        $query = "SELECT role FROM Members WHERE member_id = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$member_id]);
        return $stmt->fetch();
    }
    
    function changeRole($memberId, $newRole) {
        // Check if the user has the privilege to change roles
        if ($_SESSION['role'] === 'President') {
            // Define valid roles
            $validRoles = ['Club Member', 'President'];
    
            // Get the current role of the member
            $currentRole = $this->getCurrentRole($memberId);
    
            // Check if the new role is valid
            if (in_array($newRole, $validRoles)) {
                // Check if the new role is different from the current role
                if ($newRole !== $currentRole) {
                    // If the new role is "President," remove the "President" role from any existing member
                    if ($newRole === 'President') {
                        $this->removeThePresidents();
                    }
    
                    // Update the role in the database
                    $query = "UPDATE members SET role = ? WHERE member_id = ?";
                    $res = $this->executeQuery($query, [$newRole, $memberId]);
    
                    return $res;
                }
            }
        }
    
        // User does not have the privilege to change roles
        return false;
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


    private function executeQuery($query, $params) {
        $res = $this->pdo->prepare($query);
        $res->execute($params);
        return $res;
    }
}
?>
