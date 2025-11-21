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
                    $existingImages = $childData['existing_images_to_keep'] ?? [];

                    if (is_string($existingImages) && !empty($existingImages)) {
                        $existingImages = [$existingImages];
                    } else if (!is_array($existingImages)) {
                        $existingImages = [];
                    }
                    $newImages = $childData['images'] ?? [];
                    $newImages = is_array($newImages) ? $newImages : [];
                    $this->handleChildImages($child, $childData['images'] ?? [], $childData['existing_images_to_keep'] ?? []);
                    if (isset($childData['sizes'])) {
                        $child->sizes()->sync($childData['sizes']);
                    }

                    $receivedIds[] = $child->id;
                }
            }

            $product->children()->whereNotIn('id', $receivedIds)->delete();
        });
    }


    protected function handleChildImages(Product $child, array $newImages = [], array $existingImages = []): void
    {

        if (empty($newImages) && empty($existingImages)) {
            return;
        }
        if (!empty($existingImages)) {

            $imagesExistingNames = $child->images()->pluck('image')->toArray();

            $imagesToDelete = array_diff($imagesExistingNames, $existingImages);
            foreach ($imagesToDelete as $image) {
                $this->imageService->deleteImage($image);
                $child->images()->where('image', $image)->delete();
            }
        }
        if (!empty($newImages)) {
            foreach ($newImages as $image) {
                $imageNew = $this->imageService->uploadImage($image, 'products');
                $child->images()->create(['image' => $imageNew]);
            }
        }
    }
}
