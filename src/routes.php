<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response) {
    $response = $this->view->render($response, "home.php", ['router' => $this->router]);
    return $response;
})->setName('home');

$app->group('/projects', function () {
    $this->get('', function (Request $request, Response $response, $args) {
        $projects = $this->timetracker->getProjectList();
        $response = $this->view->render($response, "listproject.php", [
            'projects' => $projects,
            'router' => $this->router
        ]);
        return $response;
    })->setName('projects');

    $this->map(['GET', 'DELETE', 'PUT'], '/{id:[0-9]+}', function (Request $request, Response $response, $args) {
        // Find, delete or replace project identified by $args['id']
        $project = $this->timetracker->getProject($args['id']);
        $response = $this->view->render($response, "project.php", [
            'project' => $project,
            'router' => $this->router
        ]);
        return $response;
    })->setName('project');
});
