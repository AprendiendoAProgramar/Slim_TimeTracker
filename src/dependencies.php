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

$container['view'] = new \Slim\Views\PhpRenderer(__DIR__ . "/../src/views/");

$container['ProjectController'] = new \Src\Controllers\ProjectController($container);
$container['TaskController'] = new \Src\Controllers\TaskController($container);
$container['CategoryModel'] = new \Src\Models\CategoryModel($container);
$container['ProjectModel'] = new \Src\Models\ProjectModel($container);
$container['TaskModel'] = new \Src\Models\TaskModel($container);

//Eliminar si todo está correcto
//$container['timetracker'] = function ($c) {
//    return new TimeTracker($c->db);
//};

$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};
