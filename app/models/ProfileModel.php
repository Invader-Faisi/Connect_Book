<?php

namespace App\Models;

use App\Core\Classes\Alumni;
use App\Core\Classes\Student;
use App\Core\Classes\User;
use core\Model;

class ProfileModel extends Model
{
    public function getAlumniProfile($id){
        return $this->selectObjectWithId('alumni', $id);
    }

    public function getStudentProfile($id){
        return $this->selectObjectWithId('students', $id);
    }

    public function updateAlumniProfile(Alumni $alumni, $id, $login_id){

        $user = new User($alumni->getName(), $alumni->getEmail(), $alumni->getPassword(), 'Alumni');
        $result = $this->updateObject('users', $user, $login_id);
        if($result) {
            return $this->updateObject("alumni", $alumni,$id);
        }
        return $result;
    }

    public function updateStudentProfile(Student $student, $id, $login_id){
        $user = new User($student->getName(), $student->getEmail(), $student->getPassword(), 'Student');
        $result = $this->updateObject('users', $user, $login_id);
        if($result) {
            return $this->updateObject("students", $student,$id);
        }
        return $result;
    }

}