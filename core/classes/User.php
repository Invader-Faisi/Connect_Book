<?php

namespace App\Core\Classes;
class User {
    public $id;
    public $name;
    public $email;
    public $password;
    public $userType;

    public function __construct($name, $email, $password, $user) {
        $this->setName($name);
        $this->setEmail($email);
        $this->setPassword($this->hashPassword($password));
        $this->userType = $user;
    }

    // Getters and Setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getUserType() {
        return $this->userType;
    }

    public function setUserType($user) {
        $this->userType = $user;
    }

    // Utility Methods
    public function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($password) {
        return password_verify($password, $this->password);
    }
}
