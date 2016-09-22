<?php
//require '../vendor/autoload.php';
require __DIR__ . '/../vendor/autoload.php';

spl_autoload_register(function ($classname) {
    //require ('../src/models/' . $classname . '.php');
    require (__DIR__ . '/../src/models/' . $classname . '.php');
});

// Add config settings and instantiate the App
$settings = require __DIR__ . '/../src/settings.php';
$app =  new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register routes
require __DIR__ . '/../src/routes.php';

$app->run();
