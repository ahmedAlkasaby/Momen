<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
        'validation_rules',
        'locale',
        'autoload',
        'parent_id',
        'order_id',
    ];


    public function scopeFilter($query, $request)
    {
        $query->orderByRaw('order_id IS NULL') 
                     ->orderBy('order_id', 'asc');
        if ($request->has('group') && $request->group != 'all') {
            $query->where('group', $request->group);
        }
        
        return $query;
    }


    
}   
