<?php

namespace App\Controllers;

use core\Controller;

class AdminController extends Controller
{
    private $adminModel;
    public function __construct(){
        $this->adminModel = $this->model("AdminModel");
    }
    public function index(){
        $this->page();
    }

    public function page() {
        // Get the requested page from the URL, default to 'admin-components/home'
        $page = isset($_GET['page']) ? $this->requestInput('page') : 'admin-components/home';

        // Split the page into directory and file
        $pageParts = explode('/', $page);
        $directory = isset($pageParts[0]) ? $pageParts[0] : 'pages';
        $file = isset($pageParts[1]) ? $pageParts[1] : 'main';

        $allowedDirectories = ['admin-components'];
        $allowedPages = ['home', 'event', 'job-internship', 'news','discussion', 'alumni-report', 'alumni'];

        if (!in_array($directory, $allowedDirectories) || !in_array($file, $allowedPages)) {
            $directory = 'admin-components';
            $file = 'main';
        }
        $viewPath = $directory . '/' . $file;
        $this->view('admin', ['page' => $viewPath]);
    }

    public function getCounts(){
        $result = $this->adminModel->getCounts();
        if($result != null){
            echo json_encode(['success' => true, 'data' => $result]);
        }else{
            echo json_encode(['success' => false, 'message' => 'Data not found']);
        }
    }

    public function getChartData(){
        $result = $this->adminModel->getChartData();
        if($result != null){
            echo json_encode(['success' => true, 'data' => $result]);
        }else{
            echo json_encode(['success' => false, 'message' => 'Data not found']);
        }
    }

    public function generateReport(){
        $result = $this->adminModel->generateReport();
        if($result != null){
            echo json_encode(['success' => true, 'data' => $result]);
        }else{
            echo json_encode(['success' => false, 'message' => 'Data not found']);
        }
    }

    public function getAlumniRewards(){
        $result = $this->adminModel->getAlumniRewards();
        if($result != null){
            echo json_encode(['success' => true, 'data' => $result]);
        }else {
            echo json_encode(['success' => false, 'message' => 'Data not found']);
        }
    }

}