<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class MRAC extends Model
{
    use HasFactory;
    protected $table = 'mrac';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'mrac_county_fips',
        'user_id',
        'comments',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id'); 
    }

    public function county()
    {
        return $this->belongsTo(County::class, 'mrac_county_fips', 'county_fips');
    }
}