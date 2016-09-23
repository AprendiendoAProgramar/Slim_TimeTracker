<?php

/**
 *
 */
class TimeTracker
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getProjectList()
    {
        $sql = 'SELECT * FROM projects';
        $results = $this->db->prepare($sql);
        $results->execute();
        return $results->fetchAll();
    }

    public function getProject($id)
    {
        $sql = 'SELECT * FROM projects WHERE project_id = ?';
        $results = $this->db->prepare($sql);
        $results->bindValue(1, $id, PDO::PARAM_INT);
        $results->execute();
        return $results->fetch();
    }

    public function addProject($title, $category = 1)
    {
        $sql = 'INSERT INTO projects (title, category_id) VALUES (?, ?)';
        $results = $this->db->prepare($sql);
        $results->bindValue(1, $title, PDO::PARAM_STR);
        $results->bindValue(2, $category, PDO::PARAM_INT);
        $results->execute();
    }

    public function updateProject($title, $category = 1)
    {
        $sql = 'INSERT INTO projects (title, category_id) VALUES (?, ?)';
        $results = $this->db->prepare($sql);
        $results->bindValue(1, $title, PDO::PARAM_STR);
        $results->bindValue(2, $category, PDO::PARAM_INT);
        $results->execute();
    }

    public function deleteProject($id)
    {
        $sql = 'DELETE FROM projects WHERE project_id = ?';
        $results = $this->db->prepare($sql);
        $results->bindValue(1, $id, PDO::PARAM_INT);
        $results->execute();
    }
}
