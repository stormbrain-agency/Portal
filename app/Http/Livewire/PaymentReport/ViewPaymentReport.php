<?php

namespace App\Http\Livewire\PaymentReport;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\PaymentReport;
use App\Models\User;
use App\Models\PaymentReportFiles;
use App\Models\PaymentReportDownloadHistory;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
class ViewPaymentReport extends Component
{
    use WithFileUploads; 

    public $payment_id;
    public $year;
    public $comment;
    public $month_year;
    public $user_id;
    public $user_name;
    public $user_download_role;
    public $user_email;
    public $payment_report_files = [];
    public $download_history = [];
    public $county_full;
    public $created_at;

    protected $listeners = [
        'view_payment' => 'viewPaymentReport',
        'triggerDownloadAllFiles' => 'downloadAllFiles',
        'triggerDownloadAllFilesBtn' => 'downloadAllFilesBtn',
    ];
    

    public function render()
    {
        return view('livewire.payment-report.view-payment-report');
    }

    public function viewPaymentReport($id){
        $payment_report = PaymentReport::find($id);

        if (isset($payment_report)) {
            $this->payment_id = $payment_report->id;
            $this->month_year = $payment_report->month_year;
            $this->comment = $payment_report->comments;
            $this->user_name = $payment_report->user->first_name . ' ' . $payment_report->user->last_name;
            $this->user_id = $payment_report->user->id;
            $this->user_email = $payment_report->user->email;
            $this->county_full = $payment_report->county->county;
            $this->created_at = $payment_report->created_at;
    
            $this->payment_report_files = PaymentReportFiles::where("payment_report_id", $id)->get();
            $this->download_history = PaymentReportDownloadHistory::where("payment_report_id", $id)->orderBy('id', 'desc')->get();
        }
    }

    public function downloadAllFiles()
    {
        $user_id = Auth::id();

        if ($user_id) {
            
            $payment_report_files = PaymentReportFiles::where("payment_report_id", $this->payment_id)->get();
            
            if ($payment_report_files->isNotEmpty()) {
                $downloadUrls = [];

                foreach ($payment_report_files as $payment_report_file) {
                    $filename = $payment_report_file->file_path;
                    $file = storage_path('app/uploads/payment_reports/' . $filename);

                    if (file_exists($file)) {
                        $downloadUrls [] = route('county-provider-payment-report.download', ['filename' => $filename]);
                    }else {
                        $this->emit('error', __('Could not find ' .$filename. ' file to download.'));
                    }
                }

                if (!empty($downloadUrls)) {
                    PaymentReportDownloadHistory::create([
                        'payment_report_id' => $this->payment_id,
                        'user_id' => $user_id,
                    ]);
                    $this->emit('downloadAllFiles', $downloadUrls);
        
                }
            } else {
                $this->emit('error', __('No files to download.'));

            }
        } else {
            $this->emit('error', __('User not logged in.'));

        }
    }

    public function downloadAllFilesBtn($id)
    {
        $user_id = Auth::id();

        if ($user_id) {
            
            $payment_report_files = PaymentReportFiles::where("payment_report_id", $id)->get();
            
            if ($payment_report_files->isNotEmpty()) {
                $downloadUrls = [];

                foreach ($payment_report_files as $payment_report_file) {
                    $filename = $payment_report_file->file_path;
                    $file = storage_path('app/uploads/payment_reports/' . $filename);

                    if (file_exists($file)) {
                        $downloadUrls [] = route('county-provider-payment-report.download', ['filename' => $filename]);
                    }else {
                        $this->emit('error', __('Could not find ' .$filename. ' file to download.'));
                    }
                }

                if (!empty($downloadUrls)) {
                    PaymentReportDownloadHistory::create([
                        'payment_report_id' => $id,
                        'user_id' => $user_id,
                    ]);
                    $this->emit('downloadAllFiles', $downloadUrls);
        
                }
            } else {
                $this->emit('error', __('No files to download.'));

            }
        } else {
            $this->emit('error', __('User not logged in.'));

        }
    }

}
