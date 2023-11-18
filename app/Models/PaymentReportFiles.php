<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReportFiles extends Model
{
    use HasFactory;
    protected $table = 'payment_report_files';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'file_path',
        'payment_report_id'
    ];

    public function paymentReport()
    {
        return $this->belongsTo(PaymentReport::class, 'payment_report_id', 'id');
    }
}
