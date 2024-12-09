<?php

namespace App\Controllers;

use App\Core\Classes\Job_Internship;
use core\Controller;
use stdClass;

class JobController extends Controller
{
    private $jobModel;

    public function __construct(){
        $this->jobModel = $this->model("JobModel");
    }

    public function getJobInternships(){
        $result = $this->jobModel->getJobInternships();
        if($result !== null){
            echo json_encode(['success' => true, 'data' => $result]);
        }else{
            echo json_encode(['success' => false, 'message' => 'No data found']);
        }
        exit;
    }

    public function postJobInternship(){
        $data = $this->getRequest('POST');

        if (empty($data)) {
            return;
        }

        $jobData = new Job_Internship(
            $this->requestInput('title'),
            $this->requestInput('company'),
            $this->requestInput('location'),
            $this->requestInput('description'),
            $this->requestInput('requirements'),
            $this->requestInput('salary')
        );
        $jobData->setCreaterId($this->getSession('user_id'));

        $result = $this->jobModel->postJobInternship($jobData);
        if($result === true){
            echo json_encode(['success' => true, 'message' => 'Job / Internship added successfully.']);
        }else{
            echo json_encode(['success' => false, 'message' => 'Something went wrong.']);
        }
        exit;
    }

    public function getMyJobInternship($id){
        $result = $this->jobModel->getMyJobInternship($id);
        if($result != null){
            echo json_encode(['success' => true, 'data' => $result]);
        }else{
            echo json_encode(['success' => false, 'message' => 'Something went wrong.']);
        }
        exit;
    }

    public function applyJobInternship(){
        $data = $this->getRequest('POST');

        if (empty($data)) {
            return;
        }

        $request = new stdclass();
        $request->studentId = $this->requestInput('studentId');
        $request->jobId = $this->requestInput('jobId');
        $request->action = 'Pending';

        $result = $this->jobModel->applyJobInternship($request);
        if($result === true){
            echo json_encode(['success' => true, 'message' => 'Job / Internship applied successfully.']);
        }else{
            echo json_encode(['success' => false, 'message' => 'Something went wrong.']);
        }
        exit;
    }
}