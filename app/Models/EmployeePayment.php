<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'payment',
        'date',
        'payment_type',
        'message'
    ];
}
