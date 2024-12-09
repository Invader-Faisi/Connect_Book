<?php

namespace App\Controllers;

use core\Controller;

class AdminController extends Controller
{
    public function index(){
        $this->page();
    }

    public function page() {
        // Get the requested page from the URL, default to 'pages/main'
        $page = isset($_GET['page']) ? $this->requestInput('page') : 'admin-components/home';

        // Split the page into directory and file
        $pageParts = explode('/', $page);
        $directory = isset($pageParts[0]) ? $pageParts[0] : 'pages';
        $file = isset($pageParts[1]) ? $pageParts[1] : 'main';

        $allowedDirectories = ['admin-components'];
        $allowedPages = ['home', 'event', 'job', 'news'];

        if (!in_array($directory, $allowedDirectories) || !in_array($file, $allowedPages)) {
            $directory = 'admin-components';
            $file = 'main';
        }
        $viewPath = $directory . '/' . $file;
        $this->view('admin', ['page' => $viewPath]);
    }

}