<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'action',
        'action_date',
        'status',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function project()
    {
        return $this->hasOne(Project::class, 'project_id', 'project_id');
    }
}
