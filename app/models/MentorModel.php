<?php

namespace App\Models;

use App\Core\Classes\Mentorship;
use core\Model;

class MentorModel extends Model
{
    public function getMentorOffers($id){
        return $this->selectWhere('mentorship', ['alumniId' => $id]);
    }

    public function getMentorShips(){
        return $this->selectFromMultipleTables(
            ['mentorship','alumni'],
            ['alumni.id = mentorship.alumniId'],
            ['INNER JOIN'],
            'mentorship.id,mentorship.alumniId,mentorship.mentorOffer,mentorship.description,alumni.name'
        );
    }

    public function deleteMentorshipOffer($id){
        return $this->deleteWhere('mentorship', $id);
    }
    public function saveMentorShip(MentorShip $mentorShip){
        return $this->insertObject('mentorship', $mentorShip);
    }

    public function getMentees($id){
        return $this->selectFromMultipleTables(
            ['mentorship', 'mentor_request', 'students'],
            [
                'mentorship.id = mentor_request.mentorshipId',
                'mentor_request.menteeId = students.id'
            ],
            ['JOIN', 'JOIN'],
            'students.name, students.course, students.yearOfStudy, mentorship.mentorOffer, mentorship.description,mentor_request.id,mentor_request.action',
            'mentorship.alumniId = "'.$id.'"'
        );
    }

    public function getMyMentorship($id){
        return $this->selectFromMultipleTables(
            ['mentorship', 'mentor_request', 'alumni'],
            [
                'mentorship.id = mentor_request.mentorshipId',
                'mentorship.alumniId = alumni.id'
            ],
            ['JOIN','JOIN'],
            'alumni.name,mentorship.mentorOffer,mentorship.description,mentor_request.action',
            'mentor_request.menteeId = "'.$id.'" ORDER BY mentor_request.id DESC'
        );
    }

    public function applyForMentorship(\stdClass $mentorship){
        return $this->insertObject('mentor_request', $mentorship);
    }

    public function approveMentorship($id){
        return $this->executeWithQuery('UPDATE mentor_request SET action = "Approved" WHERE id = ?', [$id]);
    }


}