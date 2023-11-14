<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class W9Downloadhistory extends Model
{
    use HasFactory;
    protected $table = 'w9downloadhistory';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'original_name',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id'); 
    }
}