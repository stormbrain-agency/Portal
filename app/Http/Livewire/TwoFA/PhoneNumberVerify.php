<?php

namespace App\Http\Livewire\TwoFA;

use App\Models\User;
use Livewire\Component;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Auth;

class PhoneNumberVerify extends Component
{
    public $code = null;
    public $error;

    public function mount()
    {
        // dd('mount');
        $this->sendCode();
    }

    public function sendCode()
    {
        try {
            // dd('$twilio before connect');
            $twilio = $this->connect();
            // dd('$twilio after connect');
            $verification = $twilio->verify
                ->v2
                ->services(getenv("TWILIO_VERIFICATION_SID"))
                ->verifications
                ->create("+17604520825", "sms");
                // ->create("+17604520825", "sms");
            // dd($verification ,'verification');
            if ($verification->status === "pending") {
                session()->flash('message', 'Enter the verification code we sent to : .... ');
                // dd($verification->status,'pending');
            }
        } catch (\Exception $e) {
            // dd($twilio);
            // $this->error = $e->getMessage();
            session()->flash('error',$e->getMessage());
        }
    }

    public function verifyCode()
    {
        $twilio = $this->connect();
        try {
            $check_code = $twilio->verify
                ->v2
                ->services(getenv('TWILIO_VERIFICATION_SID'))
                ->verificationChecks
                ->create(
                    [
                        // "to" => "+17604520825",
                        "to" => "+17604520825",
                        "code" => $this->code
                    ]
                );

            if ($check_code->valid === true) {
                User::where('id', Auth::user()->id)
                    ->update([
                        'phone_verified' => $check_code->valid
                    ]);
                return redirect(route('dashboard'));
            } else {
                session()->flash('error', 'Verification failed, Invalid code.');
            }
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            session()->flash('error', $this->error);
        }
    }


    //connect working
    public function connect()
    {
        $sid = getenv("TWILIO_ACCOUNT_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);
        // dd($twilio);
        return $twilio;
    }

    public function render()
    {
        // dd('render livewire 2fa');
        return view('livewire.2fa.phone-number-verify');
    }
}