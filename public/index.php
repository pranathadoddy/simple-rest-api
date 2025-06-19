<?php

header('Content-Type: application/json');

spl_autoload_register(function ($class) {

    $directories = [
        __DIR__ . '/../core/',
        __DIR__ . '/../controller/',
    ];

    foreach ($directories as $directory) {
        $file = $directory . strtolower($class) . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$router = new Router();
$router->addRoute('GET', 
'/api/student/', 
[StudentController::class, 'getAllStudents']);

$router->handleRequest();