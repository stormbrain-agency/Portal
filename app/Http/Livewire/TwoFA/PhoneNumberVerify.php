<?php

namespace App\Http\Livewire\TwoFA;

use App\Models\User;
use Livewire\Component;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Auth;

class PhoneNumberVerify extends Component
{
    public $error;

    protected $listeners = [
        'submit_code' => 'verifyCode',
    ];
    
    public function mount()
    {
        // dd('mount');
        $this->sendCode();
    }

    public function sendCode()
    {
        try {
            $mobile_phone_send = "+1".str_replace('-', '', Auth::user()->mobile_phone);
            $twilio = $this->connect();
            $verification = $twilio->verify
                ->v2
                ->services(getenv("TWILIO_VERIFICATION_SID"))
                ->verifications
                ->create($mobile_phone_send, "sms");
            if ($verification->status === "pending") {
                session()->flash('message',  $mobile_phone_send );
            }
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    

    public function verifyCode($code)
    {
        // dd($code);
        $mobile_phone_send = "+1".str_replace('-', '', Auth::user()->mobile_phone);
        
        $twilio = $this->connect();
        try {
            $check_code = $twilio->verify
                ->v2
                ->services(getenv('TWILIO_VERIFICATION_SID'))
                ->verificationChecks
                ->create([
                    "to" => $mobile_phone_send,
                    "code" => $code
                ]);
    
                if ($check_code->valid === true) {
                    User::where('id', Auth::user()->id)
                        ->update([
                            'phone_verified' => $check_code->valid
                        ]);
                    return redirect(route('dashboard'));
                }  else {
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