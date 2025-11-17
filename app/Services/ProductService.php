<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;

class ProductService
{
    private $imageService;
    public function __construct(ImageHandlerService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function handleProductChildren($request, $product, $parentAttributes = [])
    {
        if (!$request->has('children') || !is_array($request->children)) {
            return;
        }
        
        if (empty($parentAttributes)) {
            $parentAttributes = Arr::except($product->toArray(), [
                'price',
                'offer_price',
                'is_offer',
                'color_id',
                'size_id',
                'id',
                'created_at',
                'updated_at',
            ]);
        }
        
        Model::withoutEvents(function () use ($request, $product, $parentAttributes) {
            $receivedIds = [];

            foreach ($request->children as $childData) {
                $data = array_merge($parentAttributes, Arr::except($childData, ['id']));
                $data['parent_id'] = $product->id;
                
                $child = null;

                if (isset($childData['id'])) {
                    $child = $product->children()->find($childData['id']);
                    if ($child) {
                        $child->update($data);
                    }
                }

                if (!$child) {
                    if (isset($childData['color_id']) && isset($childData['price'])) {
                        $child = $product->children()->create($data);
                    }
                }

                if ($child) {
                    if (isset($childData['images']) && is_array($childData['images'])) {
                        $this->handleChildImages($child, $childData['images']);
                    }

                    if (isset($childData['sizes']) && is_array($childData['sizes'])) {
                        $child->sizes()->sync($childData['sizes']);
                    }

                    $receivedIds[] = $child->id;
                }
            }

            $product->children()->whereNotIn('id', $receivedIds)->delete();
        });
    }


    protected function handleChildImages(Product $child, array $imageData): void
    {
        if ($child -> images()->count() > 0) {
            $childImages= $child->images()->get();
            foreach ($childImages as $image) {
                $this->imageService->deleteImage($image->image);
            }
            $child->images()->delete();
        } 
        
        
        
        foreach ($imageData as $file) {
            $image = $this->imageService->uploadImage($file,'products');
            
            $child->images()->create(['image' => $image ]);
        }

       
    }
}
