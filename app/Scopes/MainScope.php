<?php

namespace App\Scopes;

trait MainScope
{
     public function scopeMainSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        $searchable = property_exists($this, 'searchable') ? $this->searchable : ['name', 'content'];

        $query->where(function ($q) use ($search, $searchable) {
            foreach ($searchable as $column) {
                if (str_contains($column, '.')) {
                    [$relation, $relColumn] = explode('.', $column, 2);
                    $q->orWhereHas($relation, function ($q2) use ($relColumn, $search) {
                        $q2->where($relColumn, 'like', "%{$search}%");
                    });
                } else {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            }
        });

        return $query;
    }

    public function scopeMainApplyDynamicFilters($query, $filters = [])
    {
        foreach ($filters as $column => $value) {
            if (!is_null($value) && $value !== 'all') {
                $query->where($column, $value);
            }
        }

        return $query;
    }

    public function scopeNewest($query)
    {
        return $query->orderByDesc('id');
    }

    public function scopeOldest($query)
    {
        return $query->orderBy('id');
    }

    public function scopeOrderNo($query)
    {
        return $query->orderByRaw('order_id IS NULL')
            ->orderBy('order_id', 'asc');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1)->orderNo();
    }

    public function scopeTrash($query, $request = null)
    {
        if ($request->filled('trash')) {
            if ($request->input('trash') == 'all') {
                $query->withTrashed();
            } else if ($request->input('trash') == '0') {
                $query->onlyTrashed();
            } else {
                $query->withoutTrashed();
            }
        }
        return $query;
    }

}
