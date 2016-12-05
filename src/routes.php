<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response) {
    $response = $this->view->render($response, "home.php", ['router' => $this->router]);
    return $response;
})->setName('home');

$app->group('/projects', function () {
    $this->get('', 'ProjectController:getProjects')->setName('projects');
    $this->get('/{id:[0-9]+}', 'ProjectController:getProject')->setName('project');
    $this->put('/{id:[0-9]+}', 'ProjectController:updateProject');
    $this->delete('/{id:[0-9]+}', 'ProjectController:deleteProject');
    $this->get('/new', 'ProjectController:newProject')->setName('newproject');
    $this->post('/new', 'ProjectController:addProject');
});

$app->group('/tasks', function () {
    $this->get('', 'TaskController:getTasks')->setName('tasks');
    $this->get('/{id:[0-9]+}', 'TaskController:getTask')->setName('task');
    $this->put('/{id:[0-9]+}', 'TaskController:updateTask');
    $this->delete('/{id:[0-9]+}', 'TaskController:deleteTask');
    $this->get('/new', 'TaskController:newTask')->setName('newtask');
    $this->post('/new', 'TaskController:addTask');
});
