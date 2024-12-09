<?php

namespace App\Controllers;

use App\Core\Classes\Alumni;
use App\Core\Classes\Student;
use App\Models\ProfileModel;
use core\Controller;

class ProfileController extends Controller
{
    private $profileModel;

    /**
     * @throws \Exception
     */
    public function __construct(){
        $this->profileModel = $this->model("ProfileModel");
    }

    public function getAlumniProfileById($id){
        $alumni = $this->profileModel->getAlumniProfile($id);
        if($alumni != null){
            echo json_encode(['success' => true, 'data' => $alumni]);
        }else{
            echo json_encode(['success' => false, 'message' => 'Alumni Profile not found']);
        }
    }

    public function getStudentProfileById($id){
        $student = $this->profileModel->getStudentProfile($id);
        if($student != null){
            echo json_encode(['success' => true, 'data' => $student]);
        }else{
            echo json_encode(['success' => false, 'message' => 'Student Profile not found']);
        }
    }

    public function updateAlumniProfile($id){
        $data = $this->getRequest('POST');

        if (empty($data)) {
            return;
        }

        $alumniData = [
            'name' => $this->requestInput('alumniName'),
            'email' => $this->requestInput('alumniEmail'),
            'graduationYear' => $this->requestInput('alumniGraduationYear'),
            'degree' => $this->requestInput('alumniDegree'),
            'occupation' => $this->requestInput('alumniOccupation'),
            'contact' => $this->requestInput('alumniContact'),
            'password' => $this->requestInput('alumniPassword'),
        ];

        $alumni = new Alumni(
            $alumniData['name'],
            $alumniData['email'],
            $alumniData['password'],
            $alumniData['graduationYear'],
            $alumniData['degree'],
            $alumniData['occupation'],
            $alumniData['contact']
        );

        $result = $this->profileModel->updateAlumniProfile($alumni, $id, $this->getSession('login_id'));
        if ($result === true) {
            echo json_encode(['success' => true, 'message' => 'Profile Updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => $result]);
        }
        exit;
    }

    public function updateStudentProfile($id){
        $data = $this->getRequest('POST');

        if (empty($data)) {
            return;
        }

        $studentData = [
            'name' => $this->requestInput('studentName'),
            'email' => $this->requestInput('studentEmail'),
            'course' => $this->requestInput('studentCurrentCourse'),
            'yearOfStudy' => $this->requestInput('studentYearOfStudy'),
            'interests' => $this->requestInput('studentInterests'),
            'password' => $this->requestInput('studentPassword'),
        ];

        $student = new Student(
            $studentData['name'],
            $studentData['email'],
            $studentData['password'],
            $studentData['course'],
            $studentData['yearOfStudy'],
            $studentData['interests']
        );

        $result = $this->profileModel->updateStudentProfile($student, $id, $this->getSession('login_id'));
        if ($result === true) {
            echo json_encode(['success' => true, 'message' => 'Profile Updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => $result]);
        }
        exit;
    }
}