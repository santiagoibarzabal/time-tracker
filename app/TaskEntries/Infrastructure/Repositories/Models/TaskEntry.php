<?php

namespace App\TaskEntries\Infrastructure\Repositories\Models;

use Illuminate\Database\Eloquent\Model;

class TaskEntry extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task_id',
        'started_at',
        'stopped_at',
    ];
}
