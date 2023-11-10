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
        'date',
        'country',
        'user_id',
        'comments'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id'); 
    }
}