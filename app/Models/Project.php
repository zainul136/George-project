<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['project_id','name', 'cost', 'payment_type', 'project_date', 'employees', 'contractors', 'type', 'client', 'company', 'project_details', 'status', 'code'];

    public function clientName()
    {
        return $this->hasOne(User::class, 'id', 'client');
    }

    public function events()
    {
        return $this->belongsTo(Event::class ,'project_id','id');
    }
}
