<?php

include_once('../model/MemberProfile.php');
include_once('../database/config.php');

class MemberProfileController extends Connexion
{
    function __construct()
    {
        parent::__construct();
    }

    private function isMemberIdValid($memberId)
    {
        $query = "SELECT * FROM Members WHERE member_id = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$memberId]);
        
        // Check if the member ID exists in the Members table
        return $stmt->fetch() !== false;
    }
    

    public function createMemberProfile($memberId, $fullName, $imageUrl, $aboutMe, $interests, $skills)
    {
        try {
            // Add this validation before executing the query
            if (!is_numeric($memberId) || $memberId <= 0 || !$this->isMemberIdValid($memberId)) {
                throw new Exception("Error: Invalid member ID.");
            }
    
            // Use the actual table name and column names in your database
            $query = "INSERT INTO memberprofiles(member_id, full_name, image_url, about_me, interests, skills) 
                      VALUES (?, ?, ?, ?, ?, ?)";
    
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$memberId, $fullName, $imageUrl, $aboutMe, $interests, $skills]);
    
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error creating member profile: " . $e->getMessage());
        }
    }
    
    
    function hasProfile($memberId) {
        $query = "SELECT COUNT(*) FROM memberprofiles WHERE member_id = ?";
        $res = $this->executeQuery($query, [$memberId]);
        return $res->fetchColumn() > 0;
    }
    function getMemberProfile($memberId) {
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

?>
