<?php
// Start PHP session
session_start(); //by default requires session storage

//require '../vendor/autoload.php';
require __DIR__ . '/../vendor/autoload.php';

spl_autoload_register(function ($classname) {
    $file = str_replace('\\', '/', $classname);
    //require '../' . $file . '.php';
    require __DIR__ . '/../' . $file . '.php';
});

// Add config settings and instantiate the App
$settings = require __DIR__ . '/../src/settings.php';
$app =  new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register routes
require __DIR__ . '/../src/routes.php';

$app->run();
