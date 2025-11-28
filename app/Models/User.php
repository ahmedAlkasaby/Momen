<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Scopes\MainScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\Casts\Attribute;

use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, LaratrustUser
{
    use  HasFactory, Notifiable, SoftDeletes, HasRolesAndPermissions,MainScope;

      

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

    protected $seachable=[
        'name_first',
        'name_last',
        'email',
        'phone',
    ];


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

  
  


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public  function name()
    {
        return $this->name_first . ' ' . $this->name_last;
       
    }

   

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

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

      public static function listForSelect(
        $type = null,
        $key = 'id',
        $methodValue= 'name',
        $columns = ['id', 'name'],
        $queryBuilder = null,
    ) {
        $query = $queryBuilder ?? static::query();

       

        $query->select($columns);

        $items = $query->get()->mapWithKeys(function ($item) use ($key, $methodValue) {
            return [$item->$key => $item->$methodValue()];
        })->toArray();

        if ($type === 'default') {
            $items = defaultOption() + $items;
        } elseif ($type === 'filter') {
            $items = filterOption() + $items;
        }

        return $items;
    }

    public function scopeTypeFilter($query, $type)
    {
        if ($type) {
            $query->where('type', $type);
        }
        return $query;
    }

    public function scopeFilter($query, $request = null)
    {

        $request = $request ?? request();
        $filters = $request->only(['type', 'active']);
        if(! $request->filled('sort_by')){
            $query->orderNo();
        }

        $query->mainSearch($request->input('search'));
        $query->mainApplyDynamicFilters($filters);

        

        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 'latest':
                    $query->orderByDesc('id');
                    break;
                case 'oldest':
                    $query->orderBy('id', 'asc');
                    break;
            }
        }

        return $query;
    }

   
    


   
}
