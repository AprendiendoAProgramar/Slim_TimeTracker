<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'task_id';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'date',
        'time',
        'notes',
        'project_id'
    ];
}
