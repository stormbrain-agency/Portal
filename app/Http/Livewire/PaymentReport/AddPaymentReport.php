<?php

namespace App\Http\Livewire\PaymentReport;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\PaymentReport;
use App\Models\PaymentReportFiles;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
class AddPaymentReport extends Component
{
    use WithFileUploads; 

    public $month_year;
    public $comment;
    public $payment_report_file = [];

    public function render()
    {
        return view('livewire.payment-report.add-payment-report');
    }

    public function store()
    {
        $this->validate([
            'month_year' => 'required',
            'payment_report_file' => 'required',

        ]);

        // dd($this->payment_report_file);
        $user = Auth::user();
        $countyFips = "";
        if ($user) {
            if (isset($user->county_designation)) {
                $countyFips = $user->county_designation;
            }
        }
        $paymentReport = PaymentReport::create([
            'month_year' => $this->month_year,
            'county_fips' => $countyFips,
            'user_id' => $user->id,
            'comments' => $this->comment,
        ]);

        foreach ($this->payment_report_file as $file) {
            $extension = $file->getClientOriginalExtension();
            $currentDateTime = Carbon::now()->format('Ymd_His');
            $uniqueFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "_$currentDateTime.$extension";
            $path_name = $file->storeAs('uploads/payment_reports', $uniqueFileName);

            PaymentReportFiles::create([
                'payment_report_id' => $paymentReport->id,
                'file_path' => $uniqueFileName,
            ]);
        }


        $this->reset();

        $this->emit('success', __('Payment report submitted successfully.'));
    }

}
