<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Models\State;
use App\Models\County;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Mail\VerifyEmail;

class AddUserModal extends Component
{
    use WithFileUploads;

    public $first_name;
    public $last_name;
    public $email;
    public $business_phone;
    public $mailing_address;
    public $vendor_id;
    public $county_designation;
    public $w9_file_path;
    public $role;
    public $avatar;
    public $saved_avatar;
    public $idUser;
    public $states;
    public $stateChose;
    public $county;
    public $countyDropdown;
    public $edit_mode = false;
    public $county_require = true;
    public $cdss_county_disable = false;

    protected $rules = [
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
        // 'mobile_phone' => ['required', 'string', 'regex:/^\d{10}$/'],
        'role' => 'required|string',
    ];

    protected $rules_for_county_user = [
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'business_phone' => ['required', 'string', 'max:255'],
        // 'mobile_phone' => ['required', 'string', 'regex:/^\d{10}$/'],
        'mailing_address' => ['required', 'string', 'max:255'],
        'vendor_id' => ['required', 'string', 'max:255'],
        'county_designation' => ['required', 'string', 'max:255'],
        'role' => ['required', 'string'],

    ];

    protected $rules_for_cdss = [
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'business_phone' => ['required', 'string', 'max:255'],
        'mailing_address' => ['required', 'string', 'max:255'],
        'vendor_id' => ['required', 'string', 'max:255'],
        'role' => ['required', 'string'],
    ];

    protected $messages = [
        'mobile_phone.regex' => 'Please use the format (XXX) XXX-XXXX.',
    ];

    protected $listeners = [
        'delete_user' => 'deleteUser',
        'update_user' => 'updateUser',
        'create_view' => 'createUserShow',
        'disable_user' => 'disableUser',
        'able_user' => 'ableUser',
    ];

    public function render()
    {
        $roles = Role::all();
        $this->countyDropdown = County::where("state_id", "=", "CA")->orderBy('county')->get();
        $roles_description = [
            'admin2' => 'Best for business owners and company administrators',
            'developer' => 'Best for developers or people primarily using the API',
            'analyst' => 'Best for people who need full access to analytics data, but don\'t need to update business settings',
            'support' => 'Best for employees who regularly refund payments and respond to disputes',
            'trial' => 'Best for people who need to preview content data, but don\'t need to make any updates',
        ];

        foreach ($roles as $i => $role) {
            $roles[$i]->description = $roles_description[$role->name] ?? '';
        }

        return view('livewire.user.add-user-modal', compact('roles'));
    }

    public function submit()
    {
        if ($this->role === 'county user') {
            $checkRules = $this->rules_for_county_user;
        }elseif($this->role === 'CDSS'){
            $checkRules = $this->rules_for_cdss;
        }else{
            $checkRules = $this->rules;
        }

        $this->validate($checkRules);

        DB::transaction(function () {
            if ($this->edit_mode) {
                $this->updateUserSave();
            } else {
                $this->createUser();
            }
        });

    }
    public function createUserShow(){
        $this->edit_mode = false;
        $this->reset();
    }
    private function createUser(){
        $existingUser = User::where('email', $this->email)->first();

        if ($existingUser) {
            $this->emit('error', 'The email address is already in use by another user!');
            return;
        }
        $data = $this->prepareUserData();
        $data['password'] = Hash::make($this->email);
        $data['status'] = 1;
        $data['first_login'] = true;
        $user = User::create($data);

        $user->assignRole($this->role);
        $user->email_verification_hash = md5(uniqid());
        $user->save();

        // $tokenExpiration = 60 * 24 * 365 * 3;
        // $token = Password::createToken($user, ['expires' => now()->addMinutes($tokenExpiration)]);
        // $actionUrl = url(route('password.reset', ['token' => $token, 'email' => $user->email, 'first_login' => true], false));
        $actionUrl = url(route('verification.verify_first', ['id' => $user->id, 'hash' => $user->email_verification_hash, 'first_login' => true]));
        $data_send_mail = [
            'name' => $user->first_name,
            'link' => $actionUrl,
            'first_login' => true
        ];

        try {
            Mail::to($user->email)->send(new VerifyEmail($data_send_mail));
            $this->emit('success', __('User created successfully'));
        } catch (\Exception $e) {
            Log::error('Error sending email to user: ' . $e->getMessage());
            $this->emit('error', 'User created successfully. However, an error occurred while sending the email verification!');
        }
    }


    private function updateUserSave()
    {
        // Get the user by ID
        $id = $this->idUser;
        $user = User::find($id);
        $checkUser = User::where('email', $this->email)
                ->where('id', '!=', $this->idUser)
                ->first();

        if ($checkUser) {
            $this->emit('error', 'The email address is already in use by another user!');
            return;
        }
        // Prevent modification of the current user's data
        if ($user->id == Auth::id()) {
            $this->emit('error', 'User cannot be updated');
            return;
        }

        if (!$user) {
            $this->emit('error', 'User does not exist');
            return;
        }

        $data = $this->prepareUserData();

        // Update user data
        $user->update($data);

        // Sync roles for the user
        $user->syncRoles($this->role);

        // Emit a success event with a message
        $this->emit('success', __('User updated successfully'));
        $this->reset();
    }

    private function prepareUserData()
    {
        // Prepare the data for creating or updating a user
        $cleanedBusinessPhoneNumber = str_replace(['(', ')', ' ', '-'], '', $this->business_phone);
        $data = [];
        if ($this->county_require == true) {
            $data = [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'business_phone' => $this->business_phone,
                'mailing_address' => $this->mailing_address,
                'vendor_id' => $this->vendor_id,
                'county_designation' => $this->county_designation,
            ];
        }elseif ($this->cdss_county_disable == true) {
            $data = [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'business_phone' => $this->business_phone,
                'mailing_address' => $this->mailing_address,
                'vendor_id' => $this->vendor_id,
            ];
        }else{
            $data = [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
            ];
        }


        if (!$this->edit_mode) {
            $data['password'] = Hash::make($this->email);
        }

        return $data;
    }

    public function deleteUser($id)
    {
        // Prevent deletion of current user
        if ($id == Auth::id()) {
            $this->emit('error', 'User cannot be deleted');
            return;
        }

        // Delete the user record with the specified ID
        User::destroy($id);

        // Emit a success event with a message
        $this->emit('success', 'User successfully deleted');
    }

    public function disableUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            $this->emit('error', 'User not found');
            return;
        }
        // Prevent deletion of current user
        if ($id == Auth::id()) {
            $this->emit('error', 'User cannot be update');
            return;
        }

        // Disable the user record with the specified ID
        User::where('id', $id)->update(['status' => 3]);

        // Emit a success event with a message
        $this->emit('success', 'User successfully disabled');
    }

    public function ableUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            $this->emit('error', 'User not found');
            return;
        }
        // Prevent deletion of current user
        if ($id == Auth::id()) {
            $this->emit('error', 'User cannot be update');
            return;
        }

        // Disable the user record with the specified ID
        User::where('id', $id)->update(['status' => 1]);

        // Emit a success event with a message
        $this->emit('success', 'User successfully activated');
    }

    public function updateUser($id)
    {
        $this->edit_mode = true;

        $user = User::find($id);
        // $this->county = County::where("county_fips", $user->county_designation)->first();
        // if ($this->county) {
        //     $this->stateChose = $this->county->state_id;
        //     $this->updateCountyDropdown();
        // }
        $this->idUser = $user->id;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->business_phone = $user->business_phone;
        $this->mailing_address = $user->mailing_address;
        $this->vendor_id = $user->vendor_id;
        $this->county_designation = $user->county_designation;
        $this->role = $user->roles?->first()->name ?? '';

        $this->updateRole();
    }

    public function updateCountyDropdown()
    {
        $this->countyDropdown = County::where('state_id', $this->stateChose)->get();
    }

    public function resetData()
    {
        $this->reset();
    }

    public function updateRole(){
        if($this->role == "county user"){
            $this->county_require = true;
            $this->cdss_county_disable = false;
        }
        elseif($this->role == "CDSS"){
            $this->county_require = true;
            $this->cdss_county_disable = true;
        }else{
            $this->county_require = false;
            $this->cdss_county_disable = false;
        }
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
