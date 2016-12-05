<?php
namespace Src\Models;

use PDO;

class ProjectModel extends Model
{
    public function getProjectList()
    {
        $sql = 'SELECT * FROM projects ORDER BY project_id';
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

    public function addProject($title, $cat_id)
    {
        $sql = 'INSERT INTO projects (title, category_id) VALUES (?, ?)';
        $results = $this->db->prepare($sql);
        $results->bindValue(1, $title, PDO::PARAM_STR);
        $results->bindValue(2, $cat_id, PDO::PARAM_INT);
        $results->execute();
    }

    public function updateProject($id, $title, $cat_id)
    {
        $sql = 'UPDATE projects SET title = ?, category_id = ? WHERE project_id = ?';
        $results = $this->db->prepare($sql);
        $results->bindValue(1, $title, PDO::PARAM_STR);
        $results->bindValue(2, $cat_id, PDO::PARAM_INT);
        $results->bindValue(3, $id, PDO::PARAM_INT);
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
