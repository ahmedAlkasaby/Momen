<?php

namespace App\Models;

use App\Enums\TypeUserCodeEnum;
use Illuminate\Database\Eloquent\Model;

class UserCode extends Model
{
    protected $table = 'user_codes';
    protected $fillable = ['user_id', 'email','code','type', 'code_expire'];

    protected $casts = [
        'code_expire' => 'datetime',
        'type'=>TypeUserCodeEnum::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
