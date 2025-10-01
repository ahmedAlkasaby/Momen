<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCode extends Model
{
    protected $table = 'user_codes';
    protected $fillable = ['user_id', 'email','code', 'code_expire'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
