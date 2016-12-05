<?php
// Start PHP session
session_start(); //by default requires session storage

//require '../vendor/autoload.php';
require __DIR__ . '/../vendor/autoload.php';

// Add config settings and instantiate the App
$settings = require __DIR__ . '/../app/settings.php';
$app =  new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../app/dependencies.php';

// Register routes
require __DIR__ . '/../app/routes.php';

$app->run();
