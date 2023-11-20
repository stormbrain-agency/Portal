<?php

namespace App\Http\Livewire\PaymentReport;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\PaymentReport;
use App\Models\PaymentReportFiles;
use App\Models\PaymentReportDownloadHistory;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
class ViewPaymentReport extends Component
{
    use WithFileUploads; 

    public $month;
    public $payment_id;
    public $year;
    public $comment;
    public $monthYear;
    public $user_id;
    public $user_name;
    public $user_email;
    public $payment_report_files = [];
    public $download_history = [];
    public $county_full;
    public $created_at;

    protected $listeners = [
        'view_payment' => 'viewPaymentReport',
        'triggerDownloadAllFiles' => 'downloadAllFiles',
    ];
    

    public function render()
    {
        return view('livewire.payment-report.view-payment-report');
    }

    public function viewPaymentReport($id){
        $payment_report = PaymentReport::find($id);

        if (isset($payment_report)) {
            $this->payment_id = $payment_report->id;
            $this->monthYear = $payment_report->getFullDateAttribute();
            $this->comment = $payment_report->comments;
            $this->year = $payment_report->year;
            $this->user_name = $payment_report->user->first_name . ' ' . $payment_report->user->last_name;
            $this->user_id = $payment_report->user->id;
            $this->user_email = $payment_report->user->email;
            $this->county_full = $payment_report->county->county_full;
            $this->created_at = $payment_report->created_at;

            $this->payment_report_files = PaymentReportFiles::where("payment_report_id", $id)->get();
            $this->download_history = PaymentReportDownloadHistory::where("payment_report_id", $id)->get();
        }
    }

    public function downloadAllFiles()
    {
        $user_id = Auth::id();

        if ($user_id) {
            PaymentReportDownloadHistory::create([
                'payment_report_id' => $this->payment_id,
                'user_id' => $user_id,
            ]);

            $payment_report_files = PaymentReportFiles::where("payment_report_id", $this->payment_id)->get();

            if ($payment_report_files->isNotEmpty()) {
                $downloadUrls = [];

                foreach ($payment_report_files as $payment_report_file) {
                    $filename = $payment_report_file->file_path;
                    $file = storage_path('app/uploads/payment_reports/' . $filename);

                    if (file_exists($file)) {
                        // $downloadUrls[] = $file;
                        $downloadUrls [] = route('county-provider-payment-report.download', ['filename' => $filename]);
                        // $downloadUrls[] = route('county-provider-payment-report.download', ['filename' => $filename]);
                        // $downloadUrls[] = '/county-provider-payment-report/download/' . $payment_report_file->id;
                    }
                }

                if (!empty($downloadUrls)) {
                    $this->emit('downloadAllFiles', $downloadUrls);
                    // $this->emiEt('success', __('Payment report submitted successfully.'));
                }
            } else {
                session()->flash('error', 'No files to download.');
            }
        } else {
            session()->flash('error', 'User not logged in.');
        }
    }

}
