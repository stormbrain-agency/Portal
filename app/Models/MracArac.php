<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MracArac extends Model
{
    use HasFactory;
    protected $table = 'mrac_arac';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'county_fips', 'user_id', 'month_year','comments', 'document_path'
    ];

    public function county()
    {
        return $this->belongsTo(County::class, 'county_fips', 'county_fips');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mracAracFiles()
    {
        return $this->hasMany(MracAracFiles::class, 'mrac_arac_id', 'id');
    }

  
}
