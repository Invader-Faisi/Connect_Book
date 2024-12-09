<?php
namespace App\Controllers;


use App\Core\Classes\Alumni;
use App\Core\Classes\Student;
use core\Controller;
class HomeController extends Controller {
    /**
     * @var mixed
     */
    private $userModel;

    /**
     * @throws \Exception
     */

    public function __construct() {
        $this->userModel = $this->model('UserModel');
    }
    public function index() {
        $this->view('home');
    }

    public function admin(){
        $this->view('admin');
    }

    public function register() {
        $data = $this->getRequest('POST');

        if (empty($data)) {
            return;
        }

        $userType = $this->requestInput('user');
        if (!empty($userType)) {
            if ($userType == 'Alumni') {
                $this->registerAlumni();
            } else {
                $this->registerStudent();
            }
        }
    }

    private function registerAlumni() {
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

        $result = $this->userModel->saveAlumni($alumni);
        if ($result === true) {
            echo json_encode(['success' => true, 'message' => 'Registered successfully. Continue to login.']);
        } else {
            echo json_encode(['success' => false, 'message' => $result]);
        }
        exit;
    }

    private function registerStudent() {
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

        $result = $this->userModel->saveStudent($student);
        if ($result === true) {
            echo json_encode(['success' => true, 'message' => 'Registered successfully. Continue to login.']);
        } else {
            echo json_encode(['success' => false, 'message' => $result]);
        }
        exit;
    }

    public function login() {
        $data = $this->getRequest('POST');
        if (empty($data)) {
            echo json_encode(['error' => false, 'message' => 'All fields are required.']);
        }

        $email = $this->requestInput('email');
        $password =  $this->requestInput('password');

        $result = $this->userModel->selectWhere('users', ['email' => $email]);
        if(empty($result)){
            echo json_encode(['error' => true, 'message' => 'Invalid email or password.']);
            exit;
        }
        $user = $result[0];
        if(password_verify($password, $user['password'])){
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $this->setSession('login_id',$user['id']);
            $this->setSession('user_name', $user['name']);
            $this->setSession('user_email', $user['email']);
            $this->setSession('user_type', $user['userType']);

            if($user['userType'] == 'Alumni'){
                $this->setSession('user_id', $this->userModel->getUserId('alumni',$user['email']));
            }
            if($user['userType'] == 'Student'){
                $this->setSession('user_id', $this->userModel->getUserId('students',$user['email']));
            }

            if($user['userType'] == 'Admin'){
                $this->setSession('user_id', $user['id']);
            }

            echo json_encode(['success' => true, 'user' => $user['userType']]);
        }else {
            echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
        }
        exit;

    }

    public function logout(){
        $this->unsetSession('user_id');
        $this->unsetSession('user_name');
        $this->unsetSession('user_email');
        $this->destroySession();
        header('Location: ' . BASE_URL);
        exit;
    }

    public function getAlumniRewards($id){
        $result = $this->userModel->getAlumniRewards($id);
        if($result != null){
            echo json_encode(['success' => true, 'data' => $result]);
        }else{
            echo json_encode(['success' => false, 'message' => '']);
        }
        exit;
    }



    public function main() {
        // Get the requested page from the URL, default to 'pages/main'
        $page = isset($_GET['page']) ? $this->requestInput('page') : 'pages/main';

        // Split the page into directory and file
        $pageParts = explode('/', $page);
        $directory = isset($pageParts[0]) ? $pageParts[0] : 'pages';
        $file = isset($pageParts[1]) ? $pageParts[1] : 'main';

        $allowedDirectories = ['pages'];
        $allowedPages = ['main', 'profile', 'job-internship', 'mentorship', 'events', 'news'];

        if (!in_array($directory, $allowedDirectories) || !in_array($file, $allowedPages)) {
            $directory = 'pages';
            $file = 'main';
        }
        $viewPath = $directory . '/' . $file;
        $this->view('layout', ['page' => $viewPath]);
    }



}
