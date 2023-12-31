<?php
// member.php
class Member {

    protected $member_id , $username, $email, $password;

    public function __construct($member_id , $username, $password) {
        $this->member_id  = $member_id ;
        $this->username = $username;
        $this->password = $password;
    }

    //_____________________id_______________________

    public function getIdmember() {
        return $this->member_id ;
    }

    //_____________________name_______________________
    public function getUsername() {
        return $this->username;
    }
    
    //_____________________password_______________________
    public function getPassword() {
        return $this->password;
    }
}
?>