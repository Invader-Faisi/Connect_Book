<?php

namespace App\Controllers;

use App\Core\Classes\Event;
use core\Controller;

class EventController extends Controller
{
    private $eventModel;

    public function __construct(){
        $this->eventModel = $this->model("EventModel");
    }

    public function addEvent($id = '')
    {
        $data = $this->getRequest('POST');

        if (empty($data)) {
            return;
        }

        $event = new Event(
            $this->requestInput('event'),
            $this->requestInput('date'),
            $this->requestInput('place')
        );

        if($id == ''){
            $result = $this->eventModel->addEvent($event);
        }else{
            $result = $this->eventModel->addEvent($event,$id);
        }

        if($result === true){
            echo json_encode(['success' => true, 'message' => 'Event added successfully!']);
        }else{
            echo json_encode(['success' => false, 'message' => 'Something went wrong!']);
        }
        exit;
    }

    public function deleteEvent($id){
        $result = $this->eventModel->deleteEvent($id);
        if($result === true){
            echo json_encode(['success' => true, 'message' => 'Event deleted successfully!']);
        }else{
            echo json_encode(['success' => false, 'message' => 'Something went wrong!']);
        }
        exit;
    }

    public function getAllEvents(){
        $result = $this->eventModel->getAllEvents();
        if($result != null){
            echo json_encode(['success' => true, 'data' => $result]);
        }else{
            echo json_encode(['success' => false, 'message' => 'No data found']);
        }
        exit;
    }

    public function getMyEvents($email){
        $result = $this->eventModel->getMyEvents($email);
        if($result != null){
            echo json_encode(['success' => true, 'data' => $result]);
        }else{
            echo json_encode(['success' => false, 'message' => 'No data found']);
        }
        exit;
    }

    public function registerForEvent(){
        $data = $this->getRequest('POST');

        if (empty($data)) {
            return;
        }

        $tempObject = new \stdClass();

        $tempObject->event_id = $this->requestInput('event_id');
        $tempObject->name = $this->requestInput('name');
        $tempObject->email = $this->requestInput('email');

        $result = $this->eventModel->registerForEvent($tempObject);

        if($result === true){
            echo json_encode(['success' => true, 'message' => 'Registered for event Successfully']);
        }else{
            echo json_encode(['success' => false, 'message' => 'Something went wrong']);
        }
        exit;
    }

    public function getEventById($id)
    {
        $result = $this->eventModel->getEventById($id);
        if($result != null){
            echo json_encode(['success' => true, 'data' => $result]);
        }else{
            echo json_encode(['success' => false, 'message' => 'Something went wrong']);
        }
        exit;
    }
}