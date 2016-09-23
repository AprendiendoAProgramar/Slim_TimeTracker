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
        // Find, delete or update project identified by $args['id']
        if ($request->isPut()) {
            $this->timetracker->updateProject($args['id']);
        } elseif ($request->isDelete()) {
            $this->timetracker->deleteProject($args['id']);
        } else {
            $project = $this->timetracker->getProject($args['id']);
        }
        $response = $this->view->render($response, "project.php", [
            'project' => $project,
            'router' => $this->router
        ]);
        return $response;
    })->setName('project');

    $this->map(['GET', 'POST'], '/new', function (Request $request, Response $response, $args) {
        if ($request->isPost()) {
            $body = $this->request->getParsedBody();
            $title = $body['title'];
            $cat_id = $body['category_id'];
            if(!empty($title)) {
                $cleanTitle = filter_var($title, FILTER_SANITIZE_STRING);
                $cleanCatId = filter_var($cat_id, FILTER_SANITIZE_NUMBER_INT);
                $this->timetracker->addProject($title, $cleanCatId);
            } else {
                echo "Empty field";
            }

        }
        $response = $this->view->render($response, "project.php", ['router' => $this->router]);
        return $response;
    })->setName('newproject');
});
