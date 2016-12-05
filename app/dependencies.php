<?php
$container = $app->getContainer();

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $dsn = 'mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'];
    $pdo = new PDO($dsn, $db['user'], $db['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$container['view'] = new \Slim\Views\PhpRenderer(__DIR__ . "/../app/views/");

$container['ProjectController'] = new \App\Controllers\ProjectController($container);
$container['TaskController'] = new \App\Controllers\TaskController($container);
$container['CategoryModel'] = new \App\Models\CategoryModel($container);
$container['ProjectModel'] = new \App\Models\ProjectModel($container);
$container['TaskModel'] = new \App\Models\TaskModel($container);

//Eliminar si todo está correcto
//$container['timetracker'] = function ($c) {
//    return new TimeTracker($c->db);
//};

$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};
