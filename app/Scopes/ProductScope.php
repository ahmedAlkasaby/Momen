<?php

namespace App\Scopes;

trait ProductScope
{
    
   public function scopeActiveProducts($query)
    {
        return $query
            ->where('parent_id', null)
            ->where('active', 1)
            ->where('is_stock', 1)
            ->orderNo();
    }




    public function scopeApplyBasicFilters($query, $request, $type_app)
    {
        $query->orderNo();
        $query->whereNull('parent_id');
        if ($type_app == 'app') {
            $query->activeProducts();
        } else {
            if ($request->filled('active') && $request->active != 'all') {
                $query->where('active', $request->active);
            }
            if ($request->filled('is_stock') && $request->is_stock != 'all') {
                $query->where('is_stock', $request->is_stock);
            }
        }
        return $query;
    }





    public function scopeApplyCategoryFilter($query, $request)
    {
        if ($request->filled('category_id') && $request->category_id != 'all') {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        return $query;
    }

    public function scopeApplyColorFilter($query, $request)
    {
        if ($request->filled('color_id') && $request->color_id != 'all') {
            $query->whereHas('children', function ($q) use ($request) {
                $q->where('color_id', $request->color_id);
            });
        }

        return $query;
    }
    public function scopeApplySizeFilter($query, $request)
    {
        if ($request->filled('size_id') && $request->size_id != 'all') {
            $query->whereHas('children', function ($q) use ($request) {
                $q->whereHas('sizes', function ($q2) use ($request) {
                    $q2->where('size_id', $request->size_id);
                });
            });
        }

        return $query;
    }

   

    public function scopeApplyPriceFilters($query, $request)
    {
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        return $query;
    }










    public function scopeApplyDateFilters($query, $request)
    {
        if ($request->filled('date_start')) {
            $query->where('date_start', '>=', $request->date_start);
        }

        if ($request->filled('date_end')) {
            $query->where('date_end', '<=', $request->date_end);
        }

        return $query;
    }





    public function scopeApplySorting($query, $request)
    {
        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 'latest':
                    $query->orderByDesc('id');
                    break;
                case 'oldest':
                    $query->orderBy('id', 'asc');
                    break;
                case 'highest_price':
                    $query->orderBy('price', 'desc');
                    break;
                case 'lowest_price':
                    $query->orderBy('price', 'asc');
                    break;
            }
        }
        return $query;
    }






    public function scopeFilter($query, $request = null, $type_app = 'app')
    {
        $request = $request ?? request();



        $filters = $request->only([
            // relations
            'brand_id',
            'unit_id',
            // status flags
            
            'active',
            'is_stock',
            'is_filter',
            'is_offer',
            'is_new',
            'is_special',

            'is_size',
            'is_color',
            'is_shipping_free',
            'is_returned'
        ]);


        return $query
            ->applyBasicFilters($request, $type_app)
            ->mainSearch($request->input('search'))
            ->mainApplyDynamicFilters($filters)
            ->applyCategoryFilter($request)
            ->applyColorFilter($request)
            ->applySizeFilter($request)
            ->applyPriceFilters($request)
            ->applySorting($request)
            ->applyDateFilters($request)
            ->trash($request)
        ;
    }

}
