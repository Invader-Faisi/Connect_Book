<?php

namespace App\Core\Classes;

class News
{
    public $id;
    public $title;
    public $description;
    public function __construct($title,$description)
    {
        $this->description = $description;
        $this->title = $title;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }



}