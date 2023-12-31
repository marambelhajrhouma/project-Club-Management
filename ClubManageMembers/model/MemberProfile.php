<?php

class MemberProfile
{
    private $memberId;
    private $fullName;
    private $imageUrl;
    private $aboutMe;
    private $interests;
    private $skills;

    public function __construct($memberId, $fullName, $imageUrl, $aboutMe, $interests, $skills)
    {
        $this->memberId = $memberId;
        $this->fullName = $fullName;
        $this->imageUrl = $imageUrl;
        $this->aboutMe = $aboutMe;
        $this->interests = $interests;
        $this->skills = $skills;
    }

    // Getters
    public function getMemberId()
    {
        return $this->memberId;
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    public function getAboutMe()
    {
        return $this->aboutMe;
    }

    public function getInterests()
    {
        return $this->interests;
    }

    public function getSkills()
    {
        return $this->skills;
    }

    // Setters
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    public function setAboutMe($aboutMe)
    {
        $this->aboutMe = $aboutMe;
    }

    public function setInterests($interests)
    {
        $this->interests = $interests;
    }

    public function setSkills($skills)
    {
        $this->skills = $skills;
    }

}

?>
