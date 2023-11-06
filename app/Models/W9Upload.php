<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class W9Upload extends Model
{
    protected $table = 'files';

    protected $fillable = [
        'user_name', 'file_name','comment',
    ];
}