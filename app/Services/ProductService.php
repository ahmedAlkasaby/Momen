<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;

class ProductService{

    public function handleProductChildren($request, $product, $parentAttributes = [])
    {
        if (!$request->has('children') || !is_array($request->children)) {
            return;
        }

        if (empty($parentAttributes)) {
            $parentAttributes = Arr::except($product->toArray(), [
                'amount', 'price', 'offer_price', 'offer_percent', 'offer_amount',
                'offer', 'size_id', 'id', 'created_at', 'updated_at',
            ]);
        }

        Model::withoutEvents(function () use ($request, $product, $parentAttributes) {
            foreach ($request->children as $childData) {
                $data = array_merge($parentAttributes, Arr::except($childData, ['id']));
                $data['parent_id'] = $product->id;

                if (isset($childData['id'])) {
                    $child = $product->children()->find($childData['id']);
                    if ($child) {
                        $child->update($data);
                         $receivedIds[] = $child->id;

                    }
                } else {
                    if (isset($childData['size_id']) && isset($childData['amount'])) {
                        $newChild = $product->children()->create($data);
                        $receivedIds[] = $newChild->id;
                    }
                }
            }

            $product->children()->whereNotIn('id', $receivedIds)->delete();

        });
    }
}
