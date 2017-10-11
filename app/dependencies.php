<?php
$container = $app->getContainer();

// Service factory for the ORM
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};

$container['view'] = new \Slim\Views\PhpRenderer(__DIR__ . "/../app/views/");

$container['validator'] = new \App\Validation\Validator();

$container['ProjectController'] = new \App\Controllers\ProjectController($container);
$container['TaskController'] = new \App\Controllers\TaskController($container);

$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};
