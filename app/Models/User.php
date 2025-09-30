<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject,LaratrustUser
{
    use  HasFactory, Notifiable , HasRolesAndPermissions;


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    protected $fillable = [
        'name_first',
        'name_last',
        'email',
        'password',
        'locale',
        'theme',
        'active',
        'phone',
        'vip',
        'is_notify',
        "image",
        'date_of_birth',
        'type',
        'gender',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $seachable = [
        'first_name',
        'last_name',
        'email',
        'phone',
    ];


    public function getJWTIdentifier()
    {
      return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
      return [
        'email'=>$this->email,
        'name'=>$this->name
      ];
    }

    public function getNameAttribute()
    {
        return $this->name_first . ' ' . $this->name_last;
    }


   



}
