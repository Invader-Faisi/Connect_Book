<?php

namespace App\Controllers;

use App\Core\Classes\Mentorship;
use App\Models\MentorModel;
use core\Controller;

class MentorController extends Controller
{
    private $mentorModel;

    /**
     * @throws \Exception
     */
    public function __construct(){
        $this->mentorModel = $this->model("MentorModel");
    }

    public function getMentorOffers($id){
        $result = $this->mentorModel->getMentorOffers($id);
        if ($result !== null) {
            echo json_encode(['success' => true, 'data' => $result]);
        }else{
            echo json_encode(['success' => false, 'message' => 'Something went wrong.']);
        }
        exit;
    }

    public function getMentorShips(){
        $result = $this->mentorModel->getMentorShips();

        if ($result !== null) {
            echo json_encode(['success' => true, 'data' => $result]);
        }else{
            echo json_encode(['success' => false, 'message' => 'Something went wrong.']);
        }
        exit;
    }

    public function deleteMentorshipOffer($id){
        $result = $this->mentorModel->deleteMentorshipOffer($id);
        if ($result > 0) {
            echo json_encode(['success' => true, 'message' => 'Mentorship Offer deleted successfully.']);
        }else{
            echo json_encode(['success' => false, 'message' => 'Something went wrong.']);
        }
        exit;
    }

    public function getMentees($id){
        $result = $this->mentorModel->getMentees($id);
        if($result !== null){
            echo json_encode(['success' => true, 'data' => $result]);
        }else{
            echo json_encode(['success' => false, 'message' => 'Something went wrong.']);
        }
        exit;
    }

    public function postMentorOffers(){
        $data = $this->getRequest('POST');

        if (empty($data)) {
            return;
        }

        $mentorShip = new Mentorship();
        $mentorShip->setAlumniId($this->requestInput('alumniId'));
        $mentorShip->setMentorOffer($this->requestInput('mentorOffer'));
        $mentorShip->setDescription($this->requestInput('description'));

        $result = $this->mentorModel->saveMentorship($mentorShip);
        if ($result === true) {
            echo json_encode(['success' => true, 'message' => 'Mentorship Offer added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Something went wrong.']);
        }
        exit;
    }

    public function getMyMentorship($id){
        $result = $this->mentorModel->getMyMentorship($id);
        if($result !== null){
            echo json_encode(['success' => true, 'data' => $result]);
        }else{
            echo json_encode(['success' => false, 'message' => 'Something went wrong.']);
        }
        exit;
    }

    public function applyForMentorship(){
        $data = $this->getRequest('POST');

        if (empty($data)) {
            return;
        }

        $request = new \stdClass();
        $request->mentorshipId = $this->requestInput('mentorshipId');
        $request->alumniId = $this->requestInput('alumniId');
        $request->menteeId = $this->requestInput('userId');
        $request->action = 'Pending';

//        echo '<pre>';
//        print_r($request);
//        echo '</pre>';

        $result = $this->mentorModel->applyForMentorship($request);
        if ($result === true) {
            echo json_encode(['success' => true, 'message' => 'Mentorship Applied successfully.']);
        }else{
            echo json_encode(['success' => false, 'message' => 'Something went wrong.']);
        }
        exit;
    }

    public function approveMentorship($id){
        $result = $this->mentorModel->approveMentorship($id);
        if($result !== null){
            echo json_encode(['success' => true, 'message' => 'Mentorship Approved successfully.']);
        }else{
            echo json_encode(['success' => false, 'message' => 'Something went wrong.']);
        }
    }

}