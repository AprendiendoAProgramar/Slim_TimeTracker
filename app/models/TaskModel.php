<?php
namespace App\Models;

use PDO;

class TaskModel extends Model
{
    public function getTaskList()
    {
        $sql = 'SELECT * FROM tasks ORDER BY task_id';
        $results = $this->db->prepare($sql);
        $results->execute();
        return $results->fetchAll();
    }

    public function getTask($id)
    {
        $sql = 'SELECT * FROM tasks WHERE task_id = ?';
        $results = $this->db->prepare($sql);
        $results->bindValue(1, $id, PDO::PARAM_INT);
        $results->execute();
        return $results->fetch();
    }

    public function addTask($title, $date, $time, $notes, $project_id)
    {
        $sql = 'INSERT INTO tasks (title, date, time, notes, project_id) VALUES (?, ?, ?, ?, ?)';
        $results = $this->db->prepare($sql);
        $results->bindValue(1, $title, PDO::PARAM_STR);
        $results->bindValue(2, $date, PDO::PARAM_STR);
        $results->bindValue(3, $time, PDO::PARAM_STR);
        $results->bindValue(4, $notes, PDO::PARAM_STR);
        $results->bindValue(5, $project_id, PDO::PARAM_INT);
        $results->execute();
    }

    public function updateTask($id, $title, $date, $time, $notes, $project_id)
    {
        $sql = 'UPDATE tasks SET title = ?, date = ?, time = ?, notes = ?, project_id = ? WHERE task_id = ?';
        $results = $this->db->prepare($sql);
        $results->bindValue(1, $title, PDO::PARAM_STR);
        $results->bindValue(2, $date, PDO::PARAM_STR);
        $results->bindValue(3, $time, PDO::PARAM_STR);
        $results->bindValue(4, $notes, PDO::PARAM_STR);
        $results->bindValue(5, $project_id, PDO::PARAM_INT);
        $results->bindValue(6, $id, PDO::PARAM_INT);
        $results->execute();
    }

    public function deleteTask($id)
    {
        $sql = 'DELETE FROM tasks WHERE task_id = ?';
        $results = $this->db->prepare($sql);
        $results->bindValue(1, $id, PDO::PARAM_INT);
        $results->execute();
    }
}
