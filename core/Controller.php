<?php
namespace core;

class Controller {
    /**
     * @throws \Exception
     */
    public function model($model) {
        $modelPath = '../app/models/' . $model . '.php';
        if (file_exists($modelPath)) {
            require_once $modelPath;
            $modelClass = 'app\\models\\' . $model;
            return new $modelClass();
        } else {
            throw new \Exception("Model file not found: " . $modelPath);
        }
    }

    public function view($view, $data = null, $message = null) {
        require_once '../app/views/' . $view . '.php';
    }

    public function getRequest($method) {
        if (strtoupper($method) === 'POST') {
            return $_POST;
        }
        elseif (strtoupper($method) === 'GET') {
            return $_GET;
        }
        return [];
    }

    public function requestInput($inputName){
        if($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == 'post'){
            return trim(strip_tags($_POST[$inputName]));
        } else if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'get'){
            return trim(strip_tags($_GET[$inputName]));
        }
        return null;
    }

    public function setSession($sessionName, $sessionValue){
        if(!empty($sessionName) && !empty($sessionValue)){
            $_SESSION[$sessionName] = $sessionValue;
        }

    }

    public function getSession($sessionName){
        if(!empty($sessionName)){
            return $_SESSION[$sessionName];
        }

    }

    public function unSetSession($sessionName){
        if(!empty($sessionName)){
            unset($_SESSION[$sessionName]);
        }

    }

    public function destroySession(){
        session_destroy();
    }
}
