<?php

namespace App\Core\Classes;


class Alumni extends User {
    public $graduationYear;
    public $degree;
    public $occupation;
    public $contact;

    public function __construct($name, $email, $password, $graduationYear, $degree, $currentOccupation, $contactDetails) {
        $this->setName($name);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setGraduationYear($graduationYear);
        $this->setDegree($degree);
        $this->setCurrentOccupation($currentOccupation);
        $this->setContactDetails($contactDetails);
    }

    public function getGraduationYear() {
        return $this->graduationYear;
    }

    public function setGraduationYear($graduationYear) {
        $this->graduationYear = $graduationYear;
    }

    public function getDegree() {
        return $this->degree;
    }

    public function setDegree($degree) {
        $this->degree = $degree;
    }

    public function getCurrentOccupation() {
        return $this->occupation;
    }

    public function setCurrentOccupation($currentOccupation) {
        $this->occupation = $currentOccupation;
    }

    public function getContactDetails() {
        return $this->contact;
    }

    public function setContactDetails($contactDetails) {
        $this->contact = $contactDetails;
    }
}