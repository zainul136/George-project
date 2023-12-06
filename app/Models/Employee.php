<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = ['employee_id', 'user_id', 'name', 'contact', 'email', 'password', 'company', 'dob', 'description', 'image', 'status', 'code'];
}
