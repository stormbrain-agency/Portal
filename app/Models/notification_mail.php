<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notification_mail extends Model
{
    use HasFactory;
    protected $table = 'notification_mails';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'title',
        'body',
    ];

    public function save(){

    }
}
