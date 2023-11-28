<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'title', 'message' , 'location', 'schedule_start', 'schedule_end', 'schedule_status', 'type', 'status'
    ];
}
