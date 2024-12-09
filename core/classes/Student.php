<?php

namespace App\Core\Classes;

class Student extends User {
    public $course;
    public $yearOfStudy;
    public $interests;

    public function __construct($name, $email, $password, $currentCourse, $yearOfStudy, $interests) {
        $this->setName($name);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setCurrentCourse($currentCourse);
        $this->setYearOfStudy($yearOfStudy);
        $this->setInterests($interests);
    }

    public function getCurrentCourse() {
        return $this->course;
    }

    public function setCurrentCourse($currentCourse) {
        $this->course = $currentCourse;
    }

    public function getYearOfStudy() {
        return $this->yearOfStudy;
    }

    public function setYearOfStudy($yearOfStudy) {
        $this->yearOfStudy = $yearOfStudy;
    }

    public function getInterests() {
        return $this->interests;
    }

    public function setInterests($interests) {
        $this->interests = $interests;
    }
}
