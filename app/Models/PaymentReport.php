<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReport extends Model
{
    use HasFactory;
    protected $table = 'payment_report';
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

    public function paymentReportFiles()
    {
        return $this->hasMany(PaymentReportFiles::class, 'payment_report_id', 'id');
    }

  
}
