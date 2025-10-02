<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends MainModel
{
    protected $fillable = [
        'name',
        'content',
        'active',
        'order_id',
        'image'
    ];


    public  function products(){
        return $this->hasMany(Product::class);
    }



    public function scopeFilter($query, $request = null, $type_app = 'app')
    {

        $request = $request ?? request();
        $filters = $request->only(['active']);

       $query->mainSearch($request->input('search'));

        $query->mainApplyDynamicFilters($filters);
    

        if ($request->has('deleted')&& $request->deleted == 1) {
            $query->onlyTrashed();
        }

        return $query;
    }


    public function scopeActive($query)
    {
        return $query->where('active', 1)
            ->orderBy('order_id', 'asc');
    }
}
