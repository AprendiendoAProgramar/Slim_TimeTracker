<?php
namespace App\Controllers;

use App\Models\TaskModel as TaskM;
use App\Models\ProjectModel as ProjectM;

class TaskController extends Controller
{
    public function getTasks($request, $response, $args)
    {
        $msg = $this->flash->getMessages();
        $tasks = TaskM::orderBy('task_id', 'asc')->get();
        $response = $this->view->render($response, "listtask.php", [
            'tasks' => $tasks,
            'router' => $this->router,
            'msg' => $msg
        ]);
        return $response;
    }

    public function getNewTask($request, $response, $args)
    {
        $projects = ProjectM::orderBy('project_id', 'asc')->get();
        $msg = $this->flash->getMessages();
        $response = $this->view->render($response, "task.php", [
            'router' => $this->router,
            'projects'=> $projects,
            'msg' => $msg
        ]);
        return $response;
    }

    public function postTask($request, $response, $args)
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
            TaskM::create([
                'title' => $cleanTitle,
                'date' => $cleanDate,
                'time' => $cleanTime,
                'notes' => $cleanNotes,
                'project_id' => $cleanProjectId
            ]);
            // Set flash message for next request
            $this->flash->addMessage('ok', 'Added new Task');
            // Redirect
            return $response->withStatus(200)->withHeader('Location', $this->router->pathFor('tasks'));
        }
    }

    public function getTask($request, $response, $args)
    {
        $task = TaskM::find($args['id']);
        $projects = ProjectM::orderBy('project_id', 'asc')->get();
        $msg = $this->flash->getMessages();
        $response = $this->view->render($response, "task.php", [
            'task' => $task,
            'projects' => $projects,
            'router' => $this->router,
            'msg' => $msg
        ]);
        return $response;
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
            TaskM::where('task_id', $args['id'])->update([
                'title' => $cleanTitle,
                'date' => $cleanDate,
                'time' => $cleanTime,
                'notes' => $cleanNotes,
                'project_id' => $cleanProjectId
            ]);
            // Set flash message for next request
            $this->flash->addMessage('ok', 'Tasks saved');
            // Redirect
            return $response->withStatus(200)->withHeader('Location', $this->router->pathFor('tasks'));
        }
    }

    public function deleteTask($request, $response, $args)
    {
        TaskM::find($args['id'])->delete();
        // Set flash message for next request
        $this->flash->addMessage('ok', 'Task deleted');
        // Redirect
        return $response->withStatus(200)->withHeader('Location', $this->router->pathFor('tasks'));
    }
}
