<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response) {
    $response = $this->view->render($response, "home.php", ['router' => $this->router]);
    return $response;
})->setName('home');

$app->group('/projects', function () {
    $this->get('', function (Request $request, Response $response, $args) {
        $msg = $this->flash->getMessages();
        $projects = $this->timetracker->getProjectList();
        $response = $this->view->render($response, "listproject.php", [
            'projects' => $projects,
            'router' => $this->router,
            'msg' => $msg
        ]);
        return $response;
    })->setName('projects');

    $this->map(['GET', 'DELETE', 'PUT'], '/{id:[0-9]+}', function (Request $request, Response $response, $args) {
        $uri = $request->getUri();
        // Find, delete or update project identified by $args['id']
        if ($request->isPut()) {
            $body = $request->getParsedBody();
            $title = trim($body['title']);
            $cat_id = trim($body['category_id']);
            if(empty($title) || empty($cat_id)) {
                // Set flash message for next request
                $this->flash->addMessage('empty', 'Empty field');
                return $response->withStatus(200)->withHeader('Location', $uri);
            } else {
                $cleanTitle = filter_var($title, FILTER_SANITIZE_STRING);
                $cleanCatId = filter_var($cat_id, FILTER_SANITIZE_NUMBER_INT);
                $this->timetracker->updateProject($args['id'], $cleanTitle, $cleanCatId);
                // Set flash message for next request
                $this->flash->addMessage('ok', 'Project saved');
                // Redirect
                return $response->withStatus(200)->withHeader('Location', $this->router->pathFor('projects'));
            }

        } elseif ($request->isDelete()) {
            $this->timetracker->deleteProject($args['id']);
            // Set flash message for next request
            $this->flash->addMessage('ok', 'Project deleted');
            // Redirect
            return $response->withStatus(200)->withHeader('Location', $this->router->pathFor('projects'));
        } else {
            $project = $this->timetracker->getProject($args['id']);
        }
        $categories = $this->timetracker->getCategoryList();
        $msg = $this->flash->getMessages();
        $response = $this->view->render($response, "project.php", [
            'project' => $project,
            'categories' => $categories,
            'router' => $this->router,
            'msg' => $msg
        ]);
        return $response;
    })->setName('project');

    $this->map(['GET', 'POST'], '/new', function (Request $request, Response $response, $args) {
        if ($request->isPost()) {
            $body = $request->getParsedBody();
            $title = trim($body['title']);
            $cat_id = trim($body['category_id']);
            $uri = $request->getUri();
            if(empty($title) || empty($cat_id)) {
                // Set flash message for next request
                $this->flash->addMessage('empty', 'Empty field');
                return $response->withStatus(200)->withHeader('Location', $uri);
            } else {
                $cleanTitle = filter_var($title, FILTER_SANITIZE_STRING);
                $cleanCatId = filter_var($cat_id, FILTER_SANITIZE_NUMBER_INT);
                $this->timetracker->addProject($title, $cleanCatId);
                // Set flash message for next request
                $this->flash->addMessage('ok', 'Added new Project');
                // Redirect
                return $response->withStatus(200)->withHeader('Location', $this->router->pathFor('projects'));
            }

        }
        $categories = $this->timetracker->getCategoryList();
        $msg = $this->flash->getMessages();
        $response = $this->view->render($response, "project.php", [
            'router' => $this->router,
            'categories'=> $categories,
            'msg' => $msg
        ]);
        return $response;
    })->setName('newproject');
});
