<?php

namespace App\Core\Classes;

class Job_Internship {
    public $id;
    public $creater_id;
    public $title;
    public $company;
    public $location;
    public $description;
    public $requirements;
    public $salary;

    // Constructor
    public function __construct($title , $company , $location , $description , $requirements , $salary ) {
        $this->setTitle($title);
        $this->setCompany($company);
        $this->setLocation($location);
        $this->setDescription($description);
        $this->setRequirements($requirements);
        $this->setSalary($salary);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCreaterId()
    {
        return $this->creater_id;
    }

    public function setCreaterId($creater_id)
    {
        $this->creater_id = $creater_id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setCompany($company) {
        $this->company = $company;
    }

    public function getLocation() {
        return $this->location;
    }

    public function setLocation($location) {
        $this->location = $location;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getRequirements() {
        return $this->requirements;
    }

    public function setRequirements($requirements) {
        $this->requirements = $requirements;
    }

    public function getSalary() {
        return $this->salary;
    }

    public function setSalary($salary) {
        $this->salary = $salary;
    }
}
