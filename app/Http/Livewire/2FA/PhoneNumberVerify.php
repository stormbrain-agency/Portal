<?php

namespace App\Http\Livewire;

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
        $this->sendCode();
    }

    public function sendCode()
    {
        try {
            $twilio = $this->connect();
            $verification = $twilio->verify
                ->v2
                ->services(getenv("TWILIO_VERIFICATION_SID"))
                ->verifications
                ->create("+country_code".str_replace('-', '', Auth::user()->phone_number), "sms");

            if ($verification->status === "pending") {
                session()->flash('message', 'OTP sent successfully');
            }
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
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
                        "to" => "+country_code" . str_replace('-', '', Auth::user()->phone_number),
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

    public function connect()
    {
        $sid = getenv("TWILIO_ACCOUNT_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);
        return $twilio;
    }

    public function render()
    {
        return view('livewire.phone-number-verify');
    }
}