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

class AddUserModal extends Component
{
    use WithFileUploads;

    public $first_name;
    public $last_name;
    public $email;
    public $business_phone;
    public $mobile_phone;
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

    protected $rules = [
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'mobile_phone' => ['required', 'string', 'max:255', 'regex:/^\(\d{3}\) \d{3}-\d{4}$/'],
        'role' => 'required|string',
    ];

    protected $rules_for_county_user = [
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'business_phone' => ['required', 'string', 'max:255', 'regex:/^\(\d{3}\) \d{3}-\d{4} ext\. \d{4}$/'],
        'mobile_phone' => ['required', 'string', 'max:255', 'regex:/^\(\d{3}\) \d{3}-\d{4}$/'],
        'mailing_address' => ['required', 'string', 'max:255'],
        'vendor_id' => ['required', 'string', 'max:255'],
        'county_designation' => ['required', 'string', 'max:255'],
        'role' => ['required', 'string'],

    ];

    protected $messages = [
        'business_phone.regex' => 'Please use the format (XXX) XXX-XXXX ext. XXXX.',
        'mobile_phone.regex' => 'Please use the format (XXX) XXX-XXXX.',
    ];

    protected $listeners = [
        'delete_user' => 'deleteUser',
        'update_user' => 'updateUser',
        'create_view' => 'createUserShow',
    ];

    public function render()
    {
        $roles = Role::all();
        $this->states = State::all();
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
        $checkRules = $this->role === 'county user' ? $this->rules_for_county_user : $this->rules;

        $this->validate($checkRules);

        DB::transaction(function () {
            if ($this->edit_mode) {
                $this->updateUserSave();
            } else {
                $this->createUser();
                $this->reset();
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
        $user = User::create($data);
        
        $user->assignRole($this->role);
        $user->email_verified_at = now();
        $user->save();

        try {
            Password::sendResetLink($user->only('email'));
            $this->emit('success', __('User created successfully'));
        } catch (\Exception $e) {
            $this->emit('error', 'Failed to send the password reset email. Please check your email address.');
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
        $cleanedMobilePhoneNumber = str_replace(['(', ')', ' ', '-'], '', $this->mobile_phone);
        $cleanedBusinessPhoneNumber = str_replace(['(', ')', ' ', '-'], '', $this->business_phone);

        // dd($this->business_phone);
        $data = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'business_phone' => $cleanedBusinessPhoneNumber,
            'mobile_phone' => $cleanedMobilePhoneNumber,
            'mailing_address' => $this->mailing_address,
            'vendor_id' => $this->vendor_id,
            'county_designation' => $this->county_designation,
        ];

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

    public function updateUser($id)
    {
        $this->edit_mode = true;

        $user = User::find($id);
        $this->county = County::where("county_fips", $user->county_designation)->first();
        if ($this->county) {
            $this->stateChose = $this->county->state_id;
            $this->updateCountyDropdown();
        }
        $this->idUser = $user->id;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->business_phone = $user->getFormattedBusinessPhoneAttribute();
        $this->mobile_phone = $user->getFormattedMobilePhoneAttribute();
        $this->mailing_address = $user->mailing_address;
        $this->vendor_id = $user->vendor_id;
        $this->county_designation = $user->county_designation;
        $this->role = $user->roles?->first()->name ?? '';

        // dd($this->business_phone);
    }

    public function updateCountyDropdown()
    {
        $this->countyDropdown = County::where('state_id', $this->stateChose)->get();
    }

        public function resetData()
    {
        $this->reset();
    }



    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}