<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'group',
        'key',
        'value',
    ];


    public function scopeFilter($query, $request)
    {
        if ($request->has('group') && $request->group != 'all') {
            $query->where('group', $request->group);
        }
        
        return $query;
    }


    
}   
