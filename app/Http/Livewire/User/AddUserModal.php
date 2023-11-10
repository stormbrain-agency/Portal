<?php

namespace App\Http\Livewire\User;

use App\Models\User;
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
    public $edit_mode = false;

    protected $rules = [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|email',
        'role' => 'required|string',
    ];

    protected $listeners = [
        'delete_user' => 'deleteUser',
        'update_user' => 'updateUser',
    ];

    public function render()
    {
        $roles = Role::all();

        $roles_description = [
            'admin' => 'Best for business owners and company administrators',
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
        $this->validate();

        DB::transaction(function () {
            if ($this->edit_mode) {
                $this->updateUserSave();
            } else {
                $this->createUser();
                $this->reset();
            }
        });

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

        // Password::sendResetLink($user->only('email'));

        $this->emit('success', __('User created successfully'));
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
        $data = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'business_phone' => $this->business_phone,
            'mobile_phone' => $this->mobile_phone,
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

        $this->idUser = $user->id;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->business_phone = $user->business_phone;
        $this->mobile_phone = $user->mobile_phone;
        $this->mailing_address = $user->mailing_address;
        $this->vendor_id = $user->vendor_id;
        $this->county_designation = $user->county_designation;
        $this->role = $user->roles?->first()->name ?? '';
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
