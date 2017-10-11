<?php
namespace App\Controllers;

use App\Models\ProjectModel as ProjectM;
use App\Models\CategoryModel as CatM;
use Respect\Validation\Validator as v;

class ProjectController extends Controller
{
    public function getProjects($request, $response, $args)
    {
        $msg = $this->flash->getMessages();
        $projects = ProjectM::orderBy('project_id', 'asc')->get();
        $response = $this->view->render($response, "listproject.php", [
            'projects' => $projects,
            'router' => $this->router,
            'msg' => $msg
        ]);
        return $response;
    }

    public function getNewProject($request, $response, $args)
    {
        $categories = CatM::orderBy('title', 'asc')->get();
        $msg = $this->flash->getMessages();
        $response = $this->view->render($response, "project.php", [
            'router' => $this->router,
            'categories'=> $categories,
            'msg' => $msg
        ]);
        return $response;
    }

    public function postProject($request, $response, $args)
    {
        $validation = $this->validator->validate($request, [
            'title' => v::notEmpty()->alnum(),
            'category_id' => v::notEmpty()
        ]);
        
        if($validation->failed()) {
            $uri = $request->getUri();
            // Set flash message for next request    
            $this->flash->addMessage('error', 'Something wrong!');
            return $response->withStatus(200)->withHeader('Location', $uri);
        } else {
            $body = $request->getParsedBody();
            ProjectM::create([
                'title' => $body['title'],
                'category_id' => $body['category_id']
            ]);
            // Set flash message for next request
            $this->flash->addMessage('info', 'Added new Project');
            // Redirect
            return $response->withStatus(200)->withHeader('Location', $this->router->pathFor('projects'));
        }
    }

    public function getProject($request, $response, $args)
    {
        $project = ProjectM::find($args['id']);
        $categories = CatM::orderBy('title', 'asc')->get();
        $msg = $this->flash->getMessages();
        $response = $this->view->render($response, "project.php", [
            'project' => $project,
            'categories' => $categories,
            'router' => $this->router,
            'msg' => $msg
        ]);
        return $response;
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
            ProjectM::where('project_id', $args['id'])->update([
                'title' => $cleanTitle,
                'category_id' => $cleanCatId
            ]);
            // Set flash message for next request
            $this->flash->addMessage('ok', 'Project saved');
            // Redirect
            return $response->withStatus(200)->withHeader('Location', $this->router->pathFor('projects'));
        }
    }

    public function deleteProject($request, $response, $args)
    {
        ProjectM::find($args['id'])->delete();
        // Set flash message for next request
        $this->flash->addMessage('ok', 'Project deleted');
        // Redirect
        return $response->withStatus(200)->withHeader('Location', $this->router->pathFor('projects'));
    }
}
