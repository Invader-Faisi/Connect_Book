<?php

namespace App\Core\Classes;

class Discussion
{
    public $id;
    public $title;
    public $description;
    public $author;

    public function __construct($title, $description, $author){
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setAuthor($author);
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setTitle($title){
        $this->title = $title;
    }
    public function setDescription($description){
        $this->description = $description;
    }
    public function setAuthor($author){
        $this->author = $author;
    }
    public function getId(){
        return $this->id;
    }
    public function getTitle(){
        return $this->title;
    }
    public function getDescription(){
        return $this->description;
    }
    public function getAuthor(){
        return $this->author;
    }

}