<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'price',
        'remaining_price',
        'payment_type',
        'message',
        'date'
    ];
}
