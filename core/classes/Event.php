<?php

namespace App\Core\Classes;

class Event
{
    public $id;
    public $event;
    public $date;
    public $place;

    public function __construct($event, $date, $place){
        $this->setEvent($event);
        $this->setDate($date);
        $this->setPlace($place);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function setEvent($event)
    {
        $this->event = $event;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getPlace()
    {
        return $this->place;
    }

    public function setPlace($place)
    {
        $this->place = $place;
    }




}