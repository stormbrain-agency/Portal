<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class W9Upload extends Model
{
    use HasFactory;
    protected $table = 'w9_upload';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'w9_county_fips',
        'user_id',
        'comments',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id'); 
    }

    public function county()
    {
        return $this->belongsTo(County::class, 'w9_county_fips', 'county_fips');
    }
}