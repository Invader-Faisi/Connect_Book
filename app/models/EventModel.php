<?php

namespace App\Models;

use App\Core\Classes\Event;
use core\Model;

class EventModel extends Model
{
    public function getAllEvents(){
        return $this->selectAll('event');
    }

    public function addEvent(Event $event, $id = ''){
        if($id != ''){
            return  $this->updateObject('event',$event, $id);
        }else{
            return $this->insertObject('event',$event);
        }

    }

    public function deleteEvent($id){
        return $this->deleteWhere('event',$id);
    }

    public function getMyEvents($email){
        return $this->selectFromMultipleTables(
                ['event','event_participation'],
                ['event.id = event_participation.event_id AND event_participation.email = "'.$email.'"'],
                ['INNER JOIN'], 'event.event,event.date,event.place');
    }

    public function registerForEvent(\stdClass $event){
        return $this->insertObject('event_participation', $event);
    }

    public function getEventById($id){
        return $this->selectWhere('event', ['id' => $id]);
    }

    public function getAllEventRegistration($event){
        return $this->selectFromMultipleTables(
            ['event_participation', 'users'],
            ['event_participation.event_id = "'.$event.'" AND event_participation.email = users.email'],
            ['INNER JOIN'],
            'event_participation.*, users.userType'
        );
    }
}