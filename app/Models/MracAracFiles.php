<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MracAracFiles extends Model
{
    use HasFactory;
    protected $table = 'mrac_arac_files';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'file_path',
        'mrac_arac_id'
    ];

    public function mracArac()
    {
        return $this->belongsTo(MracArac::class, 'mrac_arac_id', 'id');
    }
}
