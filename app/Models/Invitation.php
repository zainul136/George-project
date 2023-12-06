<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;
    protected $fillable = ['project_id', 'contractor_id', 'invited_by', 'price', 'message', 'status'];
    // Define the relationship with Contractor
    public function contractor()
    {
        return $this->hasOne(User::class, 'id', 'contractor_id');
    }

    // Define the relationship with InvitedBy
    public function invitedBy()
    {
        return $this->hasOne(User::class, 'id', 'invited_by');
    }

    // Define the relationship with Project
    public function project()
    {
        return $this->hasOne(Project::class, 'project_id', 'project_id');
    }
}
