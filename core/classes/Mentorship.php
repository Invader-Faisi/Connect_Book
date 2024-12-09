<?php

namespace App\Core\Classes;

class Mentorship
{
    public $alumniId;
    public $mentorOffer;
    public $description;

    public function getAlumniId() {
        return $this->alumniId;
    }

    public function setAlumniId($alumni_id) {
        $this->alumniId = $alumni_id;
    }

    public function getMentorOffer() {
        return $this->mentorOffer;
    }

    public function setMentorOffer($mentor_offer) {
        $this->mentorOffer = $mentor_offer;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }


}
