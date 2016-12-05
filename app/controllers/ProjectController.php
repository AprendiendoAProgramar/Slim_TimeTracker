<?php
namespace App\Controllers;

class ProjectController extends Controller
{
    public function getProjects($request, $response, $args)
    {
        $msg = $this->flash->getMessages();
        $projects = $this->ProjectModel->getProjectList();
        $response = $this->view->render($response, "listproject.php", [
            'projects' => $projects,
            'router' => $this->router,
            'msg' => $msg
        ]);
        return $response;
    }

    public function newProject($request, $response, $args)
    {
        $categories = $this->CategoryModel->getCategoryList();
        $msg = $this->flash->getMessages();
        $response = $this->view->render($response, "project.php", [
            'router' => $this->router,
            'categories'=> $categories,
            'msg' => $msg
        ]);
        return $response;
    }

    public function getProject($request, $response, $args)
    {
        $project = $this->ProjectModel->getProject($args['id']);
        $categories = $this->CategoryModel->getCategoryList();
        $msg = $this->flash->getMessages();
        $response = $this->view->render($response, "project.php", [
            'project' => $project,
            'categories' => $categories,
            'router' => $this->router,
            'msg' => $msg
        ]);
        return $response;
    }

    public function addProject($request, $response, $args)
    {
        $body = $request->getParsedBody();
        var_dump($body);
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
            $this->ProjectModel->addProject($cleanTitle, $cleanCatId);
            // Set flash message for next request
            $this->flash->addMessage('ok', 'Added new Project');
            // Redirect
            return $response->withStatus(200)->withHeader('Location', $this->router->pathFor('projects'));
        }
    }

    public function updateProject($request, $response, $args)
    {
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
            $this->ProjectModel->updateProject($args['id'], $cleanTitle, $cleanCatId);
            // Set flash message for next request
            $this->flash->addMessage('ok', 'Project saved');
            // Redirect
            return $response->withStatus(200)->withHeader('Location', $this->router->pathFor('projects'));
        }
    }

    public function deleteProject($request, $response, $args)
    {
        $this->ProjectModel->deleteProject($args['id']);
        // Set flash message for next request
        $this->flash->addMessage('ok', 'Project deleted');
        // Redirect
        return $response->withStatus(200)->withHeader('Location', $this->router->pathFor('projects'));
    }
}
