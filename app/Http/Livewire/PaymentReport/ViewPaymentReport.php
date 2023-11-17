<?php

namespace App\Http\Livewire\PaymentReport;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\PaymentReport;
use App\Models\PaymentReportFiles;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
class ViewPaymentReport extends Component
{
    use WithFileUploads; 

    public $month;
    public $year;
    public $comment;
    public $monthYear;
    public $user_id;
    public $user_name;
    public $user_email;
    public $payment_report_files;
    public $county_full;
    public $created_at;

    protected $listeners = [
        'view_payment' => 'viewPaymentReport',
    ];

    public function render()
    {
        return view('livewire.payment-report.view-payment-report');
    }

    public function viewPaymentReport($id){
        $payment_report = PaymentReport::find($id);

        if ($payment_report) {
            $this->monthYear = $payment_report->getFullDateAttribute();
            $this->comment = $payment_report->comments;
            $this->year = $payment_report->year;
            $this->user_name = $payment_report->user->first_name . ' ' . $payment_report->user->last_name;
            $this->user_id = $payment_report->user->id;
            $this->user_email = $payment_report->user->email;
            $this->county_full = $payment_report->county->county_full;
            $this->created_at = $payment_report->created_at;

            $this->payment_report_files = PaymentReportFiles::where("payment_report_id", $id)->get();
            // dd($payment_report_files);
            // $this->payment_report_files = $payment_report->paymentReportFiles();

            // dd($this->payment_report_files);
        }
    }

}
