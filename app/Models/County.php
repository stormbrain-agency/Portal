<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    use HasFactory;

    protected $fillable = [
        'county',
        'county_ascii',
        'county_full',
        'county_fips',
        'state_id',
        'state_name',
        'lat',
        'lng',
        'population',
    ];

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'state_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'county_fips', 'county_designation');
    }

}
