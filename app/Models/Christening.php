<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Christening extends Model
{
    use HasFactory;
    protected $fillable = ['c_project_id', 'c_date', 'c_location', 'c_church', 'c_church_time', 'c_reception', 'c_reception_time', 'c_baby_name', 'c_baby_dob', 'c_mother_name', 'c_mother_phone', 'c_father_name', 'c_father_phone', 'c_email', 'c_zomato_baby', 'c_zomato_baby_time', 'c_details', 'c_status', 'c_code'];
}
