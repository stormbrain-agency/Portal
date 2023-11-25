<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'business_phone',
        'mobile_phone',
        'mailing_address',
        'vendor_id',
        'county_designation',
        'status',
        'w9_file_path',
        'last_login_at',
        'last_login_ip',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    public function isEmailVerified()
    {
        return !is_null($this->email_verified_at);
    }

    public function getFormattedMobilePhoneAttribute()
    {
        $formattedMobilePhone = substr_replace($this->attributes['mobile_phone'], '(', 0, 0);
        $formattedMobilePhone = substr_replace($formattedMobilePhone, ') ', 4, 0);
        $formattedMobilePhone = substr_replace($formattedMobilePhone, '-', 9, 0);

        return $formattedMobilePhone;
    }

    public function getFormattedBusinessPhoneAttribute()
    {
        $formattedBusinessPhone = substr_replace($this->attributes['business_phone'], '(', 0, 0);
        $formattedBusinessPhone = substr_replace($formattedBusinessPhone, ') ', 4, 0);
        $formattedBusinessPhone = substr_replace($formattedBusinessPhone, '-', 9, 0);

        return $formattedBusinessPhone;
    }


    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path) {
            return asset('storage/' . $this->profile_photo_path);
        }

        return $this->profile_photo_path;
    }

    public function w9Upload()
    {
        return $this->hasMany(W9Upload::class, 'user_id', 'id');
    }

    public function county()
    {
        return $this->belongsTo(County::class, 'county_designation', 'county_fips');
    }

    public function paymentReport()
    {
        return $this->hasMany(PaymentReport::class, 'user_id', 'id');
    }
}
