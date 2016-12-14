<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectModel extends Model
{
    protected $table = 'projects';
    protected $primaryKey = 'project_id';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'category_id'
    ];
}
