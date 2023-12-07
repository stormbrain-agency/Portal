<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationMail extends Model
{
    use HasFactory;

    protected $table = 'notification_mails';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'name_form', 'subject' , 'body', 'button_title'
    ];
}
