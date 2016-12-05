<?php
namespace App\Controllers;

class TaskController extends Controller
{
    public function getTasks($request, $response, $args)
    {
        $msg = $this->flash->getMessages();
        $tasks = $this->TaskModel->getTaskList();
        $response = $this->view->render($response, "listtask.php", [
            'tasks' => $tasks,
            'router' => $this->router,
            'msg' => $msg
        ]);
        return $response;
    }

    public function newTask($request, $response, $args)
    {
        $projects = $this->ProjectModel->getProjectList();
        $msg = $this->flash->getMessages();
        $response = $this->view->render($response, "task.php", [
            'router' => $this->router,
            'projects'=> $projects,
            'msg' => $msg
        ]);
        return $response;
    }

    public function getTask($request, $response, $args)
    {
        $task = $this->TaskModel->getTask($args['id']);
        $projects = $this->ProjectModel->getProjectList();
        $msg = $this->flash->getMessages();
        $response = $this->view->render($response, "task.php", [
            'task' => $task,
            'projects' => $projects,
            'router' => $this->router,
            'msg' => $msg
        ]);
        return $response;
    }

    public function addTask($request, $response, $args)
    {
        $body = $request->getParsedBody();
        $title = trim($body['title']);
        $date = trim($body['date']);
        $time = trim($body['time']);
        $notes = trim($body['notes']);
        $project_id = trim($body['project_id']);
        $uri = $request->getUri();

        if(empty($title) || empty($date) || empty($time) || empty($project_id)) {
            // Set flash message for next request
            $this->flash->addMessage('empty', 'Empty field');
            return $response->withStatus(200)->withHeader('Location', $uri);
        } else {
            $cleanTitle = filter_var($title, FILTER_SANITIZE_STRING);
            $cleanDate = filter_var($date);
            $cleanTime = filter_var($time);
            $cleanNotes = filter_var($notes, FILTER_SANITIZE_STRING);
            $cleanProjectId = filter_var($project_id, FILTER_SANITIZE_NUMBER_INT);
            $this->TaskModel->addTask($cleanTitle, $cleanDate, $cleanTime, $cleanNotes, $cleanProjectId);
            // Set flash message for next request
            $this->flash->addMessage('ok', 'Added new Task');
            // Redirect
            return $response->withStatus(200)->withHeader('Location', $this->router->pathFor('tasks'));
        }
    }

    public function updateTask($request, $response, $args)
    {
        $body = $request->getParsedBody();
        $title = trim($body['title']);
        $date = trim($body['date']);
        $time = trim($body['time']);
        $notes = trim($body['notes']);
        $project_id = trim($body['project_id']);
        if(empty($title) || empty($date) || empty($time) || empty($project_id)) {
            // Set flash message for next request
            $this->flash->addMessage('empty', 'Empty field');
            return $response->withStatus(200)->withHeader('Location', $uri);
        } else {
            $cleanTitle = filter_var($title, FILTER_SANITIZE_STRING);
            $cleanDate = filter_var($date);
            $cleanTime = filter_var($time);
            $cleanNotes = filter_var($notes, FILTER_SANITIZE_STRING);
            $cleanProjectId = filter_var($project_id, FILTER_SANITIZE_NUMBER_INT);
            $this->TaskModel->updateTask($args['id'], $cleanTitle, $cleanDate, $cleanTime, $cleanNotes, $cleanProjectId);
            // Set flash message for next request
            $this->flash->addMessage('ok', 'Tasks saved');
            // Redirect
            return $response->withStatus(200)->withHeader('Location', $this->router->pathFor('tasks'));
        }
    }

    public function deleteTask($request, $response, $args)
    {
        $this->TaskModel->deleteTask($args['id']);
        // Set flash message for next request
        $this->flash->addMessage('ok', 'Task deleted');
        // Redirect
        return $response->withStatus(200)->withHeader('Location', $this->router->pathFor('tasks'));
    }
}
