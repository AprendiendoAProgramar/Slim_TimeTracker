<?php
namespace Src\Models;

class CategoryModel extends Model
{
    public function getCategoryList()
    {
        $sql = 'SELECT * FROM categories';
        $results = $this->db->prepare($sql);
        $results->execute();
        return $results->fetchAll();
    }
}
