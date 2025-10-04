<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends MainModel
{
    protected $fillable = [
        'name',
        'title',
        'content',
        'link',
        'image',
        'type',
        'page_type',
        'active',
        'feature',
        'order_id',
        'product_id',
    ];

    public function scopeFilter($query, $request=null,$type_app='app'){
        $request = $request ?? request();
        $filters = $request->only(['parent_id','page_type','type']);
        $type_app == 'app' ?  $query->where('active',1) :  $query->where('active',$request->input('active'));
        $query->orderNo();

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
