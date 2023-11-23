<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MracAracDownloadHistory extends Model
{
    use HasFactory;
    protected $table = 'mrac_arac_download_history';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'mrac_arac_id', 'user_id',
    ];

    public function mracArac()
    {
        return $this->belongsTo(MracArac::class, 'mrac_arac_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
