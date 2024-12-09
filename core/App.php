<?php
namespace core;

class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();
       // echo 'Parsed URL: ';
        //var_dump($url); // Debug output

        $controllerName = !empty($url) ? ucfirst($url[0]) . 'Controller' : $this->controller;
        $controllerFile = '../app/controllers/' . $controllerName . '.php';
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controllerClass = 'app\\controllers\\' . $controllerName;
            $this->controller = new $controllerClass;
            unset($url[0]);
        } else {
            echo "Controller file not found: $controllerFile\n"; // Debug output
        }

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
