<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class W9DownloadHistory extends Model
{
    use HasFactory;
    protected $table = 'w9_download_history';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'w9_id', 'user_id',
    ];

    public function mracArac()
    {
        return $this->belongsTo(W9Upload::class, 'w9_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
