<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../init.php';

spl_autoload_register(function ($class) {
    $prefixes = [
        'core\\' => __DIR__ . '/../core/',
        'App\\Controllers\\' => __DIR__ . '/../app/controllers/',
        'App\\Models\\' => __DIR__ . '/../app/models/',
        'App\\Core\\Classes\\' => __DIR__ . '/../core/classes/'
    ];

    foreach ($prefixes as $prefix => $base_dir) {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) === 0) {
            $relative_class = substr($class, $len);
            $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

            if (file_exists($file)) {
                require $file;
                return;
            } else {
                echo "File not found: $file\n"; // Debug output
            }
        }
    }
});


use core\App;

$app = new App();
