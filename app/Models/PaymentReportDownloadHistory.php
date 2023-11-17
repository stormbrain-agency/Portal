<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReportDownloadHistory extends Model
{
    use HasFactory;
    protected $table = 'payment_report_download_historyx';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'payment_report_id', 'user_id',
    ];

    public function paymentReport()
    {
        return $this->belongsTo(PaymentReport::class, 'payment_report_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
