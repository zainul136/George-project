<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingEngagement extends Model
{
    use HasFactory;
    protected $fillable = ['we_project_id', 'we_date', 'we_location', 'we_church', 'we_church_time', 'we_xetetisi', 'we_xetetisi_time', 'we_reception', 'we_reception_time', 'we_groom_name', 'we_groom_phone', 'we_bride_name', 'we_bride_phone', 'we_email', 'we_zomato_groom', 'we_zomato_groom_time', 'we_zomato_groom_home', 'we_zomato_groom_info', 'we_zomato_bride', 'we_zomato_bride_time', 'we_zomato_bride_home', 'we_zomato_bride_info', 'we_details'];
}
