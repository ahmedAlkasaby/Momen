<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, LaratrustUser
{
    use  HasFactory, Notifiable, SoftDeletes, HasRolesAndPermissions;


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

    public function devices()
    {
        return $this->hasMany(Device::class);
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'email' => $this->email,
            'name' => $this->name
        ];
    }

    public function getNameAttribute()
    {
        return $this->name_first . ' ' . $this->name_last;
    }

     public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id', 'id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id');
    }

    public function notificationsUnread()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id')->whereNull('read_at');
    }
    public function notificationsRead()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id')->whereNotNull('read_at');
    }


    public function markNotificationAsRead($notifications)
    {
        foreach ($notifications as $notification) {
            $notification->update(['read_at' => now()]);
        }
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'user_id', 'id');
    }
    public function totalPriceInCart() // after discount without Shipping and coupon
    {
        return $this->cart->cartItems->sum('total_price');
    }

    public function totalPriceInCartBeforeDiscount(){
        return $this->cart->cartItems->sum('total');   
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function orderItemReturns()
    {
        return $this->hasMany(OrderItemReturn::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
   
    


   
}
