<?php

namespace App\Models;

use App\Core\Classes\Alumni;
use App\Core\Classes\Student;
use App\Core\Classes\User;
use core\Model;
class UserModel extends Model{

    private function saveUser(User $user, $userType) {
        $user->setUserType($userType);
        return $this->insertObject("users", $user);
    }

    public function saveAlumni(Alumni $alumni) {
        $user = new User($alumni->getName(), $alumni->getEmail(), $alumni->getPassword(), 'Alumni');
        $result = $this->saveUser($user, 'Alumni');
        if($result) {
            return $this->insertObject("alumni", $alumni);
        }
        return $result;
    }

    public function saveStudent(Student $student) {
        $user = new User($student->getName(), $student->getEmail(), $student->getPassword(), 'Student');
        $result = $this->saveUser($user, 'Student');
        if($result) {
            return $this->insertObject("students", $student);
        }
        return $result;
    }

    public function getAlumniRewards($id){
        return $this->executeWithQuery('
                SELECT 
                (SELECT COUNT(*) FROM job_internship WHERE creater_id = ?) AS job_reward,
                (SELECT COUNT(*) FROM mentorship WHERE alumniId = ?) AS internship_reward,
                (
                    (SELECT COUNT(*) FROM job_internship WHERE creater_id = ?) + 
                    (SELECT COUNT(*) FROM mentorship WHERE alumniId = ?)
                ) AS total_reward;
        ',[$id,$id,$id,$id]);
    }
}
