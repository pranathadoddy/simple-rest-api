<?php

header('Content-Type: application/json');

spl_autoload_register(function ($class) {
    $file = __DIR__ . '/../core/' . strtolower($class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

$router = new Router();
$router->addRoute('GET', '/student/', function() {
    echo json_encode(['message' => 'List of students']);
});