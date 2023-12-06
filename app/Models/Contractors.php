<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractors extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'contact', 'project', 'dob', 'address', 'image', 'status'];
}
