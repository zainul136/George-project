<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContructorPaymentLog extends Model
{
    use HasFactory;
    protected $fillable = ['contractor_id', 'project_id', 'payment', 'date','remaining_payment', 'payment_type','message'];
}
