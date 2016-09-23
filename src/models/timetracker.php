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
        return $results->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProject($id)
    {
        $sql = 'SELECT * FROM projects WHERE project_id = ?';
        $results = $this->db->prepare($sql);
        $results->bindValue(1, $id, PDO::PARAM_INT);
        $results->execute();
        return $results->fetch();
    }
}
