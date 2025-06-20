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

require_once __DIR__ . '/studentStorage.php';

$studentStorage = new StudentStorage();
$router = new Router();
$router->addRoute('GET', 
'/api/student/', 
[StudentController::class, 'getAllStudents', $studentStorage]);
$router->addRoute('POST', 
'/api/student/', 
[StudentController::class, 'createStudent', $studentStorage]);
$router->addRoute('PUT', 
'/api/student/', 
[StudentController::class, 'updateStudent', $studentStorage]);
$router->addRoute('DELETE', 
'/api/student/', 
[StudentController::class, 'deleteStudent', $studentStorage]);

$router->handleRequest();